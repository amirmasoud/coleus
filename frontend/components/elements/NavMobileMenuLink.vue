<template>
  <button
    class="flex flex-col items-center justify-between md:justify-center w-full p-2 md:p-4 hover:no-underline text-center focus:outline-none"
    :disabled="$route.name !== 'username-book-parent-page'"
    :class="[
      $route.name !== 'username-book-parent-page'
        ? 'text-gray-400'
        : 'text-gray-900'
    ]"
    @click.prevent="$root.$emit('toggle-contents')"
  >
    <coleus-svg-bars class="w-4" />
    <span class="block text-xs md:text-base font-medium"><slot></slot></span>
  </button>
</template>
