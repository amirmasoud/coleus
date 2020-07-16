<template>
  <span>
    <template v-if="userUsername">
      <nuxt-link
        :to="{ name: 'username', params: { username: userUsername } }"
        >{{ userName }}</nuxt-link
      >
    </template>
    <template v-else>{{ userName }}</template>
    <template v-if="bookTitle"> ← {{ bookTitle }} </template>
  </span>
</template>

<script>
export default {
  props: {
    userUsername: {
      type: String,
      default: ''
    },
    userName: {
      type: String,
      default: ''
    },
    bookTitle: {
      type: String,
      default: ''
    }
  }
}
</script>
