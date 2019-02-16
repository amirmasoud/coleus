<template>
  <div v-if="user">
    <div class="pt-2">
      <div class="flex justify-start">
        <!-- User Image -->
        <user-small-image :user="user" />

        <!-- User Name -->
        <div class="mr-2 float-right">
          <h4>{{ user.name }}</h4>
          <small>@{{ user.username }}</small>
        </div>

        <!-- Follow/New Book Button -->
        <!-- <toggle-book-follow-button
          :loading="loadingUser"
          :user="user"
          :auth="auth"
          @toggle-follow="refetch"
        /> -->
      </div>
    </div>

    <!-- Follows/Followers/Books Count -->
    <social-status-bar :user="user" />

    <!-- Books -->
    <div v-if="user.books && user.books.length" class="flex content-start flex-wrap mx-2">
      <div
        v-for="book in user.books"
        :key="book.id"
        class="w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 xl:w-1/6 p-2"
      >
        <book-card :book="book" />
      </div>
    </div>

    <book-nil v-else />
  </div>

  <!-- <oval-loader v-else /> -->
</template>

<script>
// import { auth } from '~/mixins/auth'
// import ToggleBookFollowButton from '~/components/buttons/ToggleBookFollow'
import UserSmallImage from '~/components/images/UserSmall'
import SocialStatusBar from '~/components/bars/SocialStatus'
import BookCard from '~/components/cards/Book'
import profile from '~/graphql/profile'

export default {
  components: {
    // ToggleBookFollowButton,
    UserSmallImage,
    SocialStatusBar,
    BookCard
  },

  // mixins: [auth],

  apollo: {
    user: {
      query: profile,
      prefetch: ({ route }) => ({ username: route.params.username }),
      variables() {
        return { username: this.$route.params.username }
      }
    }
  },

  methods: {
    /**
     * Refetch profile after toggling follow to reflect social status count.
     *
     * @return {void}
     */
    async refetch() {
      // Let the child component know about process, so spinning icon will be
      // shown as long as parent process completed.
      this.loadingUser = true

      await this.$apollo.queries.user.refetch()

      this.loadingUser = false
    }
  }
}
</script>
