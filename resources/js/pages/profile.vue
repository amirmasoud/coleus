<template>
  <div v-if="user">
    <b-row>
      <b-col class="text-left">
        <div class="d-flex justify-content-start">
          <progressive-img :src="user.xsmall"
                           :placeholder="user.placeholder"
                           :fallback="user.photo_url"
                           :aspect-ratio="1"
                           class="rounded float-left img-fluid mr-4"
                           style="width: 64px; height: 64px;" />
          <div>
            <h4><img src="/icons/correct.svg" width="24" height="24"> {{ user.name }}</h4>
            <small>@{{ user.username }}</small>
          </div>
          <div class="ml-3">
            <b-button class="px-4" size="sm" variant="primary" block v-if="!auth || (auth && auth.id != user.id)">+ {{ $t('follow') }}</b-button>
            <b-button class="px-4" size="sm" variant="success" block v-else :to="{ name: 'books.new' }">+ {{ $t('new_book') }}</b-button>
          </div>
        </div>
      </b-col>
    </b-row>
    <div class="d-flex justify-content-around text-center mt-3 border-top border-bottom py-2">
      <b-col>{{ user.books_count }}<br /><small class="text-muted">{{ $t('books') }}</small><br /><small class="text-muted">#1</small></b-col>
      <b-col>{{ user.followers_count }}<br /><small class="text-muted">{{ $t('followers') }}</small><br /><small class="text-muted">#7</small></b-col>
      <b-col>{{ user.following_count }}<br /><small class="text-muted">{{ $t('following') }}</small><br /><small class="text-muted">#10</small></b-col>
      <b-col>0<br /><small class="text-muted">{{ $t('read_count') }}</small><br /><small class="text-muted">+#10k</small></b-col>
      <b-col>0<br /><small class="text-muted">{{ $t('reading_count') }}</small><br /><small class="text-muted">#100</small></b-col>
      <b-col>0<br /><small class="text-muted">{{ $t('toread_count') }}</small><br /><small class="text-muted">#69</small></b-col>
    </div>
    <b-row v-if="user.books && user.books.length" class="mt-3">
      <b-col cols="6"
             sm="4"
             md="4"
             lg="3"
             xl="2"
             v-for="book in user.books"
             :key="book.id">
        <b-link :to="{ name: 'books.read', params: { slug: book.slug }}">
          <div class="card mb-2">
            <progressive-img class="card-img-top"
                             :src="book.cover"
                             :placeholder="book.placeholder"
                             :aspect-ratio="1.6666666667" />
            <div class="card-body">
              <p class="card-title">{{ book.title }}</p>
            </div>
          </div>
        </b-link>
      </b-col>
    </b-row>
    <div class="text-center mt-3" v-else>{{ $t('no_book') }}</div>
  </div>
  <div v-else class="my-4 text-center"><img src="svg-loaders/oval.svg" /></div>
</template>

<script>
import gql from 'graphql-tag'
import { mapGetters } from 'vuex'

export default {
  metaInfo () {
    return { title: this.$t('books') }
  },

  computed: mapGetters({
    auth: 'auth/user'
  }),

  data () {
    return {
      user: null,
      username: this.$route.params['username']
    }
  },

  apollo: {
    user: {
      query: gql`query FetchUserByUsername($username: String) {
          user(username: $username) {
            id,
            name,
            username,
            photo_url,
            xsmall,
            placeholder,
            following_count,
            followers_count,
            books_count,
            books {
              id,
              title,
              description,
              cover,
              placeholder,
              slug,
            }
          }
        }`,
      variables() {
        return{
          username: this.username,
        }
      },
    },
  }
}
</script>
