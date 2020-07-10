<template>
  <div class="container mx-auto p-4">
    <coleus-svg-404 v-if="error.statusCode === 404" class="max-w-3xl mx-auto" />
    <coleus-svg-500 v-else class="max-w-3xl mx-auto" />

    <h3 class="mt-20 text-center text-2xl font-thin">{{ error.message }}</h3>
    <p class="text-center font-hairline italic">Err. {{ error.statusCode }}</p>

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
