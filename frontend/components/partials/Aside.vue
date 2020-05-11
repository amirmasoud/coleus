<template>
  <aside
    class="block bg-gray-100 mt-8 -mx-4 lg:mt-0 lg:mx-0 lg:inset-0 z-90 lg:mb-0 lg:static lg:h-auto lg:overflow-y-visible lg:pt-0 lg:w-1/4 lg:block"
  >
    <div
      class="h-full overflow-y-auto scrolling-touch lg:text-right lg:h-auto lg:block lg:relative lg:sticky lg:top-24 lg:mt-2"
    >
      <nav
        class="lg:overflow-y-auto lg:block lg:pl-0 lg:px-2 sticky?lg:h-(screen-24)"
      >
        <div v-if="books && books.length">
          <template v-for="(page, index) in books[0].pages" class="flex">
            <button
              class="flex text-right"
              type="button"
              :key="`icon-${index}`"
              @click.prevent="toggleHeader(page.id)"
            >
              <component
                :is="headerIcon(page.id)"
                class="mt-2 ml-1"
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
              <div class="w-1/6">
                <button
                  type="button"
                  :disabled="paginateCurrentPage == 1"
                  class="flex justify-around text-gray-800 h-8 w-8"
                  :class="{
                    'pagination-link-disabled': paginateCurrentPage == 1
                  }"
                  @click="goToPrevPage"
                >
                  <coleus-spinner v-if="loadingPrevPage" class="self-center" />
                  <coleus-caret-right v-else class="self-center" />
                </button>
              </div>
              <div class="w-2/3 text-right text-gray-900">
                <input
                  :value="paginateCurrentPage"
                  class="inline w-24 py-1 px-2 border-b border-gray-400 focus:border-indigo-400 font-sans"
                  type="number"
                  min="1"
                  :max="paginateTotalPages"
                  @input="throttledCurrentPage"
                />
                <span> از </span
                ><span class="font-sans">{{ paginateTotalPages }}</span>
              </div>
              <div class="w-1/6">
                <button
                  type="button"
                  :disabled="paginateCurrentPage == paginateTotalPages"
                  class="flex justify-around text-gray-800 h-8 w-8"
                  :class="{
                    'pagination-link-disabled':
                      paginateCurrentPage == paginateTotalPages
                  }"
                  @click="goToNextPage"
                >
                  <coleus-spinner v-if="loadingNextPage" class="self-center" />
                  <coleus-caret-left v-else class="self-center" />
                </button>
              </div>

              <ul
                :key="`list-${index}`"
                class="pb-2 pr-3 mr-2 border-r border-gray-400"
              >
                <li
                  v-for="subpage in pages"
                  :id="`page-${subpage.id}`"
                  :key="subpage.id"
                  class="py-1"
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
import _ from 'lodash'
import coleusCaretDown from '@/components/svg/CaretDown'
import coleusCaretLeft from '@/components/svg/CaretLeft'
import coleusCaretRight from '@/components/svg/CaretRight'
// import coleusTimes from '@/components/svg/Times'
import coleusAsideSpinner from '@/components/partials/AsideSpinner'

export default {
  components: {
    coleusCaretDown,
    coleusCaretLeft,
    coleusCaretRight,
    // coleusTimes,
    coleusAsideSpinner
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
    offset: 0,
    parent: null,
    loadingParent: false,
    loadingNextPage: false,
    loadingPrevPage: false,
    pagesAggregate: 0,
    // paginateTotal: 0,
    // paginateTotalItems: 0,
    paginateCurrentPage: 1,
    perPage: 10,
    // paginateNextPage: 1,
    // paginatePrevPage: 1,
    paginateTotalPages: 1
    // paginateHasMore: false,
    // paginateNextOffset: 0,
    // paginatePrevOffset: 0
  }),
  computed: {
    currentParent() {
      return this.parent || this.$route.params.parent
    },

    currentOffset() {
      return this.perPage * this.paginateCurrentPage - this.perPage
    }
  },
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
        return { parent: this.currentParent, offset: this.currentOffset }
      },
      update(data) {
        this.loadingParent = false
        this.loadingNextPage = false
        this.loadingPrevPage = false
        this.pagesAggregate = data.pages_aggregate.aggregate.count
        this.calculatePagination()
        return data.pages
      }
    }
  },
  watch: {
    paginateCurrentPage(newPage, oldPage) {
      if (newPage !== oldPage) {
        this.offset += (newPage - oldPage) * this.perPage
        this.$router.push(this.pageLink(this.$route.params.page, newPage))
      }
    },
    // parent(newParent, oldParent) {
    //   this.loadingParent = true
    // },
    offset(newOffset, oldOffset) {
      if (newOffset > oldOffset) {
        this.loadingNextPage = true
      }
      if (newOffset < oldOffset) {
        this.loadingPrevPage = true
      }
    }
  },
  created() {
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
      return parseInt(pageId) === parseInt(this.currentParent)
    },

    /**
     * Return caret down or caret left based on header item collapsed/epanded
     * state.
     *
     * @param {number} pageId
     * @return {string}
     */
    headerIcon(pageId) {
      if (this.isExpanded(pageId) && this.loadingParent) {
        return 'coleus-aside-spinner'
      }

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
      if (this.parent !== pageId) {
        this.parent = pageId
        // Causing currentParent in computed properties to change and trigger
        // apollo pages query.
        this.loadingParent = true
      }
    },

    /**
     * Generate link for each contents items.
     *
     * @param {number} pageId
     * @return {Object}
     */
    pageLink(pageId, queryPage) {
      return {
        name: 'username-book-parent-page',
        params: {
          username: this.$route.params.username,
          book: this.$route.params.book,
          parent: this.currentParent,
          page: pageId || parseInt(this.$route.params.page)
        },
        query: { page: queryPage || parseInt(this.$route.query.page) }
      }
    },

    /**
     * Go to custom page.
     *
     * @return {void}
     */
    throttledCurrentPage: _.debounce(function(e) {
      const newPage = parseInt(e.target.value)
      if (
        !isNaN(newPage) &&
        newPage > 0 &&
        newPage <= this.paginateTotalPages
      ) {
        this.paginateCurrentPage = newPage
      }
    }, 300),

    /**
     * Convert pagination to offset.
     *
     * @return {void}
     */
    calculatePagination() {
      this.paginateTotalPages = Math.ceil(this.pagesAggregate / this.perPage)
      this.paginateCurrentPage = Math.ceil(this.offset / this.perPage) + 1
    },

    /**
     * Calculate next page.
     *
     * @return {number}
     */
    nextPage() {
      return this.paginateCurrentPage <= this.paginateTotalPages
        ? this.paginateCurrentPage + 1
        : this.paginateCurrentPage
    },

    /**
     * Navigate to next page.
     *
     * @return {void}
     */
    goToNextPage() {
      this.paginateCurrentPage += 1
    },

    /**
     * Calculate previous page.
     *
     * @return {number}
     */
    prevPage() {
      return this.paginateCurrentPage >= this.paginateTotalPages
        ? this.paginateCurrentPage - 1
        : this.paginateCurrentPage
    },

    /**
     * Navigate to previous page.
     *
     * @return {void}
     */
    goToPrevPage() {
      this.paginateCurrentPage -= 1
    }

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
