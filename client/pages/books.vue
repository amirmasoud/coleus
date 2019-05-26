<template>
  <div
    v-if="books"
    class="flex content-start flex-wrap"
  >
    <div
      v-for="book in books.data"
      :key="book.id"
      class="w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 p-2"
    >
      <book-card class="" :book="book" link-to="detail" />
    </div>
  </div>
  <div v-else class="mt-5">
    <oval-loader />
  </div>
</template>

<script>
import BookCard from '~/components/cards/Book'

export default {
  head: {
    title: 'کتاب‌ها'
  },

  components: {
    BookCard
  },

  data: () => ({
    baseUrl: process.env.APP_URL
  }),

  apollo: {
    books: {
      query: require('~/graphql/book/all.gql')
    }
  }
}
</script>
