<template>
  <div v-if="page">
    <div class="row" v-html="page.content"></div>
  </div>
</template>

<script>
import gql from 'graphql-tag'

export default {
  metaInfo () {
    return { title: this.$t('read_book') }
  },

  props: {
    firstId: Number
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
