<template>
  <div v-if="page && ! this.$apollo.queries.page.loading">
    <b-card class="p-2 reading-container">
      <div class="row" v-html="page.content"></div>
    </b-card>
    <b-row>
      <b-col>
        <b-card v-if="page.next" class="mt-3" no-body>
          <b-link class="d-block text-left p-3"
                  :to="{ name: 'books.read', params: { slug: slug, page: page.next }}">
            <fa icon="angle-double-right" fixed-width /> {{ $t('next') }} <br />
            <small class="text-muted">{{ page.next_title }}</small>
          </b-link>
        </b-card>
      </b-col>
      <b-col>
        <b-card v-if="page.prev" class="mt-3" no-body>
          <b-link class="d-block text-right p-3"
                  :to="{ name: 'books.read', params: { slug: slug, page: page.prev }}">
            {{ $t('prev') }} <fa icon="angle-double-left" fixed-width /> <br />
            <small class="text-muted">{{ page.prev_title }}</small>
          </b-link>
        </b-card>
      </b-col>
    </b-row>
  </div>
  <div v-else>
    <b-card class="p-2 reading-container">
      <img class="d-block mx-auto" :src="'/svg-loaders/oval.svg'" />
    </b-card>
  </div>
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
