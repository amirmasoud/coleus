<template>
  <div v-if="user">
    <div class="py-2 mx-4 border-b border-platinum">
      <div class="flex justify-start">
        <user-small-image :user="user"/>
        <div class="mr-2 float-right">
          <h4>{{ user.name }}</h4>
          <small>@{{ user.username }}</small>
        </div>
      </div>
    </div>

    <div v-if="user.books && user.books.length" class="flex content-start flex-wrap mx-2">
      <div
        v-for="book in user.books"
        :key="book.id"
        class="w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 xl:w-1/6 p-2"
        data-aos="fade-in"
        data-aos-duration="300"
        data-aos-easing="ease-in-sine"
        data-aos-once="true"
      >
        <book-card :book="book" link-to="detail" />
      </div>
    </div>
    <book-nil v-else/>
  </div>

  <OvalLoader v-else/>
</template>

<script>
import AOS from 'aos'
import 'aos/dist/aos.css'
import profile from '~/graphql/profile'
import BookNil from '~/components/nils/Book'
import BookCard from '~/components/cards/Book'
import UserSmallImage from '~/components/images/UserSmall'

export default {
  head() {
    return {
      title: this.user ? this.user.name : ''
    }
  },

  components: {
    UserSmallImage,
    BookCard,
    BookNil
  },

  created() {
    if (process.client) {
      AOS.init()
    }
  },

  apollo: {
    user: {
      query: profile,
      prefetch: ({ route }) => ({ username: route.params.username }),
      variables() {
        return { username: this.$route.params.username }
      }
    }
  },

  methods: {
    async refetch() {
      // Let the child component know about process, so spinning icon will be
      // shown as long as parent process completed.
      this.loadingUser = true

      await this.$apollo.queries.user.refetch()

      this.loadingUser = false
    }
  }
}
</script>
