<template>
  <span
    v-on:close-modal="closeModal"
    v-on:login-done="closeModal"
  >
    <b-btn
      variant="link"
      class="nav-link"
      @click.prevent="changeUrl"
      style="padding: 0.5rem 0.5rem !important"
      v-b-modal.register-modal-center
    >{{ $t('register') }}</b-btn>
    <b-modal
      id="register-modal-center"
      centered
      :title="$t('register')"
      hide-footer
      ref="registerModal"
      v-on:hidden="revertUrl"
    >
      <register-form prefix="page-"></register-form>
    </b-modal>
  </span>
</template>

<script>
export default {
  name: 'Register',

  mounted () {
    this.$root.$on('login-done', this.closeModal)
  },

  methods: {
    closeModal () {
      this.$refs.registerModal.hide()
    },

    changeUrl () {
      history.pushState({}, null, '/register')
    },

    revertUrl () {
      history.back()
    }
  }
}
</script>
