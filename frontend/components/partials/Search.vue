<template>
  <div class="max-w-sm w-full">
    <button
      v-if="isOpen"
      @click="isOpen = false"
      tabindex="-1"
      class="fixed inset-0 h-full w-full bg-black opacity-50 cursor-default"
    ></button>
    <div class="relative">
      <input
        class="coleus-search-input"
        :class="[isOpen ? 'z-10' : 'z-0']"
        type="text"
        name="search"
        placeholder="جستجو"
        dir="rtl"
        v-on:input="performSearch($event.target.value)"
        @focus="isOpen = !isOpen"
      />
      <coleus-spinner
        v-if="searching"
        class="block absolute text-gray-600 z-10 h-4 mt-3 mr-1 right-0 top-0 fill-current"
      />
      <coleus-search-icon
        v-else
        class="block absolute text-gray-600 z-10 h-4 mt-3 mr-3 right-0 top-0 fill-current"
      />
      <template v-if="isOpen">
        <div
          v-if="anyResult()"
          class="absolute bg-white w-full rounded shadow border border-gray-300 mt-2 py-2"
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
                  @click="isOpen = false"
                >
                  <nuxt-link
                    :to="linkTo(result, item)"
                    class="w-full block px-2 py-1 truncate"
                  >
                    {{ getLinkText(result, item) }}
                  </nuxt-link>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </template>
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
    const handleEscape = (e) => {
      if (e.key === 'Esc' || e.key === 'Escape') {
        this.isOpen = false
        this.searching = false
        e.target.blur()
      }
    }
    if (process.client) {
      document.addEventListener('keydown', handleEscape) // eslint-disable-line nuxt/no-globals-in-created
      this.$once('hook:beforeDestroy', () => {
        document.removeEventListener('keydown', handleEscape) // eslint-disable-line nuxt/no-globals-in-created
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
            parent: result.pages.parent_id,
            page: result.pages.id
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
          query: { page: 1 }
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
          query: { page: 1 }
        }
      }
    }
  }
}
</script>

<style lang="scss">
.coleus-search-input {
  @apply bg-gray-200 text-coleus-gray font-medium px-4 pr-10 rounded h-10 outline-none border border-gray-300 w-full transition duration-300 ease-in-out;
  ::placeholder {
    @apply text-gray-600;
  }
  &:focus {
    @apply bg-white transition duration-300 ease-in-out shadow-inner;
  }
}
</style>
