<template>
  <b-row v-if="writers">
    <b-col cols="6"
           sm="4"
           md="4"
           lg="3"
           xl="2"
           v-for="writer in writers"
           :key="writer.id">
      <div>
        <b-card :title="writer.name"
                :img-src="writer.small"
                :img-alt="`${writer.name}'s image`"
                img-top
                title-tag="h5"
                class="mb-2">
        </b-card>
      </div>
    </b-col>
  </b-row>
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
      const {data} = await axios.get(`graphql/?query=
        query FetchUsers {
          users(sticky: true) {
            id
            name
            small
          }
        }`)
      this.writers = data.data.users
    }
  }
}
</script>
