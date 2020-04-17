<template>
  <div itemtype="http://schema.org/Book" class="max-w-md rounded overflow-hidden border">
    <img itemprop="image" :src="book.medium" />
    <div class="px-4 py-2">
      <div itemprop="name" class="text-lg mb-1 py-1">{{ book.title }}</div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'BookCard',
  props: ['book']
}
</script>
