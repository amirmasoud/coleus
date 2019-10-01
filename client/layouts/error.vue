<template>
  <div class="h-screen font-sans">
    <div class="container mx-auto h-full flex justify-center items-center">
      <div class="w-full">
        <img v-if="error.statusCode === 404" class="mb-24 px-4" src="/icons/undraw_biking.svg">
        <img v-else class="px-4 mb-24" src="/icons/undraw_moonlight.svg">
        <h1
          v-if="error.statusCode === 404"
          class="font-hairline mb-6 text-center"
        >
          این صفحه پیدا نشد.
        </h1>
        <h1 v-else class="font-hairline mb-6 text-center">
          خطایی رخ داده است
        </h1>
        <h1 class="mb-12 text-xl text-center">
          <small class="text-sm font-normal">خطای </small>{{ $toPersian(error.statusCode) }}
        </h1>
        <p class="font-hairline mb-6 text-center">
          <nuxt-link
            class="no-underline text-sweet-brown hover:text-bittersweet-shimmer"
            to="/"
          >
            بازگشت به خانه
          </nuxt-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  head() {
    return {
      title: `خطای ${this.$toPersian(this.error.statusCode)}`
    }
  },

  props: {
    error: {
      type: Object,
      default: () => {}
    }
  }
}
</script>
