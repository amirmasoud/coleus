<template>
  <span v-if="!$store.state.auth.user">
    <b-btn variant="link" class="nav-link" v-b-modal.modal-center>{{ $t('login') }}</b-btn>
    <b-modal id="modal-center"
             centered
             :title="$t('login')"
             hide-footer
             ref="loginModal">
      <form @submit.prevent="login" @keydown="form.onKeydown($event)">
        <b-form-group :label="$t('email')"
                      label-for="login-email">
          <b-form-input id="login-email"
                        type="email"
                        v-model="form.email"
                        :class="{ 'is-invalid': form.errors.has('email') }"
                        required
                        name="email"
                        autocomplete="email">
          </b-form-input>
          <has-error :form="form" field="email"/>
        </b-form-group>

        <b-form-group :label="$t('password')"
                      label-for="login-password">
          <b-form-input id="login-password"
                        type="password"
                        v-model="form.password"
                        :class="{ 'is-invalid': form.errors.has('password') }"
                        required
                        name="password"
                        autocomplete="current-password">
          </b-form-input>
          <has-error :form="form" field="password"/>
        </b-form-group>

        <b-form-group id="login-remember">
          <b-form-checkbox-group v-model="remember" id="login-remember">
            <b-form-checkbox name="remember">{{ $t('remember_me') }}</b-form-checkbox>
            <!-- <router-link :to="{ name: 'password.request' }" class="small float-right my-auto">
              {{ $t('forgot_password') }}
            </router-link> -->
          </b-form-checkbox-group>
        </b-form-group>

        <v-button :loading="form.busy">{{ $t('login') }}</v-button>
      </form>
    </b-modal>
  </span>
</template>

<script>
import Form from 'vform'

export default {
  name: 'Login',

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false
  }),

  methods: {
    async login () {
      let loginMessage = this.$t('successful_login_header')

      // Submit the form.
      const { data } = await this.form.post('/api/login')

      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      try {
        this.$snotify.success(loginMessage)

        this.$refs.loginModal.hide()
      } catch(e) {
        // console.warn(e)
      }
    }
  }
}
</script>
