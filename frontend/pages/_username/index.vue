<template>
  <coleus-container>
    <div v-if="users && users.length">
      <div v-for="user in users" :key="user.id">
        <div class="py-2 mx-4 border-b border-platinum">
          <div class="flex justify-start">
            <img :src="user.small" class="w-12 h-12 shadow rounded-full float-right" />
            <div class="mr-2 float-right">
              <h4>{{ user.name }}</h4>
              <small>{{ user.username }}</small>
            </div>
          </div>
        </div>
        <div
          v-if="user.book_users && user.book_users.length"
          class="flex content-start flex-wrap mx-2"
        >
          <div
            v-for="{book} in user.book_users"
            :key="book.id"
            class="p-2 w-full sm:w-1/2 md:w-1/3 lg:w-1/4"
          >
            <nuxt-link
              :to="{name: 'username-book', params: { username: user.username, book: book.slug }}"
            >
              <book-card :book="book" class="mx-auto" />
            </nuxt-link>
          </div>
        </div>
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
  head() {
    return {
      title: this.users ? this.users[0].name : ''
    }
  },

  components: {
    BookCard
  },

  apollo: {
    users: {
      query: require('~/graphql/profile.gql'),
      prefetch: ({ route }) => ({ username: route.params.username }),
      variables() {
        return { username: this.$route.params.username }
      }
    }
  }
}
</script>
