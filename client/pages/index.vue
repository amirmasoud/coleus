<template>
  <div>
    <div class="w-full flex justify-between mt-5 pr-2 border-b border-gainsboro pb-2">
      <h1 class="text-2xl pt-1">شاعران</h1>
      <NuxtLink :to="{ name: 'users' }" class="active:bg-prune active:shadow-btn-active active:border-caput-mortuum bg-sweet-brown border border-burnt-umber py-2 px-2 text-white font-normal text-sm rounded shadow-btn hover:bg-vivid-auburn hover:shadow-btn-hover focus:outline-none focus:shadow-outline focus:shadow-btn-focus ml-2 no-underline">
        همه شاعران
      </NuxtLink>
    </div>
    <div
      v-if="users"
      itemscope
      itemtype="http://schema.org/ItemList"
      class="flex content-start flex-wrap"
    >
      <link itemprop="url" :href="baseUrl + $nuxt.$route.fullPath">
      <meta itemprop="numberOfItems" :content="users.data.length">
      <div
        v-for="(user, index) in users.data"
        :key="user.id"
        itemprop="itemListElement"
        itemscope
        itemtype="http://schema.org/ListItem"
        class="w-full"
      >
        <template v-if="index < 5">
          <meta itemprop="position" :content="index">
          <link itemprop="url" :href="`${baseUrl}/@${user.username}`">
          <user-row :user="user" />
        </template>
      </div>
    </div>
    <div v-else class="mt-5">
      <oval-loader />
    </div>

    <div class="w-full flex justify-between mt-8 pr-2 border-b border-gainsboro pb-2">
      <h1 class="text-2xl pt-1">کتاب‌ها</h1>
      <NuxtLink :to="{ name: 'books' }" class="active:bg-prune active:shadow-btn-active active:border-caput-mortuum bg-sweet-brown border border-burnt-umber py-2 px-2 text-white font-normal text-sm rounded shadow-btn hover:bg-vivid-auburn hover:shadow-btn-hover focus:outline-none focus:shadow-outline focus:shadow-btn-focus ml-2 no-underline">
        همه کتاب‌ها
      </NuxtLink>
    </div>
    <div
      v-if="books"
      class="flex content-start flex-wrap"
    >
      <div
        v-for="(book, index) in books.data"
        :key="book.id"
        class="w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 p-2"
      >
        <book-card v-if="index < 5" class="" :book="book" link-to="detail" />
      </div>
    </div>
    <div v-else class="mt-5">
      <oval-loader />
    </div>
  </div>
</template>

<script>
import UserRow from '~/components/rows/User'
import BookCard from '~/components/cards/Book'
export default {
  head: {
    title: 'خانه'
  },

  components: {
    BookCard,
    UserRow
  },

  data: () => ({
    baseUrl: process.env.APP_URL
  }),

  apollo: {
    books: {
      query: require('~/graphql/book/all.gql')
    },
    users: {
      query: require('../graphql/users.gql')
    }
  }
}
</script>
