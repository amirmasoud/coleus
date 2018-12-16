<template>
  <b-row v-if="users">
    <b-col cols="6"
           sm="4"
           md="4"
           lg="3"
           xl="2"
           v-for="writer in users"
           :key="writer.id">
      <b-link :to="{ name: 'profile', params: { username: writer.username }}">
        <div class="card mb-2">
          <img :src="writer.small" class="d-none">
          <no-ssr>
            <progressive-img class="card-img-top"
                             :src="writer.small"
                             :placeholder="writer.placeholder"
                             :fallback="writer.photo_url"
                             :aspect-ratio="1" />
          </no-ssr>
          <div class="card-body">
            <p class="card-title">{{ writer.name }}</p>
          </div>
        </div>
      </b-link>
    </b-col>
  </b-row>
  <div v-else class="my-4 text-center"><img src="svg-loaders/oval.svg" /></div>
</template>

<script>
export default {
  head () {
    return { title: this.$t('home') }
  },

  data: () => ({
    users: null
  }),

  apollo: {
    users: {
      query: require('~/graphql/users.gql'),
      prefetch: true
    },
  }
}
</script>
