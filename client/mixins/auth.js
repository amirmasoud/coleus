export const auth = {
  data: () => ({
    auth: null,
    protected: false,
    fresh: true,
    loading: true
  }),

  mounted() {
    if (this.fresh) {
      this.login()
    } else {
      this.attempLogin()
    }

    this.$root.$on('logged-in', this.attempLogin)
  },

  methods: {
    async attempLogin() {
      this.$apollo.skipAllQueries = true

      const forbidden = this.$t('should_login')

      await this.$apollo
        .query({
          query: require('~/graphql/client/query/user'),
          prefetch: false
        })
        .then(({ data }) => {
          this.auth = data.user
          this.$root.$emit('auth-ready')
          this.$apollo.skipAllQueries = false
        })
        .catch(() => {
          this.auth = null

          if (this.protected) {
            this.$router.push({ name: 'login' })
            this.$snotify.success(forbidden)
          }

          this.$apollo.skipAllQueries = false
        })
    },

    async login() {
      this.$apollo.skipAllQueries = true
      const token = await this.$apolloHelpers.getToken()

      if (token && !this.auth && !process.server) {
        await this.$apolloHelpers.onLogin(token)

        await this.$apollo
          .query({
            query: require('~/graphql/user'),
            prefetch: true
          })
          .then(async ({ data }) => {
            await this.$apollo
              .mutate({
                mutation: require('~/graphql/client/mutation/user'),
                variables: { user: data.user },
                prefetch: true
              })
              .then(async ({ data }) => {
                await this.$apollo
                  .query({
                    query: require('~/graphql/client/query/user'),
                    prefetch: true
                  })
                  .then(({ data }) => {
                    this.auth = data.user
                    this.loading = false
                    this.$root.$emit('logged-in')
                    this.$apollo.skipAllQueries = false
                  })
              })
          })
          .catch(() => {
            this.auth = false
            this.loading = false
            this.$apollo.skipAllQueries = false
          })
      } else {
        this.auth = false
        this.loading = false
      }
    }
  }
}
