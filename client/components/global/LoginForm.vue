<template>
  <div>
    <!-- Login With Google Button -->
    <login-with-google/>

    <!-- Login With Google Button -->
    <login-with-github/>

    <!-- Separator Line -->
    <div class="text-center my-4" style="width: 100%; height: 12px; border-bottom: 1px solid #ebebeb;">
      <span class="px-3" style="background-color: #ffffff;">
        {{ $t('or') }}
      </span>
    </div>

    <form @submit.prevent="login">

      <!-- Email -->
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

      <!-- Password -->
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

      <!-- Login Button -->
      <v-button :loading="busy">{{ $t('login') }}</v-button>

      <!-- Reset Password Link -->
      <router-link
        @click.native="closeModal"
        :to="{ name: 'password.request' }"
        class="small mt-2 float-right">
        {{ $t('forgot_password') }}
      </router-link>

    </form>
  </div>
</template>

<script>

export default {
  name: 'LoginForm',

  props: {
    // Redirect after logn or not
    redirect: { type: Boolean, default: false },

    // Unique element IDs
    prefix: { type: String, default: '' }
  },

  data: () => ({
    // Login inputs
    form: {
      email: '',
      password: ''
    },
    busy: false,

    // Server Errors
    serr: {}
  }),

  methods: {
    /**
     * Authenticate user.
     *
     * @return {void}
     */
    async login () {
      let loginMessage = this.$t('successful_login_header')

      this.busy = true

      // Attempt login
      this.$apollo.mutate({
        mutation: require('~/graphql/auth.gql'),
        variables: this.form
      })
      .then(async ({data}) => {
        // Save token
        await this.$apolloHelpers.onLogin(data.login.token)

        // Fetch user
        await this.$apollo.query({
          query: require('~/graphql/user'),
        }).then(async ({data}) => {
          await this.$apollo.mutate({
            mutation: require('~/graphql/client/mutation/user'),
            variables: { user: data.user },
          })
        })

        this.busy = false

        this.$snotify.success(loginMessage)

        // Refresh navbar and close modal
        this.$root.$emit('refresh-navbar')
        if (this.redirect) {
          this.$router.push({ name: 'welcome' })
        } else {
          this.$root.$emit('login-done')
        }
      })
      .catch((error) => {
        // Login errors
        if (error.graphQLErrors) {
          this.serr = error.graphQLErrors[0].errors
        }
        this.busy = false
      })
    },

    /**
     * Clear input errors.
     *
     * @param  {string} field
     * @return {void}
     */
    clearError (field) {
      delete this.serr[field]
    },

    /**
     * Close modal after login.
     *
     * @return {void}
     */
    closeModal () {
      if (this.prefix != '') {
        this.$root.$emit('close-modal', false)
      }
    }
  }
}
</script>
