<template>
  <span v-if="!$store.state.auth.user">
    <b-btn variant="link" class="nav-link" style="padding: 0.5rem 0.5rem !important" v-b-modal.register-modal-center>{{ $t('register') }}</b-btn>
    <b-modal id="register-modal-center"
             centered
             :title="$t('register')"
             hide-footer
             ref="registerModal">
      <form @submit.prevent="register" @keydown="form.onKeydown($event)">
        <b-form-group :label="$t('name')"
                      label-for="register-name">
          <b-form-input id="register-name"
                        type="text"
                        v-model="form.name"
                        :class="{ 'is-invalid': form.errors.has('name') }"
                        required
                        name="name"
                        autocomplete="name"
                        dir="auto">
          </b-form-input>
          <has-error :form="form" field="name"/>
        </b-form-group>

        <b-form-group :label="$t('email')"
                      label-for="register-email">
          <b-form-input id="register-email"
                        type="email"
                        v-model="form.email"
                        :class="{ 'is-invalid': form.errors.has('email') }"
                        required
                        name="email"
                        autocomplete="email"
                        dir="ltr">
          </b-form-input>
          <has-error :form="form" field="email"/>
        </b-form-group>

        <b-form-group :label="$t('password')"
                      label-for="register-password">
          <b-form-input id="register-password"
                        type="password"
                        v-model="form.password"
                        :class="{ 'is-invalid': form.errors.has('password') }"
                        required
                        name="password"
                        autocomplete="new-password"
                        dir="ltr">
          </b-form-input>
          <has-error :form="form" field="password"/>
        </b-form-group>

        <b-form-group :label="$t('password_confirmation')"
                      label-for="register-password-confirmation">
          <b-form-input id="register-password-confirmation"
                        type="password"
                        v-model="form.password_confirmation"
                        :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
                        required
                        name="password_confirmation"
                        autocomplete="new-password"
                        dir="ltr">
          </b-form-input>
          <has-error :form="form" field="password_confirmation"/>
        </b-form-group>

        <v-button :loading="form.busy">{{ $t('register') }}</v-button>
      </form>
    </b-modal>
  </span>
</template>

<script>
import Form from 'vform'

export default {
  name: 'Register',

  data: () => ({
    form: new Form({
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    })
  }),

  methods: {
    async register () {
      let registerMessage = this.$t('successful_register_header')

      // Register the user.
      const { data } = await this.form.post('/api/register')

      // Log in the user.
      const { data: { token } } = await this.form.post('/api/login')

      // Save the token.
      this.$store.dispatch('auth/saveToken', { token })

      // Update the user.
      await this.$store.dispatch('auth/updateUser', { user: data })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      try {
        this.$snotify.success(registerMessage)

        this.$refs.registerModal.hide()
      } catch(e) {
        // console.warn(e)
      }
    }
  }
}
</script>
