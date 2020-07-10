<template>
  <div class="container mx-auto p-4">
    <coleus-svg-404 v-if="error.statusCode === 404" class="max-w-3xl mx-auto" />

    <h1 v-if="error.statusCode !== 404">{{ error.statusCode }}</h1>

    <h3 class="mt-20 text-center text-2xl font-thin">{{ error.message }}</h3>

    <nuxt-link to="/" class="block text-center font-bold mt-4"
      >رفتن به خانه ←</nuxt-link
    >
  </div>
</template>

<script>
export default {
  props: {
    error: {
      type: Object,
      required: true
    }
  }
}
</script>
