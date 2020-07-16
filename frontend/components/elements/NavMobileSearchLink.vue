<template>
  <button
    class="flex flex-col items-center justify-between md:justify-center w-full p-2 md:p-4 text-gray-900 hover:no-underline hover:text-indigo-500 text-center focus:outline-none"
    :class="[searchOpen === true ? 'text-indigo-500' : 'text-gray-900']"
  >
    <coleus-svg-search class="w-4" />
    <span class="block text-xs md:text-base font-medium"><slot></slot></span>
  </button>
</template>

<script>
export default {
  props: {
    searchOpen: {
      type: Boolean,
      default: false
    }
  }
}
</script>
