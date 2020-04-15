<template>
  <div v-if="books && books.length">
    <div class="py-2 mx-4 border-b border-platinum">
      <div class="flex justify-start">
        <user-small-image :user="books[0].book_users[0].user" />
        <div class="mr-2 float-right">
          <h4>{{ books[0].book_users[0].user.name }}</h4>
          <small>{{ books[0].book_users[0].user.username }}</small>
        </div>
      </div>
    </div>
    <div v-for="book in books" :key="book.id">
      <div class="flex flex-wrap content-start mx-4 py-2 border-b border-platinum">
        <div class="w-full md:w-1/4">
          <book-card :book="book" />
          <NuxtLink
            :to="{ name: 'book-slug-page-id', params: { slug: book.slug, id: book.start }}"
            class="no-underline"
          >
            <button
              class="w-full my-4 py-4 px-2 bg-indigo-400 text-white text-sm border-indigo-500 shadow hover:shadow-lg hover:bg-indigo-600 font-normal rounded transition duration-500 ease-in-out"
            >خواندن</button>
          </NuxtLink>
        </div>
        <div class="w-full md:w-3/4 pr-2">
          <div
            :class="{'max-h-64 overflow-hidden': !expanded}"
            class="leading-loose"
          >{{ book.description }}</div>
          <div class="flex items-stretch bg-anti-flash-white h-8 mt-2">
            <button
              class="self-auto flex-1 font-normal text-sm rounded text-sweet-brown text-center px-4 border-t-0 focus:outline-none focus:shadow-btn-focus"
              @click.prevent="toggle"
            >{{ `توضیحات ${expanded ? 'کمتر' : 'بیشتر'} درباره‌ی ${book.title} ${book.book_users[0].user.name}` }} {{ expanded ? '▲' : '▼' }}</button>
          </div>

          <div class="flex flex-wrap mt-4">
            <h4 class="flex-1 my-4 mr-4 inline-block">فهرست {{ book.title }}</h4>
          </div>

          <div class="max-h-screen overflow-y-scroll book-contents mx-4">
            <div v-for="page in book.pages" :key="page.id">
              <strong class="block py-2 px-4 mb-1">{{ page.title }}</strong>
              <div v-for="subpage in page.pages" :key="subpage.id">
                <NuxtLink
                  class="no-underline py-2 px-2"
                  :to="{ name: 'username-book-page', params: { page: subpage.id }}"
                >{{ subpage.title }}</NuxtLink>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import BookCard from '~/components/cards/Book'
import UserSmallImage from '~/components/images/UserSmall'

export default {
  head() {
    return {
      title: ''
    }
  },

  components: {
    UserSmallImage,
    BookCard
  },

  data: () => ({
    expanded: false,
    query: ''
  }),

  apollo: {
    books: {
      query: require('~/graphql/book/single.gql'),
      prefetch: ({ route }) => ({ slug: route.params.book }),
      variables() {
        return { slug: this.$route.params.book }
      }
    }
  },

  methods: {
    toggle() {
      this.expanded = !this.expanded
    }
  }
}
</script>

<style scoped>
.book-contents {
  direction: ltr;
  text-align: center;
}
.book-contents a {
  direction: rtl !important;
  text-align: right;
}
.book-contents::-webkit-scrollbar {
  width: 0.3rem;
  background-color: #d6d9dc;
}
.book-contents::-webkit-scrollbar-thumb {
  background-color: #ae3737;
}
</style>
