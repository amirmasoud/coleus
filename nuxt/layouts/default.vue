<template>
  <div dir="rlt">
    <navbar />
    <div class="container mx-auto flex w-full max-w-3xl px-3 mt-16">
      <Nuxt />
    </div>
  </div>
</template>

<script>
import Navbar from '~/components/Navbar'

export default {
  components: {
    Navbar
  }
}
</script>
