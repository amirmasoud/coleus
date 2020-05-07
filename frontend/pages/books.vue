<template>
  <coleus-container>
    <div v-if="books && books.length" class="flex content-start flex-wrap">
      <div
        v-for="book in books"
        :key="book.id"
        class="p-2 w-1/2 md:w-1/3 lg:w-1/4"
      >
        <nuxt-link
          :to="{
            name: 'username-book-parent-page',
            params: {
              username: book.book_users[0].user.username,
              book: book.slug,
              parent: book.pages[0].parent_id,
              page: book.pages[0].id
            },
            query: { page: 1 }
          }"
        >
          <book-card :book="book" class="mx-auto mb-8" />
        </nuxt-link>
      </div>
    </div>
    <template v-else>
      <div class="container">
        <coleus-spinner class="mx-auto my-4 bg-white rounded-full p-1 shadow" />
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

  head() {
    const title = 'کتاب‌ها - Coleus'
    const description = 'لیست کتاب‌های قابل مطالعه آنلاین'
    return {
      title,
      meta: [
        { hid: 'description', name: 'description', content: description },
        // Open Graph
        { hid: 'og:title', property: 'og:title', content: title },
        {
          hid: 'og:description',
          property: 'og:description',
          content: description
        },
        // Twitter Card
        { hid: 'twitter:title', name: 'twitter:title', content: title },
        {
          hid: 'twitter:description',
          name: 'twitter:description',
          content: description
        }
      ]
    }
  },

  apollo: {
    books: {
      query: require('~/graphql/books.gql')
    }
  }
}
</script>
