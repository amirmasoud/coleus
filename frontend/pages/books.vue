<template>
  <div>
    <coleus-container>
      <div
        v-if="books && books.length"
        class="flex content-start flex-wrap"
      >
        <div v-for="book in books" :key="book.id" class="p-2 w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
          <book-card :book="book" link-to="detail" />
        </div>
      </div>
    </coleus-container>
  </div>
</template>

<script>
import BookCard from '~/components/partials/cards/Book'

export default {
  components: {
    BookCard
  },

  apollo: {
    books: {
      query: require('~/graphql/books.gql')
    }
  }
}
</script>
