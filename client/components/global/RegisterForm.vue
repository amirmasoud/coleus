<template>
<div>
  <login-with-google/>
  <div class="text-center my-4" style="width: 100%; height: 12px; border-bottom: 1px solid #ebebeb;">
    <span class="px-3" style="background-color: #ffffff;">
      {{ $t('or') }}
    </span>
  </div>
  <form @submit.prevent="register">
    <b-form-group :label="$t('name')"
                  label-for="register-name">
      <b-form-input :id="prefix + 'register-name'"
                    type="text"
                    v-model="form.name"
                    :class="{ 'is-invalid': errors.has('name') || serr && serr.hasOwnProperty('name') }"
                    required
                    name="name"
                    autocomplete="name"
                    dir="auto"
                    v-validate="'required|max:255'"
                    @input="clearError('name')">
      </b-form-input>
      <div v-show="errors.has('name')" class="invalid-feedback">{{ errors.first('name') }}</div>
      <div v-if="serr && serr.hasOwnProperty('name')" class="invalid-feedback">{{ serr.name[0] }}</div>
    </b-form-group>

    <b-form-group :label="$t('email')"
                  label-for="register-email">
      <b-form-input :id="prefix + 'register-email'"
                    type="email"
                    v-model="form.email"
                    :class="{ 'is-invalid': errors.has('email') || serr && serr.hasOwnProperty('email') }"
                    required
                    name="email"
                    autocomplete="email"
                    dir="ltr"
                    v-validate="'required|email|max:255'"
                    @input="clearError('email')">
      </b-form-input>
      <div v-show="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>
      <div v-if="serr && serr.hasOwnProperty('email')" class="invalid-feedback">{{ serr.email[0] }}</div>
    </b-form-group>

    <b-form-group :label="$t('password')"
                  label-for="register-password">
      <b-form-input :id="prefix + 'register-password'"
                    type="password"
                    v-model="form.password"
                    :class="{ 'is-invalid': errors.has('password') || serr && serr.hasOwnProperty('password') }"
                    required
                    name="password"
                    autocomplete="new-password"
                    dir="ltr"
                    v-validate="'required|min:6|max:255'"
                    @input="clearError('password')">
      </b-form-input>
      <div v-show="errors.has('password')" class="invalid-feedback">{{ errors.first('password') }}</div>
      <div v-if="serr && serr.hasOwnProperty('password')" class="invalid-feedback">{{ serr.password[0] }}</div>
    </b-form-group>

    <b-form-group :label="$t('password_confirmation')"
                  label-for="register-password-confirmation">
      <b-form-input :id="prefix + 'register-password-confirmation'"
                    type="password"
                    v-model="form.password_confirmation"
                    :class="{ 'is-invalid': errors.has('password_confirmation') || serr && serr.hasOwnProperty('password_confirmation') }"
                    required
                    name="password_confirmation"
                    autocomplete="new-password"
                    dir="ltr"
                    v-validate="'required|min:6|confirmed:password|max:255'"
                    @input="clearError('password_confirmation')">
      </b-form-input>
      <div v-show="errors.has('password_confirmation')" class="invalid-feedback">{{ errors.first('password_confirmation') }}</div>
      <div v-if="serr && serr.hasOwnProperty('password_confirmation')" class="invalid-feedback">{{ serr.password_confirmation[0] }}</div>
    </b-form-group>

    <v-button :loading="busy">{{ $t('register') }}</v-button>
  </form>
</div>
</template>

<script>
export default {
  name: 'RegisterForm',

  props: {
    redirect: { type: Boolean, default: false },
    prefix: { type: String, default: '' }
  },

  data: () => ({
    form: {
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    },
    busy: false,
    serr: {}
  }),

  methods: {
    async register () {
      let registerMessage = this.$t('successful_register_header')

      this.busy = true
      this.$apollo.mutate({
        mutation: require('~/graphql/register.gql'),
        variables: this.form
      })
      .then(async ({data}) => {
        await this.$apollo.mutate({
          mutation: require('~/graphql/auth.gql'),
          variables: this.form
        }).then(async ({data}) => {
          await this.$apolloHelpers.onLogin(data.login.token)

          // Save the token.
          // this.$store.dispatch('auth/saveToken', {
          //   token: data.login.token,
          //   remember: this.remember
          // })
        })

        // await this.$store.dispatch('auth/updateUser', { user: data })

        // await this.$store.dispatch('auth/fetchUser')

        this.$snotify.success(registerMessage)

        if (this.redirect) {
          this.$router.push({ name: 'welcome' })
        } else {
          history.back()
          this.$refs.loginModal.hide()
        }

        this.busy = false
      }).catch((error) => {
        if (error.graphQLErrors) {
          this.serr = error.graphQLErrors[0].errors
        }
        this.busy = false
      })
    },

    clearError (field) {
      delete this.serr[field]
    }
  }
}
</script>

