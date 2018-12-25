<template>
  <span
    v-on:close-modal="closeModal"
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

  methods: {
    closeModal () {
      this.$refs.loginModal.hide()
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
