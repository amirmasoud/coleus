<template>
  <div v-if="users" class="flex content-start flex-wrap">
    <div
      v-for="user in users"
      :key="user.id"
      class="w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 xl:w-1/8 p-2"
      data-aos="fade-in"
      data-aos-duration="300"
      data-aos-easing="ease-in-sine"
      data-aos-once="true"
    >
      <user-card :user="user" />
    </div>
  </div>
  <div v-else class="mt-5">
    <oval-loader />
  </div>
</template>

<script>
import AOS from 'aos'
import 'aos/dist/aos.css'
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
