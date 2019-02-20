<template>
  <NuxtLink :to="{ name: 'book-slug-page-id', params: { slug: book.slug, id: book.start }}" class="no-underline text-black">
    <div class="max-w-sm rounded overflow-hidden shadow-md hover:shadow-lg transition bg-white">
      <img :src="book.cover" class="hidden">
      <no-ssr>
        <progressive-img
          :src="book.cover"
          :placeholder="book.placeholder"
          :aspect-ratio="1.6666666667"
        />
      </no-ssr>
      <div class="px-4 py-2">
        <div class="text-lg mb-1 py-1">
          {{ book.title }}
        </div>
      </div>
    </div>
  </NuxtLink>
</template>

<script>
export default {
  name: 'BookCard',

  props: {
    book: {
      type: Object
    }
  }
}
</script>
