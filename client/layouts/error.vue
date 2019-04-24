<template>
  <div class="h-screen-93 font-sans">
    <div class="container mx-auto h-full flex justify-center items-center">
      <div class="w-1/3">
        <h1 class="mb-12 text-5xl text-center">{{ error.statusCode }}</h1>
        <h1
          class="font-hairline mb-6 text-center"
          v-if="error.statusCode === 404"
        >این صفحه پیدا نشد.</h1>
        <h1 class="font-hairline mb-6 text-center" v-else>خطایی رخ داده است</h1>
        <p class="font-hairline mb-6 text-center">
          <nuxt-link
            class="no-underline text-sweet-brown hover:text-bittersweet-shimmer"
            to="/"
          >بازگشت به خانه</nuxt-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  head() {
    return {
      title: `خطای ${this.error.statusCode}`
    }
  },

  props: ['error']
}
</script>
