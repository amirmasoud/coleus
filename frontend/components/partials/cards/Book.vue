<template>
  <div
    itemtype="http://schema.org/Book"
    class="max-w-md bg-white rounded-tr rounded-tl overflow-hidden"
  >
    <client-only>
      <progressive-img
        itemprop="image"
        :src="book.medium"
        :placeholder="book.thumbnail"
        :blur="30"
        :aspect-ratio="1.5"
        class="shadow border border-gray-200 rounded"
      />
    </client-only>
    <div class="">
      <div v-if="$route.name == 'books'" class="text-gray-900 font-light">
        <nuxt-link
          class="hover:text-indigo-500 focus:text-indigo-500 transition-all duration-300 ease-in-out"
          :to="{ name: 'username', params: { username: book.book_users[0].user.username } }"
        >{{ book.book_users[0].user.name }}</nuxt-link>
      </div>
      <div itemprop="name" class="text-lg font-bold mb-1 pb-3 pt-1">{{ book.title }}</div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'BookCard',
  props: ['book']
}
</script>
