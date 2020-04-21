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
            <div
              v-if="showChildren(page.id) && !loadingParent"
              class="pagination flex flex-wrap my-3 md:mr-3"
              :key="`pagination-${index}`"
            >
              <div class="w-1/6">
                <a
                  href="#"
                  @click.prevent="prevPage()"
                  :disabled="paginateCurrentPage == 1"
                  class="flex justify-around bg-white border border-gray-400 text-gray-800 shadow h-8 w-8 rounded-full hover:shadow-md"
                  :class="{ 'pagination-link-disabled': paginateCurrentPage == 1 }"
                >
                  <coleus-spinner v-if="loadingPrevPage" class="self-center p-1" />
                  <coleus-caret-right v-else class="self-center" />
                </a>
              </div>
              <div class="w-1/6">
                <a
                  href="#"
                  @click.prevent="nextPage()"
                  :disabled="paginateCurrentPage == paginateTotalPages"
                  class="flex justify-around bg-white border border-gray-400 text-gray-800 shadow h-8 w-8 rounded-full hover:shadow-md"
                  :class="{ 'pagination-link-disabled': paginateCurrentPage == paginateTotalPages }"
                >
                  <coleus-spinner v-if="loadingNextPage" class="self-center p-1" />
                  <coleus-caret-left v-else class="self-center" />
                </a>
              </div>
              <div
                class="w-2/3 text-right text-gray-500 pr-2"
              >صفحه {{ paginateCurrentPage }} از {{ paginateTotalPages }}</div>
            </div>
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
import coleusCaretRight from '@/components/svg/CaretRight'
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
    coleusCaretRight,
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
    loadingParent: false,
    loadingNextPage: false,
    loadingPrevPage: false,
    pagesAggregateCount: 0,
    paginateTotal: 0,
    paginateTotalItems: 0,
    paginateCurrentPage: 1,
    paginateNextPage: 1,
    paginatePrevPage: 1,
    paginateTotalPages: 1,
    paginateHasMore: false,
    paginateNextOffset: 0,
    paginatePrevOffset: 0
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
            `/${this.$route.params.username}/${this.$route.params.book}/${this.parent}/${this.currentPage}/?page=${this.paginateCurrentPage}`
          )
        }
      },
      update(data) {
        this.loadingParent = false
        this.loadingNextPage = false
        this.loadingPrevPage = false
        this.pagesAggregateCount = data.pages_aggregate.aggregate.count
        this.calculatePagination()
        return data.pages
      }
    }
  },
  watch: {
    parent(newParent, oldParent) {
      this.loadingParent = true
    },
    offset(newOffset, oldOffset) {
      if (newOffset > oldOffset) {
        this.loadingNextPage = true
      }

      if (newOffset < oldOffset) {
        this.loadingPrevPage = true
      }
    }
  },
  mounted() {
    this.parent = this.$route.params.parent
    this.offset = (parseInt(this.$route.query.page || 1) - 1) * 10
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
    prevPage() {
      if (this.paginatePrevPage != this.paginateCurrentPage) {
        this.offset -= 10
      }
    },
    nextPage() {
      if (this.paginateNextPage != this.paginateCurrentPage) {
        this.offset += 10
      }
    },
    calculatePagination() {
      this.paginateTotal = this.pagesAggregateCount
      this.paginateTotalPages = Math.ceil(this.paginateTotal / 10)
      this.paginateCurrentPage = Math.ceil(this.offset / 10) + 1
      this.paginateNextPage =
        this.paginateCurrentPage <= this.paginateTotalPages
          ? this.paginateCurrentPage + 1
          : this.paginateNextPage
      this.paginatePrevPage =
        Math.ceil(this.offset / 10) > 0 &&
        Math.ceil(this.offset / 10) < this.paginateTotalPages
          ? this.paginateCurrentPage - 1
          : this.paginatePrevPage
      this.paginateTotalPages = this.paginateTotalPages
      this.paginateHasMore = this.totalPages - 10 - this.offset * 10 > 0
      this.paginateNextOffset =
        this.totalPages - 10 - this.offset * 10 > 0
          ? this.offset + 10
          : this.paginateNextOffset
      this.paginatePrevOffset =
        this.totalPages - 10 <= 0 ? this.offset - 10 : this.paginatePrevOffset
    },
    showChildren(pageId) {
      return pageId == parseInt(this.parent)
    },
    fetchChildren(newParent) {
      if (this.parent != newParent) {
        this.parent = newParent
        this.pages = []

        this.offset = 0
        this.paginateTotal = 0
        this.paginateTotalItems = 0
        this.paginateCurrentPage = 1
        this.paginateNextPage = 1
        this.paginatePrevPage = 1
        this.paginateTotalPages = 1
        this.paginateHasMore = false
        this.paginateNextOffset = 0
        this.paginatePrevOffset = 0
      }
    },
    isOpen(page) {
      if (this.loadingParent && page.id == parseInt(this.parent)) {
        return 'coleus-aside-spinner'
      } else if (!this.loadingParent && page.id == parseInt(this.parent)) {
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
        `/${this.$route.params.username}/${this.$route.params.book}/${this.parent}/${page}/?page=${this.paginateCurrentPage}`
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
.pagination-link-disabled {
  @apply bg-gray-200 text-gray-400 border-gray-300 shadow-none cursor-not-allowed;
}
</style>
