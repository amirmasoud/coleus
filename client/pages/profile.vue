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
          <div class="ml-3" v-if="auth">
            <template v-if="auth.username != $route.params.username">
              <v-button v-if="user.is_following"
                        type="outline-primary"
                        class="px-4 btn-sm"
                        block
                        :loading="togglingFollow"
                        @click.native="toggleFollow">
                {{ $t('unfollow') }}
              </v-button>
              <v-button v-else
                        class="px-4 btn-sm"
                        block
                        :loading="togglingFollow"
                        @click.native="toggleFollow">
                + {{ $t('follow') }}
              </v-button>
            </template>
            <b-button v-else class="px-4" size="sm" variant="success" block v-b-modal.modal-center-new-book>+ {{ $t('new_book') }}</b-button>
          </div>
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
      togglingFollow: false,
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
    toggleFollow () {
      this.togglingFollow = true
      this.$apollo.mutate({
        mutation: require('~/graphql/follow.gql'),
        variables: {
          user: this.user ? this.user.id : null
        },
      }).then((data) => {
        this.togglingFollow = false
        this.$apollo.queries.user.refetch()
      })
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
