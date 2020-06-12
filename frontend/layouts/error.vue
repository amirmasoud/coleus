<template>
  <div class="container mx-auto">
    <h1>{{ error.statusCode }}</h1>
    <h1 v-if="error.statusCode === 404">این صفحه پیدا نشد</h1>
    <h1 v-else>خطایی رخ داد</h1>
    <h3>{{ error.message }}</h3>
    <nuxt-link to="/">خانه</nuxt-link>
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
