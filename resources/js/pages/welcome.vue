<template>
  <b-row v-if="writers">
    <b-col cols="6"
           sm="4"
           md="4"
           lg="3"
           xl="2"
           v-for="writer in writers"
           :key="writer.id">
      <b-card :title="writer.name"
              :img-src="writer.small || writer.photo_url"
              :img-alt="`${writer.name}'s image`"
              img-top
              title-tag="p"
              class="mb-2">
      </b-card>
    </b-col>
  </b-row>
  <div v-else class="my-4 text-center"><img src="svg-loaders/oval.svg" /></div>
</template>

<script>
import axios from 'axios'

export default {
  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName,
    writers: null
  }),

  created () {
    this.fetchFeaturedAuthors()
  },

  methods: {
    async fetchFeaturedAuthors () {
      const {data} = await axios.get((`graphql/?query=
        query+FetchUsers {
          users(sticky: true) {
            id,
            name,
            small,
            photo_url
          }
        }`).replace(/\s+/g, ''))
      this.writers = data.data.users
    }
  }
}
</script>
