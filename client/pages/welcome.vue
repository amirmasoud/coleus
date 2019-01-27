<template>

  <!-- List of users -->
  <b-row v-if="users">
    <b-col cols="6" sm="4" md="4" lg="3" xl="2"
           v-for="user in users" :key="user.id">
      <user-card :user="user"></user-card>
    </b-col>
  </b-row>

  <!-- Loading -->
  <oval-loader v-else />

</template>

<script>
export default {
  head () {
    return {
      title: this.$t('home'),
      meta: [
        { name: 'description', content: 'نگارین، جایی برای خواندن و مطالعه' },

        { property: 'og:description', content: 'نگارین، جایی برای خواندن و مطالعه', vmid: 'og:description' },
        { name: 'twitter:description', content: 'نگارین، جایی برای خواندن و مطالعه', vmid: 'twitter:description' },
        { itemprop: 'description', content: 'نگارین، جایی برای خواندن و مطالعه', vmid: 'description' },

        { property: 'og:title', content: 'نگارین', vmid: 'og:title' },
        { name: 'twitter:title', content: 'نگارین', vmid: 'twitter:title' },
        { itemprop: 'name', content: 'نگارین', vmid: 'title' },

        { property: 'og:image', content: 'https://negar.in/images/logo-512x512.png', vmid: 'og:image' },
        { name: 'twitter:image', content: 'https://negar.in/images/logo-512x512.png', vmid: 'twitter:image' },
        { itemprop: 'image', content: 'https://negar.in/images/logo-512x512.png', vmid: 'image' },
      ]
    }
  },

  apollo: {
    users: {
      query: require('~/graphql/users.gql'),
      prefetch: true
    },
  }
}
</script>
