<template>
  <aside
    class="block bg-gray-200 mt-8 -mx-4 lg:mt-0 lg:mx-0 lg:inset-0 z-90 lg:mb-0 lg:static lg:h-auto lg:overflow-y-visible lg:pt-0 lg:w-1/4 lg:block"
  >
    <div
      class="h-full overflow-y-auto scrolling-touch text-center lg:text-right lg:h-auto lg:block lg:relative lg:sticky lg:top-24 lg:mt-2"
    >
      <nav
        id="test"
        class="lg:overflow-y-auto lg:block lg:pl-0 lg:px-2 sticky?lg:h-(screen-24)"
      >
        <div v-if="books && books.length">
          <template class="flex" v-for="(page, index) in books[0].pages">
            <button
              type="button"
              @click.prevent="toggleHeader(page.id)"
              :key="`icon-${index}`"
            >
              <component
                class="mt-2 ml-1"
                :is="headerIcon(page.id)"
              ></component>
              <h3 class="text-gray-900 pb-2">
                {{ page.title }}
              </h3>
            </button>
            <div
              v-if="isExpanded(page.id)"
              :key="`pagination-${index}`"
              class="pagination flex flex-wrap"
            >
              <ul :key="`list-${index}`" class="pb-4 md:pr-4">
                <li
                  v-for="subpage in pages"
                  :id="`page-${subpage.id}`"
                  :key="subpage.id"
                  class="py-2"
                >
                  <nuxt-link :to="pageLink(subpage.id)">
                    {{ subpage.title }}
                  </nuxt-link>
                </li>
              </ul>
            </div>
          </template>
        </div>
        <!-- <div v-if="books && books.length">
          <template v-for="(page, index) in books[0].pages">
            <h3
              :id="`page-${page.id}`"
              :key="`title-${index}`"
              class="text-gray-900 pb-2"
            >
              <a
                :href="
                  `/${$route.params.username}/${$route.params.book}/${page.id}`
                "
                @click.prevent="fetchChildren(page.id)"
              >
                <component
                  :is="isOpen(page)"
                  class="float-right mt-2 ml-1"
                ></component>
                {{ page.title }}
              </a>
            </h3>
            <div
              v-if="showChildren(page.id) && !loadingParent"
              :key="`pagination-${index}`"
              class="pagination flex flex-wrap"
            >
              <div class="w-1/6">
                <a
                  href="#"
                  :disabled="paginateCurrentPage == 1"
                  class="flex justify-around text-gray-800 h-8 w-8"
                  :class="{
                    'pagination-link-disabled': paginateCurrentPage == 1
                  }"
                  @click.prevent="prevPage()"
                >
                  <coleus-spinner
                    v-if="loadingPrevPage"
                    class="self-center p-1"
                  />
                  <coleus-caret-right v-else class="self-center" />
                </a>
              </div>
              <div class="w-2/3 text-right text-gray-900">
                <input
                  v-model="paginateCurrentPage"
                  class="inline w-24 py-1 px-2 border-b border-gray-400 focus:border-indigo-400"
                  type="number"
                  @input="throttledCurrentPage"
                />
                <span> از </span> {{ paginateTotalPages }}
              </div>
              <div class="w-1/6">
                <a
                  href="#"
                  :disabled="paginateCurrentPage == paginateTotalPages"
                  class="flex justify-around text-gray-800 h-8 w-8"
                  :class="{
                    'pagination-link-disabled':
                      paginateCurrentPage == paginateTotalPages
                  }"
                  @click.prevent="nextPage()"
                >
                  <coleus-spinner
                    v-if="loadingNextPage"
                    class="self-center p-1"
                  />
                  <coleus-caret-left v-else class="self-center" />
                </a>
              </div>
            </div>
            <ul
              v-if="showChildren(page.id)"
              :key="`list-${index}`"
              class="pb-4 md:pr-4"
            >
              <li
                v-for="subpage in pages"
                :id="`page-${subpage.id}`"
                :key="subpage.id"
                class="py-2"
              >
                <nuxt-link
                  :to="{
                    name: 'username-book-parent-page',
                    params: {
                      username: $route.params.username,
                      book: $route.params.book,
                      parent: $route.params.parent,
                      page: subpage.id
                    },
                    query: { page: $route.query.page }
                  }"
                >
                  {{ subpage.title }}
                </nuxt-link>
                <a
                  class="text-gray-700 hover:text-indigo-400 cursor-pointer"
                  :class="{
                    'text-indigo-500': isCurrentPage(subpage.id) && !loading,
                    'text-indigo-400': isCurrentPage(subpage.id) && loading
                  }"
                  @click.prevent="currentPage = subpage.id"
                >
                  {{ subpage.title }}
                  <coleus-spinner
                    v-if="isCurrentPage(subpage.id) && loading"
                    class="float-right w-6 -mr-4 -mt-2 p-1 sticky"
                  />
                </a>
              </li>
            </ul>
          </template>
        </div> -->
      </nav>
    </div>
  </aside>
</template>

<script>
// import _ from 'lodash'
import coleusCaretDown from '@/components/svg/CaretDown'
import coleusCaretLeft from '@/components/svg/CaretLeft'
// import coleusCaretRight from '@/components/svg/CaretRight'
// import coleusTimes from '@/components/svg/Times'
// import coleusAsideSpinner from '@/components/partials/AsideSpinner'

export default {
  components: {
    coleusCaretDown,
    coleusCaretLeft
    // coleusCaretRight,
    // coleusTimes,
    // coleusAsideSpinner
  },

  props: {
    loading: Boolean
  },

  data: () => ({
    // fresh: true,
    // current: 0,
    // setInter: null,
    // showNav: false,
    // currentPage: 0,
    // offset: 0,
    // parent: null,
    // loadingParent: false,
    // loadingNextPage: false,
    // loadingPrevPage: false,
    // pagesAggregateCount: 0,
    // paginateTotal: 0,
    // paginateTotalItems: 0,
    // paginateCurrentPage: 1,
    // paginateNextPage: 1,
    // paginatePrevPage: 1,
    // paginateTotalPages: 1,
    // paginateHasMore: false,
    // paginateNextOffset: 0,
    // paginatePrevOffset: 0
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
      query: require('~/graphql/children.gql'),
      prefetch: ({ route }) => ({
        parent: parseInt(route.params.parent),
        offset: 0
      }),
      variables() {
        return { parent: this.$route.params.parent, offset: 0 }
      }
      // update(data) {
      //   this.loadingParent = false
      //   this.loadingNextPage = false
      //   this.loadingPrevPage = false
      //   this.pagesAggregateCount = data.pages_aggregate.aggregate.count
      //   this.calculatePagination()
      //   return data.pages
      // }
    }
  },
  watch: {
    // currentPage(newPage, oldPage) {
    //   this.fetchContent(newPage, this.parent)
    // },
    // parent(newParent, oldParent) {
    //   this.loadingParent = true
    // },
    // offset(newOffset, oldOffset) {
    //   if (newOffset > oldOffset) {
    //     this.loadingNextPage = true
    //   }
    //   if (newOffset < oldOffset) {
    //     this.loadingPrevPage = true
    //   }
    // }
  },
  mounted() {
    // this.currentPage = this.$route.params.page
    // this.parent = this.$route.params.parent
    // this.offset = (parseInt(this.$route.query.page || 1) - 1) * 10
  },
  methods: {
    /**
     * Determine if current header item is expanded or collapsed.
     *
     * @param {number} pageId
     * @return {boolean}
     */
    isExpanded(pageId) {
      return parseInt(pageId) === parseInt(this.$route.params.parent)
    },

    /**
     * Return caret down or caret left based on header item collapsed/epanded
     * state.
     *
     * @param {number} pageId
     * @return {string}
     */
    headerIcon(pageId) {
      if (this.isExpanded(pageId)) {
        return 'coleus-caret-down'
      } else {
        return 'coleus-caret-left'
      }
    },

    /**
     * toggle a header with a given pageId.
     *
     * @param {number} pageId
     * @return {void}
     */
    toggleHeader(pageId) {
      this.$route.params.parent = pageId
    },

    /**
     * Generate link for each contents items.
     *
     * @param {number} subPageId
     * @return {Object}
     */
    pageLink(subPageId) {
      return {
        name: 'username-book-parent-page',
        params: {
          username: this.$route.params.username,
          book: this.$route.params.book,
          parent: this.$route.params.parent,
          page: subPageId
        },
        query: { page: this.$route.query.page }
      }
    }
    // throttledCurrentPage: _.debounce(function(e) {
    //   if (
    //     !isNaN(e.target.value) &&
    //     e.target.value > 0 &&
    //     e.target.value <= this.paginateTotalPages
    //   ) {
    //     this.offset = (e.target.value - 1) * 10
    //   }
    // }, 300),
    // prevPage() {
    //   if (this.paginatePrevPage !== this.paginateCurrentPage) {
    //     this.offset -= 10
    //   }
    // },
    // nextPage() {
    //   if (this.paginateNextPage !== this.paginateCurrentPage) {
    //     this.offset += 10
    //   }
    // },
    // calculatePagination() {
    //   this.paginateTotal = this.pagesAggregateCount
    //   this.paginateTotalPages = Math.ceil(this.paginateTotal / 10)
    //   this.paginateCurrentPage = Math.ceil(this.offset / 10) + 1
    //   this.paginateNextPage =
    //     this.paginateCurrentPage <= this.paginateTotalPages
    //       ? this.paginateCurrentPage + 1
    //       : this.paginateNextPage
    //   this.paginatePrevPage =
    //     Math.ceil(this.offset / 10) > 0 &&
    //     Math.ceil(this.offset / 10) < this.paginateTotalPages
    //       ? this.paginateCurrentPage - 1
    //       : this.paginatePrevPage
    //   const newPaginateTotalPages = this.paginateTotalPages
    //   this.paginateTotalPages = newPaginateTotalPages
    //   this.paginateHasMore = this.totalPages - 10 - this.offset * 10 > 0
    //   this.paginateNextOffset =
    //     this.totalPages - 10 - this.offset * 10 > 0
    //       ? this.offset + 10
    //       : this.paginateNextOffset
    //   this.paginatePrevOffset =
    //     this.totalPages - 10 <= 0 ? this.offset - 10 : this.paginatePrevOffset
    // },
    // showChildren(pageId) {
    //   return pageId === parseInt(this.parent)
    // },
    // fetchChildren(newParent) {
    //   if (this.parent !== newParent) {
    //     this.parent = newParent
    //     this.pages = []
    //     this.offset = 0
    //     this.paginateTotal = 0
    //     this.paginateTotalItems = 0
    //     this.paginateCurrentPage = 1
    //     this.paginateNextPage = 1
    //     this.paginatePrevPage = 1
    //     this.paginateTotalPages = 1
    //     this.paginateHasMore = false
    //     this.paginateNextOffset = 0
    //     this.paginatePrevOffset = 0
    //   }
    // },
    // isOpen(page) {
    //   if (this.loadingParent && page.id === parseInt(this.parent)) {
    //     return 'coleus-aside-spinner'
    //   } else if (!this.loadingParent && page.id === parseInt(this.parent)) {
    //     return 'coleus-caret-down'
    //   } else {
    //     return 'coleus-caret-left'
    //   }
    // },
    // scrollToTop() {
    //   const c = document.documentElement.scrollTop || document.body.scrollTop
    //   if (c > 0) {
    //     window.scrollTo({ top: 0, behavior: 'smooth' })
    //   }
    // },
    // isCurrentPage(id) {
    //   return (
    //     (this.currentPage === 0
    //       ? parseInt(this.$route.params.page)
    //       : this.currentPage) === id
    //   )
    // },
    // fetchContent(page, parent) {
    //   // this.currentPage = parseInt(page)
    //   this.$root.$emit('content-changed', page, parent)
    //   this.scrollToTop()
    // }
  }
}
</script>

<style lang="scss">
.pagination-link-disabled {
  @apply text-gray-400 border-gray-200 shadow-none cursor-not-allowed;
}
</style>
