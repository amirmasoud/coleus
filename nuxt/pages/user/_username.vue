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
<!--     <b-row v-if="user.books && user.books.length" class="mt-2">
      <b-col
        v-for="book in user.books"
        :key="book.id"
        cols="6"
        sm="4"
        md="4"
        lg="3"
        xl="2"
      >
        <book-card :book="book" />
      </b-col>
    </b-row>

    <book-nil v-else /> -->
  </div>

  <!-- Loading -->
  <oval-loader v-else />
</template>

<script>
import { auth } from '~/mixins/auth'
// import ToggleBookFollowButton from '~/components/buttons/ToggleBookFollow'
import UserSmallImage from '~/components/images/UserSmall'
import SocialStatusBar from '~/components/bars/SocialStatus'

export default {
  components: {
    // ToggleBookFollowButton,
    UserSmallImage,
    SocialStatusBar
  },

  head() {
    return {
      title: this.user ? this.user.name : this.$t('books')
      // meta: [
      //   {
      //     name: 'description',
      //     content: this.user ? ( this.user.bio ? this.user.bio.substring(0, 300) : '' ) : ''
      //   },

      //   { property: 'og:description', content: this.user ? (this.user.bio ? this.user.bio.substring(0, 300) + '...' : '') : '', vmid: 'og:description' },
      //   { name: 'twitter:description', content: this.user ? (this.user.bio ? this.user.bio.substring(0, 300) + '...' : '') : '', vmid: 'twitter:description' },
      //   { itemprop: 'description', content: this.user ? (this.user.bio ? this.user.bio.substring(0, 300) + '...' : '') : '', vmid: 'description' },

      //   { property: 'og:title', content: this.user ? this.user.name : '', vmid: 'og:title' },
      //   { name: 'twitter:title', content: this.user ? this.user.name : '', vmid: 'twitter:title' },
      //   { itemprop: 'name', content: this.user ? this.user.name : '', vmid: 'title' },

      //   { property: 'og:image', content: this.user ? (this.user.small || this.user.photo_url) : '', vmid: 'og:image' },
      //   { name: 'twitter:image', content: this.user ? (this.user.small || this.user.photo_url) : '', vmid: 'twitter:image' },
      //   { itemprop: 'image', content: this.user ? (this.user.small || this.user.photo_url) : '', vmid: 'image' },
      // ]
    }
  },

  mixins: [auth],

  asyncData({ params }) {
    return {
      username: params.username
    }
  },

  data: () => ({
    loadingUser: true
  }),

  apollo: {
    /**
     * Prefetch user profile object with username and loading state.
     *
     * @type {Object}
     */
    user: {
      query: require('~/graphql/profile.gql'),
      prefetch: ({ params }) => {
        return {
          username: params.username
        }
      },
      variables() {
        return {
          username: this.username
        }
      },
      result() {
        this.loadingUser = false
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
