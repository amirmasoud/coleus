<template>
  <nuxt-link
    :to="to"
    class="flex flex-col items-center justify-between md:justify-center w-full p-2 md:p-4 text-gray-900 hover:no-underline text-center focus:outline-none"
    :class="[
      $route.name === routeName && searchOpen === false
        ? 'text-indigo-500'
        : 'text-gray-900'
    ]"
  >
    <component :is="svg" class="w-4" />
    <span class="block text-xs md:text-base font-medium"><slot></slot></span>
  </nuxt-link>
</template>

<script>
import coleusSvgUsers from '@/components/svg/Users'
import coleusSvgBook from '@/components/svg/Book'

export default {
  components: {
    coleusSvgUsers,
    coleusSvgBook
  },
  props: {
    to: {
      type: Object,
      default: () => {}
    },
    routeName: {
      type: String,
      default: ''
    },
    searchOpen: {
      type: Boolean,
      default: false
    },
    svg: {
      type: String,
      default: ''
    }
  }
}
</script>
