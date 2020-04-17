<template>
  <div v-if="users && users.length">
    <div v-for="user in users" :key="user.id">
      <div class="py-2 mx-4 border-b border-platinum">
        <div class="flex justify-start">
          <img :src="user.small" class="w-12 h-12 shadow rounded-full float-right" />
          <div class="mr-2 float-right">
            <h4>{{ user.name }}</h4>
            <small>{{ user.username }}</small>
          </div>
        </div>
      </div>

      <div
        v-if="user.book_users && user.book_users.length"
        class="flex content-start flex-wrap mx-2"
      >
        <div v-for="{book} in user.book_users" :key="book.id" class="p-2 w-1/2">
          <book-card :book="book" link-to="detail" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import BookCard from "~/components/partials/cards/Book";

export default {
  head() {
    return {
      title: this.users ? this.users[0].name : ""
    };
  },

  components: {
    BookCard
  },

  apollo: {
    users: {
      query: require("~/graphql/profile.gql"),
      prefetch: ({ route }) => ({ username: route.params.username }),
      variables() {
        return { username: this.$route.params.username };
      }
    }
  }
};
</script>
