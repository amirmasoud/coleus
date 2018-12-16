<template>
  <span v-if="!$store.state.auth.user" v-on:close-modal="closeModal">
    <b-btn variant="link" class="nav-link" style="padding: 0.5rem 0.5rem !important" v-b-modal.modal-center>{{ $t('login') }}</b-btn>
    <b-modal id="modal-center"
             centered
             :title="$t('login')"
             hide-footer
             ref="loginModal">
      <login-with-google/>
      <div class="text-center my-4" style="width: 100%; height: 12px; border-bottom: 1px solid #ebebeb;">
        <span class="px-3" style="background-color: #ffffff;">
          {{ $t('or') }}
        </span>
      </div>

      <form @submit.prevent="login">
        <b-form-group :label="$t('email')"
                      label-for="login-email">
          <b-form-input id="login-email"
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
          <b-form-input id="login-password"
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

        <b-form-group id="login-remember">
          <b-form-checkbox-group v-model="remember" id="login-remember">
            <b-form-checkbox name="remember">{{ $t('remember_me') }}</b-form-checkbox>
            <!-- <router-link :to="{ name: 'password.request' }" class="small float-right my-auto">
              {{ $t('forgot_password') }}
            </router-link> -->
          </b-form-checkbox-group>
        </b-form-group>

        <v-button :loading="busy">{{ $t('login') }}</v-button>
      </form>
    </b-modal>
  </span>
</template>

<script>
export default {
  name: 'Login',

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
        await this.$apolloHelpers.onLogin(data.login.token)

        // Save the token.
        this.$store.dispatch('auth/saveToken', {
          token: data.login.token,
          remember: this.remember
        })
        this.busy = false

        // Fetch the user.
        await this.$store.dispatch('auth/fetchUser')

        this.$snotify.success(loginMessage)

        this.$refs.loginModal.hide()
      }).catch((error) => {
        if (error.graphQLErrors) {
          this.serr = error.graphQLErrors[0].errors
        }
        this.busy = false
      })
    },

    closeModal () {
      this.$refs.loginModal.hide()
    },

    clearError (field) {
      delete this.serr[field]
    }
  }
}
</script>
