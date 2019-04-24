<template>
  <div
    v-if="users"
    itemscope
    itemtype="http://schema.org/ItemList"
    class="flex content-start flex-wrap"
  >
    <link itemprop="url" :href="baseUrl + $nuxt.$route.fullPath">
    <meta itemprop="numberOfItems" :content="users.length">
    <div
      v-for="(user, index) in users"
      :key="user.id"
      itemprop="itemListElement"
      itemscope
      itemtype="http://schema.org/ListItem"
      class="w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 xl:w-1/8 p-2"
      data-aos="fade-in"
      data-aos-duration="300"
      data-aos-easing="ease-in-sine"
      data-aos-once="true"
    >
      <meta itemprop="position" :content="index">
      <link itemprop="url" :href="`${baseUrl}/@${user.username}`">
      <user-card :user="user"/>
    </div>
  </div>
  <div v-else class="mt-5">
    <oval-loader/>
  </div>
</template>

<script>
import AOS from 'aos'
import 'aos/dist/aos.css'
import UserCard from '~/components/cards/User'

export default {
  head: {
    title: 'خانه'
  },

  components: {
    UserCard
  },

  data: () => ({
    baseUrl: process.env.APP_URL
  }),

  created() {
    if (process.client) {
      AOS.init()
    }
  },

  apollo: {
    users: {
      query: require('../graphql/users.gql')
    }
  }
}
</script>
