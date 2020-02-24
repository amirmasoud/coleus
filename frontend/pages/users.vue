<template>
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
      <meta itemprop="position" :content="index">
      <link itemprop="url" :href="`${baseUrl}/@${user.username}`">
      <user-row :user="user" />
    </div>
  </div>
  <div v-else class="mt-5">
    <oval-loader />
  </div>
</template>

<script>
import UserRow from '~/components/rows/User'

export default {
  head: {
    title: 'خانه'
  },

  components: {
    UserRow
  },

  data: () => ({
    baseUrl: process.env.APP_URL
  }),

  apollo: {
    users: {
      query: require('../graphql/users.gql')
    }
  }
}
</script>
