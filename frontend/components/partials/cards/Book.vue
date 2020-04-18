<template>
  <div
    itemtype="http://schema.org/Book"
    class="max-w-md shadow-md bg-white rounded overflow-hidden border border-gray-300"
  >
    <no-ssr>
      <progressive-img
        itemprop="image"
        :src="book.medium"
        :placeholder="book.thumbnail"
        :blur="30"
        aspect-ratio="1.5"
      />
    </no-ssr>
    <div class="px-4">
      <div v-if="$route.name == 'books'" class="text-gray-400 text-sm">{{ book.book_users[0].user.name }}</div>
      <div itemprop="name" class="text-lg mb-1 pb-3 pt-1">{{ book.title }}</div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'BookCard',
  props: ['book']
}
</script>
