<template>
  <div v-if="users" class="flex content-start flex-wrap">
    <div
      v-for="user in users"
      :key="user.id"
      class="w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 xl:w-1/8 p-2"
    >
      <user-card :user="user" />
    </div>
  </div>
  <div v-else class="mt-5">
    <oval-loader />
  </div>
</template>

<script>
import UserCard from '~/components/cards/User'

export default {
  head: {
    title: 'خانه',
    meta: [
      {
        hid: 'description',
        name: 'description',
        content: 'About page description'
      }
    ]
  },

  components: {
    UserCard
  },

  apollo: {
    users: {
      query: require('../graphql/users.gql')
    }
  }
}
</script>
