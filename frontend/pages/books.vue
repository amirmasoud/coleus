<template>
  <coleus-container>
    <div v-if="books && books.length" class="flex content-start flex-wrap">
      <div v-for="book in books" :key="book.id" class="p-2 w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
        <nuxt-link
          :to="{name: 'username-book', params: { username: book.book_users[0].user.username, book: book.slug }}"
        >
          <book-card :book="book" class="mx-auto" />
        </nuxt-link>
      </div>
    </div>
    <template v-else>
      <div class="container">
        <coleus-spinner class="mx-auto my-4" />
      </div>
    </template>
  </coleus-container>
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
