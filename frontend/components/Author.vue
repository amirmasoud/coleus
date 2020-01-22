<template>
  <div class="px-4 py-2 border-b">
    <div class="flex">
      <img class="w-16 h-16 object-cover rounded-full self-start shadow-md border-2 border-gray-100 shadow" :src="author.image" />
      <div class="flex flex-col justify-center w-2/3 px-4">
        <div>
          <h1 class="font-semibold">{{ author.name }}</h1>
          <p class="mt-1 text-gray-500 uppercase text-xs tracking-wider truncate">{{ author.subtitle }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['author']
}
</script>