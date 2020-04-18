<template>
  <div class="relative">
    <input
      id="algolia"
      v-model="q"
      class="coleus-search-input"
      type="text"
      name="search"
      placeholder="جستجو"
      dir="rtl"
    />
    <coleus-search-icon
      class="block absolute text-gray-600 z-10 h-4 mt-3 ml-3 left-0 top-0 fill-current"
    />
  </div>
</template>

<script>
import coleusSearchIcon from '@/components/svg/Search'

export default {
  components: {
    coleusSearchIcon
  }
}
</script>

<style lang="scss">
.coleus-search-input {
  @apply bg-gray-200 border border-gray-300 text-coleus-gray font-medium px-4 pl-10 rounded-full h-10 outline-none w-full;
  ::placeholder {
    @apply text-gray-600;
  }
}
</style>
