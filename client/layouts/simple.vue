<template>
  <div dir="rlt" style="direction: rtl;">
    <navbar />

    <div class="container mx-auto w-full h-full max-w-3xl mt-16">
      <Nuxt />
    </div>
  </div>
</template>

<script>
import Navbar from '~/components/Navbar'

export default {
  components: { Navbar },

  mounted() {
    if (process.client && window) {
      window.history.scrollRestoration = 'auto'
    }
  }
}
</script>
