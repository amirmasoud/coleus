<template>
  <NuxtLink :to="link" class="no-underline text-deep-space-sparkle hover:outer-space">
    <div
      itemtype="http://schema.org/Book"
      class="border-b border-platinum flex flex-wrap"
    >
      <img itemprop="image" :src="book.cover" class="hidden">
      <div class="w-1/8">
        <no-ssr>
          <progressive-img
            :src="book.cover"
            :placeholder="book.placeholder"
            :aspect-ratio="1.6666666667"
            class="rounded"
          />
        </no-ssr>
      </div>
      <div class="w-7/8">
        <div class="pr-4 text-eerie-black hover:text-dark-liver transition">
          <div itemprop="name" class="font-normal mb-1 py-1">
            {{ book.title }}
          </div>
        </div>
      </div>
    </div>
  </NuxtLink>
</template>

<script>
export default {
  name: 'BookRow',

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
            name: 'book-slug',
            params: { slug: this.book.slug }
          }
        : {
            name: 'book-slug-page-id',
            params: { slug: this.book.slug, id: this.book.start }
          }
    }
  }
}
</script>
