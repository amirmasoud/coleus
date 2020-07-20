<template>
  <aside
    class="aside-container block absolute right-0 left-0 bg-gray-100 lg:mx-0 lg:inset-0 z-90 lg:mb-0 lg:sticky lg:w-1/4"
  >
    <div
      class="aside-inner-container scrolling-touch lg:text-right lg:h-auto lg:block lg:sticky lg:top-0 lg:mt-0 lg:py-4"
    >
      <nav class="lg:block lg:pl-0">
        <div v-if="books && books.length">
          <template v-for="(page, index) in books[0].pages" class="flex">
            <div :key="`icon-${index}`">
              <button
                class="flex text-right focus:outline-none w-full px-2"
                type="button"
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
                    <coleus-spinner
                      v-if="loadingPrevPage"
                      class="self-center"
                    />
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
                <div class="w-1/6 flex justify-end">
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
                    <coleus-spinner
                      v-if="loadingNextPage"
                      class="self-center"
                    />
                    <coleus-caret-left v-else class="self-center" />
                  </button>
                </div>

                <ul
                  v-if="!loadingParent"
                  :key="`list-${index}`"
                  class="py-2 w-full"
                >
                  <li
                    v-for="subpage in pages"
                    :id="`page-${subpage.id}`"
                    :key="subpage.id"
                    class="text-sm"
                    :class="{ 'bg-gray-300': subpage.id == $route.params.page }"
                  >
                    <nuxt-link
                      :to="pageLink(subpage.id)"
                      class="block px-3 py-1"
                      @click.native="$root.$emit('close-menu')"
                    >
                      {{ subpage.title }}
                    </nuxt-link>
                  </li>
                </ul>
              </div>
            </div>
          </template>
        </div>
      </nav>
    </div>
  </aside>
</template>

<script>
import _ from 'lodash'
import coleusCaretDown from '@/components/svg/CaretDown'
import coleusCaretLeft from '@/components/svg/CaretLeft'
import coleusCaretRight from '@/components/svg/CaretRight'
import coleusAsideSpinner from '@/components/partials/AsideSpinner'

export default {
  components: {
    coleusCaretDown,
    coleusCaretLeft,
    coleusCaretRight,
    coleusAsideSpinner
  },
  props: {
    loading: Boolean
  },
  data: () => ({
    fresh: true,
    offset: 0,
    parent: null,
    loadingParent: false,
    loadingNextPage: false,
    loadingPrevPage: false,
    pagesAggregate: 0,
    paginatePage: 1,
    perPage: 10,
    paginateTotalPages: 1
  }),
  computed: {
    currentParent() {
      return parseInt(this.parent || this.$route.params.parent)
    },

    currentOffset() {
      return parseInt(this.perPage * this.paginateCurrentPage - this.perPage)
    },

    paginateCurrentPage: {
      get() {
        return this.paginatePage
      },
      set(newPage) {
        this.paginatePage = newPage
      }
    }
  },
  apollo: {
    books: {
      query: require('~/graphql/aside.gql'),
      prefetch: ({ route }) => ({ book: route.params.book }),
      variables() {
        return { book: this.$route.params.book }
      },
      update(data) {
        if (data.books.length) {
          return data.books
        } else {
          this.$nuxt.error({
            message: 'کتاب مورد نظر یافت نشد',
            statusCode: 404
          })
        }
      },
      result(res) {
        if (!res.data.books.length) {
          this.$root.$emit('graphql-error')
        }
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
      },
      skip() {
        const skip =
          !Number.isInteger(this.currentParent) ||
          this.currentParent <= 0 ||
          !Number.isInteger(this.currentOffset) ||
          this.currentOffset < 0

        if (skip) {
          this.$root.$emit('graphql-error')
        }

        return skip
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
    const queryPage = parseInt(this.$route.query.page)
    if (this.paginateCurrentPage !== queryPage) {
      this.paginateCurrentPage = queryPage
    }
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
        this.paginateCurrentPage = 1
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
      if (
        !(
          Number.isInteger(this.paginateCurrentPage) &&
          this.paginateCurrentPage > 1
        )
      ) {
        this.paginateCurrentPage = Math.ceil(this.offset / this.perPage) + 1
      }
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
    },

    /**
     * Navigate to a new page.
     *
     * @param {number}
     * @return {object}
     */
    goToPage(pageId) {
      return this.$router.replace(this.pageLink(pageId))
    }
  }
}
</script>

<style lang="scss">
.pagination-link-disabled {
  @apply text-gray-400 border-gray-200 shadow-none cursor-not-allowed;
}

.aside-container {
  overflow-y: scroll !important;
  height: calc(100vh - 4rem) !important;
  position: sticky !important;
  top: 4rem !important;
}
</style>
