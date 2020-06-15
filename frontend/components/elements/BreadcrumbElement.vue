<template>
  <span>
    <nuxt-link :to="{ name: 'username', params: { username: userUsername } }">{{
      userName
    }}</nuxt-link>
    ← {{ bookTitle }}
  </span>
</template>

<script>
export default {
  props: ['userUsername', 'userName', 'bookTitle']
}
</script>
