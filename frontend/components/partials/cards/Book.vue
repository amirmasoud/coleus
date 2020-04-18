<template>
  <div
    itemtype="http://schema.org/Book"
    class="max-w-md shadow-md bg-white rounded-br-none rounded-bl-none rounded-tr rounded-tl overflow-hidden border border-gray-300"
  >
    <no-ssr>
      <progressive-img
        itemprop="image"
        :src="book.medium"
        :placeholder="book.thumbnail"
        :blur="30"
        :aspect-ratio="1.5"
      />
    </no-ssr>
    <div class="px-4">
      <div v-if="$route.name == 'books'" class="text-gray-400 text-sm">
        <nuxt-link
          class="hover:text-indigo-500 focus:text-indigo-500 transition-all duration-300 ease-in-out"
          :to="{ name: 'username', params: { username: book.book_users[0].user.username } }"
        >{{ book.book_users[0].user.name }}</nuxt-link>
      </div>
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
