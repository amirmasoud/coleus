<template>
  <div class="relative">
    <input
      class="coleus-search-input"
      type="text"
      name="search"
      placeholder="جستجو"
      dir="rtl"
      v-on:input="performSearch($event.target.value)"
    />
    <coleus-search-icon
      class="block absolute text-gray-600 z-10 h-4 mt-3 ml-3 left-0 top-0 fill-current"
    />
    {{ users }}
    {{ books }}
    {{ pages }}
    {{ blocks }}
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
    query: '',
    users: [],
    books: [],
    pages: [],
    blocks: []
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
        console.log(data.data)
        this.users = data.data.SearchUsers
        this.books = data.data.SearchBooks
        this.pages = data.data.SearchPages
        this.blocks = data.data.SearchBlocks
      },
      skip() {
        if (this.query === '') {
          this.users = []
          this.books = []
          this.pages = []
          this.blocks = []
          return true
        } else {
          return false
        }
      }
    }
  },
  methods: {
    performSearch: _.debounce(function(query) {
      this.query = query
    }, 300)
  }
}
</script>

<style lang="scss">
.coleus-search-input {
  @apply bg-gray-200 text-coleus-gray font-medium px-4 pl-10 rounded-full h-10 outline-none w-full transition duration-300 ease-in-out;
  ::placeholder {
    @apply text-gray-600;
  }
  &:focus {
    @apply bg-white shadow transition duration-300 ease-in-out;
  }
}
</style>
