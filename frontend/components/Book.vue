<template>
  <div class="px-4 py-2 border-b">
    <div class="flex">
      <img class="w-16 h-auto object-cover self-start shadow border-2 border-gray-100 shadow-md" :src="book.image" />
      <div class="flex flex-col justify-start w-2/3 px-4">
        <div>
          <h1 class="font-semibold">{{ book.name }}</h1>
          <p class="mt-1 text-gray-500 text-xs truncate">{{ book.subtitle }}</p>
          <p class="mt-1 text-gray-500 text-xs truncate">{{ book.year }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['book']
}
</script>