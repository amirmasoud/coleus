<template>
  <div class="row mt-5">
    <div class="col-md-6 m-auto">
      <card>
        <form @submit.prevent="reset" @keydown="form.onKeydown($event)">

          <!-- Email -->
          <b-form-group :label="$t('email')"
                        label-for="login-email">
            <b-form-input :id="'login-email'"
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
                        label-for="register-password">
            <b-form-input :id="'register-password'"
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

          <!-- Password Confirmation -->
          <b-form-group :label="$t('password_confirmation')"
                        label-for="register-password-confirmation">
            <b-form-input :id="'register-password-confirmation'"
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

          <!-- Reset Password Button -->
          <v-button :loading="busy">{{ $t('reset_password') }}</v-button>

        </form>
      </card>
    </div>
  </div>
</template>

<script>
export default {
  head () {
    return { title: this.$t('reset_password') }
  },

  data: () => ({
    form: {
      token: '',
      email: '',
      password: '',
      password_confirmation: ''
    },
    busy: false,
    serr: {}
  }),

  created () {
    this.form.email = this.$route.query.email
    this.form.token = this.$route.params.token
  },

  methods: {
    async reset () {
      const { data } = await this.form.post('/password/reset')

      this.status = data.status

      this.form.reset()
    },

    clearError (field) {
      delete this.serr[field]
    }
  }
}
</script>
