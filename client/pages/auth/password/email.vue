<template>
  <div class="row mt-5">
    <div class="col-md-6 m-auto">
      <card>
        <b-alert :show="sent" variant="success">{{ $t('sent') }}</b-alert>
        <form @submit.prevent="send">

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

          <!-- Submit Button -->
          <v-button :loading="busy">{{ $t('send_password_reset_link') }}</v-button>

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
    busy: false,
    sent: false,
    serr: {},
    form: {
      email: ''
    }
  }),

  methods: {
    async send () {
      this.busy = true
      const result = await this.$apollo.mutate({
        mutation: require('~/graphql/reset'),
        prefetch: false,
        variables: {
          email: this.form.email
        },
      }).then((res) => {
        this.busy = false
        this.sent = true
      }).catch((error) => {
        if (error.graphQLErrors) {
          this.serr = error.graphQLErrors[0].errors
        }
        this.busy = false
        this.sent = false
      })
    },

    clearError (field) {
      delete this.serr[field]
    }
  }
}
</script>
