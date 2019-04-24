<template>
  <div v-if="book" class="flex flex-wrap">
    <div
      :class="{'hidden': !showMenu }"
      class="w-full max-w-full lg:w-1/4 lg:max-w-xs fixed self-start lg:block border-l border-gainsboro"
    >
      <div
        v-if="book"
        class="rounded py-3 bg-floral-white overflow-y-auto overflow-x-hidden h-screen-93"
      >
        <DynamicScroller
          :items="book.pages"
          :prerender="100"
          :min-item-size="54"
          class="h-full book-contents"
        >
          <template slot-scope="{ item, index, active }">
            <DynamicScrollerItem
              :item="item"
              :active="active"
              :size-dependencies="[ item.title ]"
              :data-index="index"
            >
              <strong
                v-if="item.is_header"
                class="block py-2 px-4 mb-1 text-davys-grey"
                @click.prevent="closeMenu"
              >{{ item.title }}</strong>
              <NuxtLink
                v-else
                class="no-underline text-davys-grey block py-2 px-2 hover:text-smoky-black-dark"
                :class="{ 'font-bold border-l-4 border-sweet-brown text-smoky-black-dark bg-smoky-black': item.id == $route.params.id }"
                :to="{ name: 'book-slug-page-id', params: { slug: $route.params.slug, id: item.id }}"
                @click.native="closeMenu"
              >{{ item.title }}</NuxtLink>
            </DynamicScrollerItem>
          </template>
        </DynamicScroller>
      </div>
    </div>

    <div :class="{'hidden': showMenu }" class="w-full ml-0 lg:w-3/4 lg:mr-1/4 mt-2 lg:block">
      <NuxtChild keep-alive/>
    </div>
  </div>
  <oval-loader v-else/>
</template>

<script>
import 'vue-virtual-scroller/dist/vue-virtual-scroller.css'
import { DynamicScroller, DynamicScrollerItem } from 'vue-virtual-scroller'

export default {
  components: { DynamicScroller, DynamicScrollerItem },

  data: () => ({
    showMenu: false
  }),

  created() {
    this.$root.$on('open-menu', this.openMenu)
    this.$root.$on('close-menu', this.closeMenu)
  },

  apollo: {
    book: {
      query: require('~/graphql/book.gql'),
      prefetch: ({ route }) => ({ slug: route.params.slug }),
      variables() {
        return { slug: this.$route.params.slug }
      }
    }
  },

  methods: {
    openMenu() {
      this.showMenu = true
    },

    closeMenu() {
      this.$root.$emit('close-menu-after-click')
      this.showMenu = false
    }
  }
}
</script>

<style scoped>
.book-contents {
  direction: ltr;
  text-align: center;
}
.book-contents a {
  direction: rtl !important;
  text-align: right;
}
.book-contents::-webkit-scrollbar {
  width: 0.3rem;
  background-color: #d6d9dc;
}
.book-contents::-webkit-scrollbar-thumb {
  background-color: #ae3737;
}
</style>
