<template>
  <div>
    <h1 class="text-2xl py-4 mx-2 border-b border-gainsboro">ورود</h1>
    <div class="flex content-start justify-center flex-wrap h-full mt-10">
      <form class="w-full max-w-xs" @submit.prevent="login">
        <div v-if="error" class="py-4 w-full">
          <div class="flex items-center bg-red text-white text-sm font-bold px-4 py-3 rounded border border-red-dark" role="alert">
            <p>{{ message }}</p>
          </div>
        </div>
        <div class="md:flex md:items-center mb-6">
          <div class="md:w-1/3">
            <label class="block text-smoky-black-dark md:text-right mb-1 md:mb-0 pr-4" for="inline-email">
              ایمیل
            </label>
          </div>
          <div class="md:w-2/3">
            <input
              class="bg-white appearance-none border border-gainsboro rounded w-full py-2 px-4 text-grey-darker leading-tight transition focus:bg-white hover:border-burnt-umber focus:border-burnt-umber focus:outline-none focus:shadow-outline focus:shadow-dark-input"
              id="inline-email"
              type="text"
              autocomplete="email"
              name="email"
              v-model="form.email"
              dir="ltr"
            >
          </div>
        </div>
        <div class="md:flex md:items-center mb-6">
          <div class="md:w-1/3">
            <label class="block text-smoky-black-dark md:text-right mb-1 md:mb-0 pr-4" for="inline-password">
              گذرواژه
            </label>
          </div>
          <div class="md:w-2/3">
            <input
              class="bg-white appearance-none border border-gainsboro rounded w-full py-2 px-4 text-grey-darker leading-tight transition focus:bg-white hover:border-burnt-umber focus:border-burnt-umber focus:outline-none focus:shadow-outline focus:shadow-dark-input"
              id="inline-password"
              type="password"
              autocomplete="current-password"
              name="password"
              v-model="form.password"
              dir="ltr"
            >
          </div>
        </div>
        <div class="md:flex md:items-center mb-6">
          <div class="md:w-1/3"></div>
          <label class="md:w-2/3 block text-smoky-black-dark">
            <input class="ml-2 leading-tight" type="checkbox">
            <span class="text-sm">
              من را به خاطر بسپار
            </span>
          </label>
        </div>
        <div class="md:flex md:items-center">
          <div class="md:w-1/3"></div>
          <div class="md:w-2/3">
            <button class="active:bg-prune active:shadow-btn-active active:border-caput-mortuum bg-sweet-brown border border-burnt-umber py-2 px-2 text-white font-normal text-sm rounded shadow-btn hover:bg-vivid-auburn hover:shadow-btn-hover focus:outline-none focus:shadow-outline focus:shadow-btn-focus no-underline" type="submit">
              ورود
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  head: {
    title: 'ورود'
  },

  data: () => ({
    error: false,
    message: '',
    form: {
      email: '',
      password: ''
    }
  }),

  methods: {
    /**
     * Authenticate user.
     *
     * @return {void}
     */
    async login() {
      // let loginMessage = this.$t('successful_login_header')

      // this.busy = true
      // Attempt login
      await this.$apollo
        .mutate({
          mutation: require('~/graphql/auth/login.gql'),
          variables: this.form
        })
        .then(async ({ data }) => {
          // Save token
          await this.$apolloHelpers.onLogin(data.login.token)
          // Fetch user
          await this.$apollo
            .query({
              query: require('~/graphql/auth/current.gql')
            })
            .then(async ({ data }) => {
              console.log(data)
              await this.$apollo.mutate({
                mutation: require('~/graphql/client/mutation/user'),
                variables: { user: data.user }
              })
            })
          // this.busy = false
          // this.$snotify.success(loginMessage)
          // Refresh navbar and close modal
          // this.$root.$emit('refresh-navbar')
          // if (this.redirect) {
          //   this.$router.push({ name: 'welcome' })
          // } else {
          //   this.$root.$emit('login-done')
          // }
        })
        .catch(error => {
          this.error = true
          this.message = error.message
          console.log(error.message)
          // Login errors
          // if (error.graphQLErrors) {
          //   this.serr = error.graphQLErrors[0].errors
          // }
          // this.busy = false
        })
    }
  }
}
</script>
