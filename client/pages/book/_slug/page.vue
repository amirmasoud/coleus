<template>
  <div v-if="book" class="flex flex-wrap">
    <div :class="{'hidden': !showMenu }" class="w-full lg:w-1/4 pl-2 sticky self-start lg:block">
      <div v-if="book" class="rounded p-3 bg-white overflow-y-auto overflow-x-hidden h-screen-93">
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
              <strong v-if="item.is_header" class="block py-2 px-4 mb-1" @click.prevent="closeMenu">{{ item.title }}</strong>
              <NuxtLink
                v-else
                class="no-underline text-black block py-2 px-2 rounded-sm mb-1 hover:bg-grey-lightest hover:shadow transition-delay-none transition"
                :class="{ 'font-bold border-r-2 border-blue-light bg-grey-lightest': item.id == $route.params.id }"
                :to="{ name: 'book-slug-page-id', params: { slug: $route.params.slug, id: item.id }}"
                @click.native="closeMenu"
              >
                {{ item.title }}
              </NuxtLink>
            </DynamicScrollerItem>
          </template>
        </DynamicScroller>
      </div>
    </div>

    <div :class="{'hidden': showMenu }" class="w-full lg:w-3/4 mt-2 lg:block">
      <NuxtChild keep-alive />
    </div>
  </div>
  <oval-loader v-else />
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
.book-contents::-webkit-scrollbar {
  width: 0.3rem;
  background-color: #f9fbfc;
}
.book-contents::-webkit-scrollbar-thumb {
  background-color: #6cb2eb;
}
</style>
