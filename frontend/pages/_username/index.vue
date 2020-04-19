<template>
  <coleus-container>
    <div v-if="users && users.length">
      <div v-for="user in users" :key="user.id">
        <div class="lg:py-2">
          <img
            src="/cover.jpg"
            class="cover-profile object-cover h-16 sm:h-32 w-full -mb-8 sm:-mb-16 sm:rounded-lg shadow"
          />
          <div class="mx-auto w-20 sm:w-32 -mb-4">
            <no-ssr>
              <progressive-img
                class="shadow-lg rounded-full border-4 border-white"
                :src="user.medium"
                :placeholder="user.thumbnail"
                :blur="30"
                :aspect-ratio="1"
              />
            </no-ssr>
          </div>
          <h1
            class="font-semibold text-center mt-4 text-2xl sm:text-3xl lg:text-4xl"
          >{{ user.name }}</h1>
          <div class="text-gray-500 text-center font-thin text-sm">{{ user.username }}</div>
        </div>
        <div v-if="user.book_users && user.book_users.length" class="flex content-start flex-wrap">
          <div
            v-for="{book} in user.book_users"
            :key="book.id"
            class="p-2 w-full sm:w-1/2 md:w-1/3 lg:w-1/4"
          >
            <nuxt-link
              :to="{name: 'username-book-parent-page', params: { username: user.username, book: book.slug, parent: book.pages[0].parent_id, page: book.pages[0].id }}"
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

<style lang="scss">
.cover-profile {
  filter: blur(2px);
}
</style>
