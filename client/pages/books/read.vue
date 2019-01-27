<template>
  <div v-if="page">
    <b-card class="p-2 reading-container">
      <div class="row" v-html="page.content"></div>
    </b-card>
    <b-row>
      <b-col>
        <b-card v-if="page.next" class="mt-3" no-body>
          <nuxt-link class="d-block text-left p-3"
                  :to="{ name: 'books.read', params: { slug: slug, page: page.next }}">
            <fa icon="angle-double-right" fixed-width /> {{ $t('next') }} <br />
            <small class="text-muted">{{ page.next_title }}</small>
          </nuxt-link>
        </b-card>
      </b-col>
      <b-col>
        <b-card v-if="page.prev" class="mt-3" no-body>
          <nuxt-link class="d-block text-right p-3"
                  :to="{ name: 'books.read', params: { slug: slug, page: page.prev }}">
            {{ $t('prev') }} <fa icon="angle-double-left" fixed-width /> <br />
            <small class="text-muted">{{ page.prev_title }}</small>
          </nuxt-link>
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
export default {
  head () {
    return { title: this.$t('read_book') }
  },

  asyncData ({ params }) {
    return {
      id: params.page,
      slug: params.slug,
      page: null
    }
  },

  apollo: {
    page: {
      query: require('~/graphql/page.gql'),
      prefetch: ({ params }) => {
        return {
          id: params.page
        }
      },
      variables() {
        return {
          id: this.id
        }
      }
    },
  }
}
</script>
