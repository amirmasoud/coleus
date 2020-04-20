<template>
  <aside
    :class="{ 'opacity-25': false }"
    class="opacity-transition block bg-white mt-8 -mx-4 lg:bg-transparent lg:mt-0 lg:mx-0 lg:inset-0 z-90 lg:mb-0 lg:static lg:h-auto lg:overflow-y-visible lg:pt-0 lg:w-1/4 lg:block"
  >
    <div
      class="h-full overflow-y-auto scrolling-touch text-center lg:text-right lg:h-auto lg:block lg:relative lg:sticky lg:top-24"
    >
      <a class="block text-right p-4 lg:hidden" href="#nav" @click.prevent="showNav = !showNav">
        <coleus-times v-if="showNav" class="float-right mt-1 mr-1 h-5" />
        <coleus-caret-down v-else class="float-right mt-2 mr-1" />
        <span class="uppercase text-gray-500 ml-1">Group :</span>
        Title
      </a>
      <nav
        id="test"
        class="pt-8 lg:overflow-y-auto lg:block lg:pl-0 lg:pr-8 sticky?lg:h-(screen-24)"
        :class="{ hidden: !showNav }"
      >
        <div v-if="books && books.length">
          <template v-for="(page, index) in books[0].pages">
            <h3
              :key="`title-${index}`"
              :id="`page-${page.id}`"
              class="uppercase text-gray-500 pb-2"
            >
              <a
                :href="`/${$route.params.username}/${$route.params.book}/${page.id}`"
                @click.prevent="fetchChildren(page.id)"
              >
                <component class="float-right mt-2 ml-1" :is="isOpen(page)"></component>
                {{ page.title }}
              </a>
            </h3>
            <ul v-if="showChildren(page.id)" :key="`list-${index}`" class="pb-8 md:pr-4">
              <li
                v-for="subpage in pages"
                :key="subpage.id"
                :id="`page-${subpage.id}`"
                @click.prevent="scrollTo(subpage.id)"
                class="py-2"
              >
                <a
                  class="text-gray-700 hover:text-indigo-400 cursor-pointer"
                  :class="{'text-indigo-500': isCurrentPage(subpage.id) && !loading, 'text-indigo-400': isCurrentPage(subpage.id) && loading}"
                  @click.prevent="fetchContent(subpage.id)"
                  :href="`/${$route.params.username}/${$route.params.book}/${parent}/${subpage.id}`"
                >
                  {{ subpage.title }}
                  <coleus-spinner
                    v-if="isCurrentPage(subpage.id) && loading"
                    class="float-right w-6 -mr-8 -mt-2 sticky"
                  />
                </a>
              </li>
            </ul>
          </template>
        </div>
      </nav>
    </div>
  </aside>
</template>

<script>
import throttle from 'lodash/throttle'
import coleusCaretDown from '@/components/svg/CaretDown'
import coleusCaretLeft from '@/components/svg/CaretLeft'
import coleusTimes from '@/components/svg/Times'
import coleusAsideSpinner from '@/components/partials/AsideSpinner'

const pageSize = 10

export default {
  props: {
    loading: Boolean
  },
  components: {
    coleusCaretDown,
    coleusCaretLeft,
    coleusTimes,
    coleusAsideSpinner
  },
  data: () => ({
    current: 0,
    setInter: null,
    showNav: false,
    currentPage: 0,
    offset: 0,
    parent: null,
    parentLoading: false
  }),
  apollo: {
    books: {
      query: require('~/graphql/aside.gql'),
      prefetch: ({ route }) => ({ book: route.params.book }),
      variables() {
        return { book: this.$route.params.book }
      }
    },
    pages: {
      debounce: 300,
      query: require('~/graphql/children.gql'),
      prefetch: ({ route }) => ({
        parent: parseInt(route.params.parent),
        offset: 0
      }),
      variables() {
        return { parent: this.parent, offset: this.offset }
      },
      result({ data, loading, error }) {
        if (process.client) {
          this.addHashToLocation(
            `/${this.$route.params.username}/${this.$route.params.book}/${this.parent}/${data.pages[0].id}`
          )
        }
      },
      update(data) {
        this.parentLoading = false
        return data.pages
      }
    }
  },
  watch: {
    parent(newParent, oldParent) {
      this.parentLoading = true
    }
  },
  mounted() {
    this.parent = this.$route.params.parent
  },
  computed: {
    breadcrumb() {
      let breadcrumb = null
      if (this.books && this.books.length) {
        this.books[0].pages.forEach((group) => {
          group.pages.forEach((link) => {
            breadcrumb = { group: group.title, title: link.title }
          })
        })
      }
      return breadcrumb
    }
  },
  methods: {
    showChildren(pageId) {
      return pageId == parseInt(this.parent)
    },
    fetchChildren(newParent) {
      if (this.parent != newParent) {
        this.parent = newParent
        this.pages = []
      }
    },
    isOpen(page) {
      if (this.parentLoading && page.id == parseInt(this.parent)) {
        return 'coleus-aside-spinner'
      } else if (!this.parentLoading && page.id == parseInt(this.parent)) {
        return 'coleus-caret-down'
      } else {
        return 'coleus-caret-left'
      }
    },
    scrollToTop() {
      const c = document.documentElement.scrollTop || document.body.scrollTop
      if (c > 0) {
        window.scrollTo({ top: 0, behavior: 'smooth' })
      }
    },
    isCurrentPage(id) {
      return (
        (this.currentPage == 0
          ? parseInt(this.$route.params.page)
          : this.currentPage) == id
      )
    },
    addHashToLocation(params) {
      history.pushState({}, null, params)
    },
    fetchContent(page) {
      this.currentPage = parseInt(page)
      this.addHashToLocation(
        `/${this.$route.params.username}/${this.$route.params.book}/${this.parent}/${page}`
      )
      this.$root.$emit('content-changed', page)
      this.scrollToTop()
    },
    toggle() {},
    scrollTo(id) {}
  }
}
</script>

<style lang="scss">
.list-complete-item {
  transition: all 1s;
  display: inline-block;
  margin-right: 10px;
}
.list-complete-enter, .list-complete-leave-to
/* .list-complete-leave-active below version 2.1.8 */ {
  opacity: 0;
  transform: translateY(30px);
}
.list-complete-leave-active {
  position: absolute;
}
</style>
