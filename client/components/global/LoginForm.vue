<template>
  <div>
    <login-with-google/>
    <div class="text-center my-4" style="width: 100%; height: 12px; border-bottom: 1px solid #ebebeb;">
      <span class="px-3" style="background-color: #ffffff;">
        {{ $t('or') }}
      </span>
    </div>

    <form @submit.prevent="login">
      <b-form-group :label="$t('email')"
                    label-for="login-email">
        <b-form-input :id="prefix + 'login-email'"
                      type="email"
                      v-model="form.email"
                      required
                      name="email"
                      autocomplete="email"
                      :class="{ 'is-invalid': errors.has('email') || serr && serr.hasOwnProperty('email') }"
                      v-validate="'required|email'"
                      @input="clearError('email')">
        </b-form-input>
        <div v-show="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>
        <div v-if="serr && serr.hasOwnProperty('email')" class="invalid-feedback">{{ serr.email[0] }}</div>
      </b-form-group>

      <b-form-group :label="$t('password')"
                    label-for="login-password">
        <b-form-input :id="prefix + 'login-password'"
                      type="password"
                      v-model="form.password"
                      required
                      name="password"
                      autocomplete="current-password"
                      :class="{ 'is-invalid': errors.has('password') || serr && serr.hasOwnProperty('password') }"
                      v-validate="'required'"
                      @input="clearError('password')">
        </b-form-input>
        <div v-show="errors.has('password')" class="invalid-feedback">{{ errors.first('password') }}</div>
        <div v-if="serr && serr.hasOwnProperty('password')" class="invalid-feedback">{{ serr.password[0] }}</div>
      </b-form-group>

      <b-form-group :id="prefix + 'login-remember'">
        <b-form-checkbox-group v-model="remember" :id="prefix + 'login-remember'">
          <b-form-checkbox name="remember">{{ $t('remember_me') }}</b-form-checkbox>
          <!-- <router-link :to="{ name: 'password.request' }" class="small float-right my-auto">
            {{ $t('forgot_password') }}
          </router-link> -->
        </b-form-checkbox-group>
      </b-form-group>

      <v-button :loading="busy">{{ $t('login') }}</v-button>
    </form>
  </div>
</template>

<script>
    import gql from 'graphql-tag';

export default {
  name: 'LoginForm',

  props: {
    redirect: { type: Boolean, default: false },
    prefix: { type: String, default: '' }
  },

  // apollo: {
  //   user: gql`query { user @client }`
  // },

  data: () => ({
    form: {
      email: '',
      password: ''
    },
    remember: false,
    busy: false,
    serr: {}
  }),

  methods: {
    async login () {
      let loginMessage = this.$t('successful_login_header')

      this.busy = true
      this.$apollo.mutate({
        mutation: require('~/graphql/auth.gql'),
        variables: this.form
      })
      .then(async ({data}) => {
        await this.$apollo.mutate({
          mutation: gql`
            mutation($token: String!) {
              setToken(token: $token) @client
            }
          `,
          variables: { token: data.login.token },
        }).then(async ({res}) => {
          await this.$apolloHelpers.onLogin(data.login.token)

          this.$apollo.query({
            query: require('~/graphql/user'),
          }).then(({data}) => {
            this.$apollo.mutate({
              mutation: gql`
                mutation($user: String!) {
                  setUser(user: $user) @client
                }
              `,
              variables: { user: data.user },
            })
          })
        })

        // user.then(({res}) => {
        //   console.log(res)
        // })



        // this.$apolloHelpers.onLogin(data.login.token)

        // await this.$apollo.queries.user.refetch()
        // console.log(this.user)

        // Save the token.
        // this.$store.dispatch('auth/saveToken', {
        //   token: data.login.token,
        //   remember: this.remember
        // })


        // this.setToken(data.login.token)

        this.busy = false

        // Fetch the user.
        // await this.$store.dispatch('auth/fetchUser')
        // this.fetchUser()

        // this.$snotify.success(loginMessage)

        // if (this.after) {
        //   this.$router.push({ name: 'welcome' })
        // } else {
        //   this.$root.$emit('login-done')
        // }
      })
      .catch((error) => {
        console.log(error)
        if (error.graphQLErrors) {
          this.serr = error.graphQLErrors[0].errors
        }
        this.busy = false
      })
    },

    clearError (field) {
      delete this.serr[field]
    },

    setToken (token) {
      return this.$apollo.mutate({
        mutation: gql`
          mutation($token: String!) {
            setToken(token: $token) @client
          }
        `,
        variables: { token: 'K' },
      })
    },

    fetchUser () {
      return this.$apollo.query({
        query: gql`query { user @client }`,
      })
    }
  }
}
</script>
