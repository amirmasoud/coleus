<template>
  <coleus-container>
    <div class="lg:flex lg:relative">
      <coleus-aside
        class="h-screen w-screen lg:block"
        :class="[toggleContents ? 'block' : 'hidden']"
        :loading="$apollo.loading"
      />
      <coleus-alert-warning v-if="showError"
        >خطایی رخ داده است.</coleus-alert-warning
      >
      <nuxt-child :class="[toggleContents ? 'hidden' : 'block']" />
    </div>
  </coleus-container>
</template>

<script>
export default {
  data: () => ({
    toggleContents: false,
    showError: false
  }),
  created() {
    this.$root.$on('close-menu', () => {
      this.toggleContents = false
    })
    this.$root.$on('toggle-contents', () => {
      this.toggleContents = !this.toggleContents
    })
    this.$root.$on('graphql-error', () => {
      this.showError = true
    })
  }
}
</script>
