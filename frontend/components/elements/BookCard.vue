<template>
  <div
    itemprop="book"
    itemscope
    itemtype="http://schema.org/Book"
    property="book"
    typeof="Book"
    class="max-w-md bg-white rounded-lg"
  >
    <meta itemprop="bookFormat" content="EBook/DAISY3" />
    <meta itemprop="accessMode" content="{textual}" />
    <meta itemprop="accessModeSufficient " content="{textual}" />
    <meta itemprop="inLanguage" content="fa" />
    <meta itemprop="thumbnailUrl" :content="book.medium" />
    <meta property="bookFormat" content="EBook/DAISY3" />
    <meta property="accessMode" content="{textual}" />
    <meta property="accessModeSufficient " content="{textual}" />
    <meta property="inLanguage" content="fa" />
    <meta property="thumbnailUrl" :content="book.medium" />
    <img :src="book.medium" class="hidden" property="image" itemprop="image" />
    <client-only>
      <progressive-img
        itemprop="image"
        :src="book.medium"
        :placeholder="book.thumbnail"
        :blur="30"
        :aspect-ratio="1.5"
        class="book-cover"
      />
    </client-only>
    <div class="">
      <div v-if="$route.name == 'books'" class="text-gray-900 font-light">
        <nuxt-link
          class="hover:text-indigo-500 focus:text-indigo-500 transition-all duration-300 ease-in-out truncate"
          :to="{
            name: 'username',
            params: { username: book.book_users[0].user.username }
          }"
          itemprop="author"
          itemscope
          itemtype="http://schema.org/Person"
          property="author"
          typeof="Person"
          >{{ book.book_users[0].user.name }}</nuxt-link
        >
      </div>
      <div
        class="text-lg font-semibold mb-1 pb-3 pt-1 truncate"
        itemprop="name"
        property="name"
      >
        {{ book.title }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    book: {
      type: Object,
      default: () => {}
    }
  }
}
</script>
