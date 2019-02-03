<template>
  <nuxt-link :to="{ name: 'books.read', params: { slug: book.slug, page: book.start }}">
    <div class="card mb-2">
      <img :src="book.cover" class="d-none">
      <no-ssr>
        <progressive-img class="card-img-top"
                         :src="book.cover"
                         :placeholder="book.placeholder"
                         :aspect-ratio="1.6666666667" />
      </no-ssr>
      <div class="card-body">
        <p class="card-title">{{ book.title }}</p>
      </div>
    </div>
  </nuxt-link>
</template>

<script>
export default {
  name: 'book-card',

  props: {
    book: {
      type: Object
    }
  }
}
</script>
