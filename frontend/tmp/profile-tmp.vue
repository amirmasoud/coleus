<template>
  <div v-if="users && users.length">
    <div v-for="user in users" :key="user.id">
      <div class="py-2 mx-4 border-b border-platinum">
        <div class="flex justify-start">
          <user-small-image :user="user" />
          <div class="mr-2 float-right">
            <h4>{{ user.name }}</h4>
            <small>{{ user.username }}</small>
          </div>
        </div>
      </div>

      <div v-if="user.book_users && user.book_users.length" class="flex content-start flex-wrap mx-2">
        <div
          v-for="{book} in user.book_users"
          :key="book.id"
          class="p-2 w-1/2"
        >
          <book-card :book="book" link-to="detail" />
        </div>
      </div>
    </div>
    <!--
    <book-nil v-else />-->
  </div>
  <div v-else>Loading...</div>
  <!-- <div v-if="user">
    <div class="py-2 mx-4 border-b border-platinum">
      <div class="flex justify-start">
        <user-small-image :user="user" />
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
        class="w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 pt-2 pr-2"
      >
        <book-card class="p-2" :book="book" link-to="detail" />
      </div>
    </div>
    <book-nil v-else />
  </div>

  <OvalLoader v-else />-->
</template>

<script>
import profile from '~/graphql/profile'
import BookNil from '~/components/nils/Book'
import BookCard from '~/components/cards/Book'
import UserSmallImage from '~/components/images/UserSmall'

export default {
  head() {
    return {
      title: this.users ? this.users[0].name : ''
    }
  },

  components: {
    UserSmallImage,
    BookNil,
    BookCard
  },

  apollo: {
    users: {
      query: profile,
      prefetch: ({ route }) => ({ username: route.params.profile }),
      variables() {
        return { username: this.$route.params.profile }
      }
    }
  },

  methods: {
    // async refetch() {
    //   // Let the child component know about process, so spinning icon will be
    //   // shown as long as parent process completed.
    //   this.loadingUser = true
    //   await this.$apollo.queries.user.refetch()
    //   this.loadingUser = false
    // }
  }
}
</script>
