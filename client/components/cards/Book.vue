<template>
  <NuxtLink
    :to="{ name: 'book-slug-page-id', params: { slug: book.slug, id: book.start }}"
    class="no-underline text-deep-space-sparkle hover:outer-space"
  >
    <div
      itemtype="http://schema.org/Book"
      class="max-w-md rounded overflow-hidden border border-x11-grey hover:border-silver-chalice transition bg-alabster hover:bg-almond"
    >
      <img itemprop="image" :src="book.cover" class="hidden">
      <no-ssr>
        <progressive-img
          :src="book.cover"
          :placeholder="book.placeholder"
          :aspect-ratio="1.6666666667"
        />
      </no-ssr>
      <div class="px-4 py-2">
        <div itemprop="name" class="text-lg mb-1 py-1">{{ book.title }}</div>
      </div>
    </div>
  </NuxtLink>
</template>

<script>
export default {
  name: 'BookCard',

  props: {
    book: {
      type: Object,
      default: () => {}
    }
  }
}
</script>
