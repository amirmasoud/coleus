<template>
  <div v-if="user">
    <b-row>
      <b-col cols="4" sm="2">
        <b-img v-if="user.small" rounded="circle" width="128" height="128" alt="avatar" class="my-1" :src="user.small" left fluid />
        <b-img v-else rounded="circle" width="128" height="128" alt="avatar" class="my-1" :src="user.photo_url" left fluid />
      </b-col>
      <b-col cols="8" sm="10" class="text-left">
        <div class="d-flex justify-content-start">
          <div>
            <h4>{{ user.name }}</h4>
            <small>@{{ user.username }}</small>
          </div>
          <div class="float-right ml-3">
            <b-button class="px-4" size="sm" variant="primary" block v-if="!auth || (auth && auth.id != user.id)">+ {{ $t('follow') }}</b-button>
            <b-button class="px-4" size="sm" variant="success" block v-else :to="{ name: 'books.new' }">+ {{ $t('new_book') }}</b-button>
          </div>
        </div>
      </b-col>
    </b-row>
    <div class="d-flex justify-content-around text-center mt-3 border-top border-bottom py-2">
      <b-col cols="4">{{ user.books_count }}<br /><small class="text-muted">{{ $t('books') }}</small></b-col>
      <b-col cols="4">{{ user.followers_count }}<br /><small class="text-muted">{{ $t('followers') }}</small></b-col>
      <b-col cols="4">{{ user.following_count }}<br /><small class="text-muted">{{ $t('following') }}</small></b-col>
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
          <b-card :title="book.title"
                  :img-src="book.cover"
                  :img-alt="`${user.name}'s book`"
                  img-top
                  title-tag="p"
                  class="mb-2">
          </b-card>
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
            small,
            following_count,
            followers_count,
            books_count,
            books {
              id,
              title,
              description,
              cover,
              slug,
              collaborators {
                collaboration_role,
                name,
                username,
                photo_url,
                xsmall
              }
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
