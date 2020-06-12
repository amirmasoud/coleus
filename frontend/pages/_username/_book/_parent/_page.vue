<template>
  <coleus-container>
    <div class="lg:flex">
      <coleus-aside
        class="h-screen w-screen lg:block"
        :class="[toggleContents ? 'block' : 'hidden']"
        :loading="$apollo.loading"
      />
      <nuxt-child :class="[toggleContents ? 'hidden' : 'block']" />
    </div>
  </coleus-container>
</template>

<script>
export default {
  data: () => ({
    toggleContents: false
  }),
  created() {
    this.$root.$on('toggle-contents', () => {
      this.toggleContents = !this.toggleContents
    })
  }
}
</script>
