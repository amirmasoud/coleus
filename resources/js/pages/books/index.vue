<template>
  <b-row>
    <b-col cols="12"
           sm="4"
           md="4">
      <b-list-group v-if="book">
        <b-list-group-item v-for="element, index in book.pages"
                           :key="element.id"
                           :to="{ name: 'books.read', params: { slug: slug, page: element.id }}"
        >
          {{ element.title }}
        </b-list-group-item>
      </b-list-group>
    </b-col>

    <b-col cols="12"
       sm="8"
       md="8">
      <transition v-if="book"
                  name="fade"
                  mode="out-in">
        <router-view :key="$route.fullPath"
                     :firstId="book.pages[0].id"/>
      </transition>
    </b-col>
  </b-row>
</template>

<script>
import gql from 'graphql-tag'

export default {
  data () {
    return {
      slug: this.$route.params['slug'],
      book: null
    }
  },

  apollo: {
    book: {
      query: gql`query Book($slug: String) {
        book(slug: $slug) {
          id
          pages {
            id
            title
          }
        }
      }
      `,
      variables() {
        return{
          slug: this.slug,
        }
      },
    },
  },
}
</script>
