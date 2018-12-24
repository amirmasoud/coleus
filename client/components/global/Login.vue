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
      v-b-modal.modal-center
    >{{ $t('login') }}</b-btn>
    <b-modal
      id="modal-center"
      centered
      :title="$t('login')"
      hide-footer
      ref="loginModal"
      v-on:hidden="revertUrl">
      <login-form></login-form>
    </b-modal>
  </span>
</template>

<script>
export default {
  name: 'Login',

  mounted: function () {
    this.$root.$on('login-done', this.closeModal)
  },

  methods: {
    closeModal () {
      this.revertUrl()
      this.$refs.loginModal.hide()
    },

    changeUrl () {
      history.pushState({}, null, '/login')
    },

    revertUrl () {
      history.back()
    }
  }
}
</script>
