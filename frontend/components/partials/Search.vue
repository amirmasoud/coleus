<template>
  <div class="w-full lg:max-w-sm w-full items-center">
    <button
      v-if="isOpen"
      tabindex="-1"
      class="hidden lg:block fixed inset-0 h-full w-full bg-black opacity-50 cursor-default"
      @click="isOpen = false"
    ></button>
    <div class="relative w-full">
      <div
        class="relative px-4 lg:px-0 py-2 z-10 lg:z-0 shadow lg:shadow-none bg-gray-100 lg:bg-transparent"
      >
        <div class="flex flex-no-wrap items-center">
          <input
            class="coleus-search-input w-11/12"
            :class="[isOpen ? 'z-10' : 'z-0']"
            type="text"
            name="search"
            autocomplete="off"
            placeholder="جستجو"
            dir="rtl"
            @input="performSearch($event.target.value)"
            @focus="isOpen = true"
          />
          <button
            type="button"
            class="lg:hidden w-1/12 mr-2 text-indigo-500 focus:outline-none"
            @click.prevent="close()"
          >
            لغو
          </button>
        </div>
        <coleus-spinner
          v-if="searching"
          class="block absolute text-gray-600 z-10 h-4 mt-5 mr-8 lg:mr-3 right-0 top-0 fill-current"
        />
        <coleus-search-icon
          v-else
          class="block absolute text-gray-600 z-10 h-4 mt-5 mr-8 lg:mr-3 right-0 top-0 fill-current"
        />
      </div>
      <div v-if="isOpen" class="hidden lg:block">
        <div
          v-if="anyResult()"
          class="absolute bg-white w-full px-0 rounded shadow border border-gray-300 py-2 overflow-y-scroll h-64"
        >
          <div v-for="(index, item) in search" :key="index">
            <div v-if="hasResult(item)">
              <h2
                class="uppercase text-gray-400 text-xs font-semibold mt-2 mb-1 px-2"
              >
                {{ search[item] }}
              </h2>
              <ul>
                <li
                  v-for="result in eachSection(item)"
                  :key="result.id"
                  class="border-b border-gray-200 px-2 py-1"
                  @click="close()"
                >
                  <p v-if="item === 'books'" class="text-gray-500 font-light">
                    <lazy-coleus-breadcrumb-element
                      :user-name="result.users[0].name"
                    />
                  </p>
                  <p v-if="item === 'pages'" class="text-gray-500 font-light">
                    <lazy-coleus-breadcrumb-element
                      :user-name="result.book.users[0].name"
                      :book-title="result.book.title"
                    />
                  </p>
                  <p v-if="item === 'blocks'" class="text-gray-500 font-light">
                    <lazy-coleus-breadcrumb-element
                      :user-name="result.page.book.users[0].name"
                      :book-title="result.page.book.title"
                    />
                  </p>
                  <nuxt-link :to="linkTo(result, item)">
                    <p class="truncate">
                      {{ getLinkText(result, item) }}
                    </p>
                  </nuxt-link>
                  <template v-if="item === 'users'">
                    <div class="my-2">
                      <span
                        v-for="book in result.books"
                        :key="book.slug"
                        class="bg-gray-300 text-gray-800 rounded-full px-2 ml-1 text-sm"
                      >
                        <nuxt-link
                          :to="{
                            name: 'username-book-parent-page',
                            params: {
                              username: result.username,
                              book: book.slug,
                              parent: book.pages[0].parent_id,
                              page: book.pages[0].id
                            },
                            query: { page: 1 }
                          }"
                        >
                          {{ book.title }}
                        </nuxt-link>
                      </span>
                      <span
                        v-if="result.totalBooks - 3 > 0"
                        class="bg-gray-300 text-gray-800 rounded-full px-2 ml-1 text-sm"
                      >
                        <nuxt-link
                          :to="{
                            name: 'username',
                            params: {
                              username: result.username
                            }
                          }"
                        >
                          {{ result.totalBooks - 3 }}+
                        </nuxt-link>
                      </span>
                    </div>
                  </template>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="block lg:hidden">
        <div
          v-if="anyResult()"
          class="absolute bg-white w-full px-4 py-2 overflow-y-scroll h-(screen-27) sm:h-(screen-32)"
        >
          <div v-for="(index, item) in search" :key="index">
            <div v-if="hasResult(item)">
              <h2
                class="uppercase text-gray-400 text-xs font-semibold mt-2 mb-1 px-2"
              >
                {{ search[item] }}
              </h2>
              <ul>
                <li
                  v-for="result in eachSection(item)"
                  :key="result.id"
                  class="border-b border-gray-200 px-2 py-1"
                  @click="close()"
                >
                  <p v-if="item === 'books'" class="text-gray-500 font-light">
                    <lazy-coleus-breadcrumb-element
                      :user-name="result.users[0].name"
                    />
                  </p>
                  <p v-if="item === 'pages'" class="text-gray-500 font-light">
                    <lazy-coleus-breadcrumb-element
                      :user-name="result.book.users[0].name"
                      :book-title="result.book.title"
                    />
                  </p>
                  <p v-if="item === 'blocks'" class="text-gray-500 font-light">
                    <lazy-coleus-breadcrumb-element
                      :user-name="result.page.book.users[0].name"
                      :book-title="result.page.book.title"
                    />
                  </p>
                  <nuxt-link :to="linkTo(result, item)">
                    <p class="truncate">
                      {{ getLinkText(result, item) }}
                    </p>
                  </nuxt-link>
                  <template v-if="item === 'users'">
                    <div class="my-2">
                      <span
                        v-for="book in result.books"
                        :key="book.slug"
                        class="bg-gray-300 text-gray-800 rounded-full px-2 ml-1 text-sm"
                      >
                        <nuxt-link
                          :to="{
                            name: 'username-book-parent-page',
                            params: {
                              username: result.username,
                              book: book.slug,
                              parent: book.pages[0].parent_id,
                              page: book.pages[0].id
                            },
                            query: { page: 1 }
                          }"
                        >
                          {{ book.title }}
                        </nuxt-link>
                      </span>
                      <span
                        v-if="result.totalBooks - 3 > 0"
                        class="bg-gray-300 text-gray-800 rounded-full px-2 ml-1 text-sm"
                      >
                        <nuxt-link
                          :to="{
                            name: 'username',
                            params: {
                              username: result.username
                            }
                          }"
                        >
                          {{ result.totalBooks - 3 }}+
                        </nuxt-link>
                      </span>
                    </div>
                  </template>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import _ from 'lodash'
import coleusSearchIcon from '@/components/svg/Search'

export default {
  components: {
    coleusSearchIcon
  },
  data: () => ({
    isOpen: false,
    searching: false,
    query: '',
    users: [],
    books: [],
    pages: [],
    blocks: [],
    search: {
      users: 'شاعران',
      books: 'کتاب‌ها',
      pages: 'صفحات',
      blocks: 'بخش‌ها'
    }
  }),
  apollo: {
    SearchUsers: {
      client: 'backend',
      query: require('~/graphql/search.gql'),
      prefetch: false,
      variables() {
        return { q: this.query }
      },
      result(data) {
        this.users = data.data.SearchUsers
        this.books = data.data.SearchBooks
        this.pages = data.data.SearchPages
        this.blocks = data.data.SearchBlocks
        this.searching = false
      },
      skip() {
        if (this.query === '') {
          this.users = []
          this.books = []
          this.pages = []
          this.blocks = []
          this.searching = false
          return true
        } else {
          return false
        }
      }
    }
  },
  created() {
    const handleEscapeAndBack = (e) => {
      if (e.key === 'Esc' || e.key === 'Escape' || e.key === 'backbutton') {
        this.isOpen = false
        this.searching = false
        e.target.blur()
      }
    }
    if (process.client) {
      document.addEventListener('keydown', handleEscapeAndBack) // eslint-disable-line nuxt/no-globals-in-created
      this.$once('hook:beforeDestroy', () => {
        document.removeEventListener('keydown', handleEscapeAndBack) // eslint-disable-line nuxt/no-globals-in-created
      })
    }
  },
  methods: {
    performSearch: _.debounce(function(query) {
      this.query = query
      this.searching = true
    }, 500),
    eachSection(item) {
      return this[item]
    },
    getLinkText(result, item) {
      if (item === 'users') {
        return result.name
      } else if (item === 'books' || item === 'pages') {
        return result.title
      } else {
        // item === blocks
        return result.content
      }
    },
    hasResult(item) {
      return this[item].length
    },
    anyResult() {
      return (
        this.users.length ||
        this.books.length ||
        this.pages.length ||
        this.blocks.length
      )
    },
    close() {
      this.isOpen = false
      this.$emit('close')
    },
    linkTo(result, item) {
      if (item === 'users') {
        return {
          name: 'username',
          params: {
            username: result.username
          }
        }
      } else if (item === 'books') {
        return {
          name: 'username-book-parent-page',
          params: {
            username: result.users[0].username,
            book: result.slug,
            parent: result.pages[0].parent_id,
            page: result.pages[0].id
          },
          query: { page: 1 }
        }
      } else if (item === 'pages') {
        return {
          name: 'username-book-parent-page',
          params: {
            username: result.book.users[0].username,
            book: result.book.slug,
            parent: result.parent_id,
            page: result.id
          },
          query: { page: result.page_no }
        }
      } else {
        // item === blocks
        return {
          name: 'username-book-parent-page',
          params: {
            username: result.page.book.users[0].username,
            book: result.page.book.slug,
            parent: result.page.parent_id,
            page: result.page.id
          },
          query: { page: result.page_no }
        }
      }
    }
  }
}
</script>

<style lang="scss">
.coleus-search-input {
  @apply bg-gray-200 text-coleus-gray font-medium px-4 pr-10 rounded h-10 outline-none border border-gray-300 transition duration-300 ease-in-out;
  ::placeholder {
    @apply text-gray-600;
  }
  &:focus {
    @apply bg-white transition duration-300 ease-in-out shadow-inner;
  }
}
</style>
