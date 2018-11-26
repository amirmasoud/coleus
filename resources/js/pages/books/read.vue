<template>
  <div v-if="page && ! this.$apollo.queries.page.loading">
    <div class="row" v-html="page.content"></div>
    <b-link v-if="page.next" :to="{ name: 'books.read', params: { slug: slug, page: page.next }}">Next</b-link>
    <b-link v-if="page.prev" :to="{ name: 'books.read', params: { slug: slug, page: page.prev }}">Prev</b-link>
  </div>
  <div v-else class="my-4 text-center"><img :src="'/svg-loaders/oval.svg'" /></div>
</template>

<script>
import gql from 'graphql-tag'

export default {
  metaInfo () {
    return { title: this.$t('read_book') }
  },

  props: {
    firstId: Number,
    slug: String
  },

  data () {
    return {
      id: this.$route.params['page'],
      page: null
    }
  },

  apollo: {
    page: {
      query: require('~/graphql/page.gql'),
      variables() {
        return {
          id: this.id || this.firstId
        }
      },
    },
  },

  created () {
    this.$nextTick(() => {
      this.$apollo.queries.page.refetch()
    });
  }
}
</script>
