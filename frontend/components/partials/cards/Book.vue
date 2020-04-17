<template>
  <NuxtLink :to="link" class="no-underline">
    <div
      itemtype="http://schema.org/Book"
      class="max-w-md rounded overflow-hidden border"
    >
      <img itemprop="image" :src="book.medium">
      <div class="px-4 py-2">
        <div itemprop="name" class="text-lg mb-1 py-1">
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
      type: Object,
      default: () => {}
    },

    linkTo: {
      type: String,
      default: 'content' // detail
    }
  },

  computed: {
    link() {
      return this.linkTo === 'detail'
        ? {
            name: 'username-book',
            params: { book: this.book.slug }
          }
        : {
            name: 'book-slug-page-id',
            params: { slug: this.book.slug, id: this.book.start }
          }
    }
  }
}
</script>
