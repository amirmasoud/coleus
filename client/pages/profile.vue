<template>
  <div v-if="user">
    <b-row>
      <b-col class="text-left">
        <div class="d-flex justify-content-start">
          <user-small-image :user="user"></user-small-image>
          <div>
            <h4>{{ user.name }}</h4>
            <small>@{{ user.username }}</small>
          </div>
          <toggle-book-follow-button v-on:toggle-follow="refetch"
                                     :loading="loadingUser"
                                     :user="user"
                                     :auth="auth"></toggle-book-follow-button>
        </div>
      </b-col>
    </b-row>
    <social-status-bar :user="user"></social-status-bar>
    <b-row v-if="user.books && user.books.length" class="mt-2">
      <b-col cols="6" sm="4" md="4" lg="3" xl="2"
             v-for="book in user.books" :key="book.id">
        <book-card :book="book"></book-card>
      </b-col>
    </b-row>
    <book-nil v-else />
  </div>

  <!-- Loading -->
  <oval-loader v-else />

</template>

<script>
export default {
  head () {
    return {
      title: this.user ? this.user.name : this.$t('books'),
      meta: [
        { name: 'description', content: this.user ? (this.user.bio ? this.user.bio.substring(0, 300) : '') : '' },

        { property: 'og:description', content: this.user ? (this.user.bio ? this.user.bio.substring(0, 300) + '...' : '') : '', vmid: 'og:description' },
        { name: 'twitter:description', content: this.user ? (this.user.bio ? this.user.bio.substring(0, 300) + '...' : '') : '', vmid: 'twitter:description' },
        { itemprop: 'description', content: this.user ? (this.user.bio ? this.user.bio.substring(0, 300) + '...' : '') : '', vmid: 'description' },

        { property: 'og:title', content: this.user ? this.user.name : '', vmid: 'og:title' },
        { name: 'twitter:title', content: this.user ? this.user.name : '', vmid: 'twitter:title' },
        { itemprop: 'name', content: this.user ? this.user.name : '', vmid: 'title' },

        { property: 'og:image', content: this.user ? (this.user.small || this.user.photo_url) : '', vmid: 'og:image' },
        { name: 'twitter:image', content: this.user ? (this.user.small || this.user.photo_url) : '', vmid: 'twitter:image' },
        { itemprop: 'image', content: this.user ? (this.user.small || this.user.photo_url) : '', vmid: 'image' },
      ]
    }
  },

  asyncData ({ params }) {
    return {
      username: params.username
    }
  },

  data () {
    return {
      auth: null,
      loadingUser: true
    }
  },

  mounted () {
    this.attempLogin()

    this.$root.$on('logged-in', this.attempLogin)
  },

  apollo: {
    user: {
      query: require('~/graphql/profile.gql'),
      prefetch: ({ params }) => {
        return {
          username: params.username
        }
      },
      variables () {
        return {
          username: this.username,
        }
      },
      result({ data, loading, networkStatus }) {
        this.loadingUser = false
      },
    }
  },

  methods: {
    async refetch () {
      this.loadingUser = true
      await this.$apollo.queries.user.refetch()
      this.loadingUser = false
    },

    async attempLogin () {
      await this.$apollo.query({
        query: require('~/graphql/client/query/user'),
        prefetch: false
      }).then(({ data }) => {
        this.auth = data.user
      }).catch((error) => {
        this.auth = null
      })
    }
  }
}
</script>
