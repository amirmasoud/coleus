<template>
  <span v-on:close-modal="closeModal">

    <!-- Login Button -->
    <b-btn
      variant="link"
      class="nav-link"
      @click.prevent="changeUrl"
      style="padding: 0.5rem 0.5rem !important"
      v-b-modal.modal-center
    >{{ $t('login') }}</b-btn>

    <!-- Login Modal -->
    <b-modal
      id="modal-center"
      centered
      :title="$t('login')"
      hide-footer
      ref="loginModal"
      v-on:hidden="revertUrl">
      <login-form prefix="page-"></login-form>
    </b-modal>

  </span>
</template>

<script>
export default {
  name: 'Login',

  data: () => ({
    // for controling history state.
    revert: true
  }),

  mounted () {
    // Listen to `login-done` event on child components.
    this.$root.$on('login-done', this.closeModal)
  },

  methods: {
    /**
     * Revert url and hide modal on close modal event emitted.
     *
     * @return {void}
     */
    closeModal () {
      this.revertUrl()
      this.$refs.loginModal.hide()
    },

    /**
     * Change path to login after modal open. its useful when user refresh the
     * page on modal open.
     *
     * @return {void}
     */
    changeUrl () {
      history.pushState({}, null, '/login')
    },

    /**
     * Revert url to its original state after modal hide
     *
     * @return {void}
     */
    revertUrl () {
      if (this.revert) {
        history.back()
      }
      this.revert = true
    },
  },

  watch:{
    /**
     * When clicked on reset password link on madal, prevent history to revert
     * the history to /login path.
     *
     * @param  {object} to
     * @param  {object} from
     * @return {void}
     */
    $route (to, from) {
      if (to.name == 'password.request') {
        this.revert = false
        this.$refs.loginModal.hide()
      }
    }
  }
}
</script>
