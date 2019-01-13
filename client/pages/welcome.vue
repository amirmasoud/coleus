<template>
  <b-row v-if="users">
    <div class="ph-item">
        <div class="ph-col-12">
            <div class="ph-picture"></div>
            <div class="ph-row">
                <div class="ph-col-6 big"></div>
                <div class="ph-col-4 empty big"></div>
                <div class="ph-col-2 big"></div>
                <div class="ph-col-4"></div>
                <div class="ph-col-8 empty"></div>
                <div class="ph-col-6"></div>
                <div class="ph-col-6 empty"></div>
                <div class="ph-col-12"></div>
            </div>
        </div>
    </div>
    <b-col cols="6"
           sm="4"
           md="4"
           lg="3"
           xl="2"
           v-for="user in users"
           :key="user.id">
      <nuxt-link :to="{ name: 'profile', params: { username: user.username }}">
        <div class="card mb-2">
          <img :src="user.small" class="d-none">
          <no-ssr>
            <progressive-img class="card-img-top"
                             :src="user.small"
                             :placeholder="user.placeholder"
                             :fallback="user.photo_url"
                             :aspect-ratio="1" />
          </no-ssr>
          <div class="card-body">
            <p class="card-title">{{ user.name }}</p>
          </div>
        </div>
      </nuxt-link>
    </b-col>
  </b-row>
  <div v-else class="my-4 text-center"><img src="svg-loaders/oval.svg" /></div>
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
