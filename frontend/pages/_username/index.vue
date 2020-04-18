<template>
  <coleus-container>
    <div v-if="users && users.length">
      <div v-for="user in users" :key="user.id">
        <div class="py-2">
          <div class="mb-8 p-2 rounded-full">
            <div class="flex flex-wrap mb-24 items-center w-full rounded-lg bg-indigo-600 p-4">
              <div class="w-1/5 relative">
                <no-ssr>
                  <progressive-img
                    class="-mb-40 shadow rounded-full border border-gray-300"
                    :src="user.medium"
                    :placeholder="user.thumbnail"
                    :blur="30"
                    :aspect-ratio="1"
                  />
                </no-ssr>
              </div>
              <div class="w-4/5 relative">
                <div class="absolute mt-16 mr-4">
                  <h1 class="font-semibold text-5xl">{{ user.name }}</h1>
                  <div class="flex justify-between font-light" dir="rtl">
                    <div class="text-gray-500">{{ user.username }}</div>
                  </div>
                </div>
              </div>
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
              :to="{name: 'username-book-page', params: { username: user.username, book: book.slug, page: book.pages[0].id }}"
            >
              <book-card :book="book" class="mx-auto" />
            </nuxt-link>
          </div>
        </div>
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
