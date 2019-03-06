<template>
  <div class="flex flex-wrap" v-if="book">
    <div :class="{'hidden': !showMenu }" class="w-full lg:w-1/4 mt-2 pl-2 sticky self-start lg:block" style="top: 72px;">
      <div class="book-contents rounded overflow-hidden p-3 bg-white overflow-y-auto overflow-x-hidden h-screen-91" v-if="book">
        <no-ssr>
          <DynamicScroller
            :items="book.pages"
            :prerender="100"
            :min-item-size="54"
            ref="scroller"
          >
            <template slot-scope="{ item, index, active }">
              <DynamicScrollerItem
                :item="item"
                :active="active"
                :size-dependencies="[ item.title ]"
                :data-index="index"
              >
                <strong v-if="item.is_header" @click.prevent="closeMenu" class="block py-2 px-4 mb-1">{{ item.title }}</strong>
                <NuxtLink
                  v-else
                  class="no-underline text-black block py-2 px-4 border border-transparent rounded-sm mb-1 hover:bg-grey-lightest transition-delay-none transition-timing-linear transition-property-bg transition-fast"
                  :class="{ 'bg-grey-lightest font-bold border border-grey-light': item.id == $route.params.id }"
                  :to="{ name: 'book-slug-page-id', params: { slug: $route.params.slug, id: item.id }}"
                  @click.native="closeMenu"
                >
                  {{ item.title }}
                </NuxtLink>
              </DynamicScrollerItem>
            </template>
          </DynamicScroller>
        </no-ssr>
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
}
.book-contents::-webkit-scrollbar-thumb {
  background-color: #a2a2a2;
}
</style>
