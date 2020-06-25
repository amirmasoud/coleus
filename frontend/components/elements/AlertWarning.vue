<template>
  <div
    v-if="show"
    class="fixed bottom-0 w-full sm:w-auto px-8 py-4 mb-12 sm:mb-24 lg:mb-4 lg:mr-4 text-center lg:text-right bg-yellow-200 border border-yellow-400 text-yellow-800 lg:rounded"
  >
    <slot></slot>
    <button type="button" @click.prevent="show = false">x</button>
  </div>
</template>

<script>
export default {
  data: () => ({
    show: true
  })
}
</script>
