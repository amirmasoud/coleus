<template>
  <!-- <neg-container class="mb-12 bg-gray-100 lg:bg-transparent rounded">
    <section class="lg:bg-gray-100 rounded py-6 sm:p-6"> -->
  <neg-container>
    <div class="lg:flex">
      <neg-aside class="hidden lg:block"/>
      <div class="min-h-screen w-full lg:static lg:max-h-full lg:overflow-visible lg:w-3/4">
        <nuxt-child />
      </div>
    </div>
  </neg-container>
</template>

<script>
import negAside from '@/components/partials/Aside'

export default {
  components: {
    negAside
  },
  validate ({ store, params }) {
    return store.state.menu[params.section] !== undefined
  }
}
</script>
