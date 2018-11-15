<template>
  <b-row v-if="book">
    <b-col cols="12"
           sm="4"
           md="4">
      <b-form-input v-model="title" type="search"
                    :placeholder="$t('search_title')"></b-form-input>
      <hr />
      <div class="book-contents" :style="'height: ' + height">
        <b-list-group>
          <DynamicScroller
            class="scroller"
            :items="bookContents(book.pages)"
            :min-item-height="48"
            page-mode
          >
            <template slot-scope="{ item, index, active }">
              <DynamicScrollerItem
                :item="item"
                :active="active"
                :size-dependencies="[
                  item.title,
                ]"
                :data-index="index"
              >
                <b-list-group-item class="text-left"
                  v-if="item.is_header"
                  style="background-color: transparent; border: none;">
                  {{ item.title }}
                </b-list-group-item>
                <b-list-group-item
                  v-else
                  :to="{ name: 'books.read', params: { slug: slug, page: item.id }}">
                  {{ item.title }}
                </b-list-group-item>
              </DynamicScrollerItem>
            </template>
          </DynamicScroller>
        </b-list-group>
      </div>
    </b-col>

    <b-col cols="12"
       sm="8"
       md="8">
      <transition name="fade"
                  mode="out-in">
        <router-view :key="$route.fullPath"
                     :firstId="getFirstId(book.pages)"/>
      </transition>
    </b-col>
  </b-row>
  <div v-else class="my-4 text-center"><img :src="'/svg-loaders/oval.svg'" /></div>
</template>

<script>
import gql from 'graphql-tag'
import { DynamicScroller, DynamicScrollerItem } from 'vue-virtual-scroller'
import 'vue-virtual-scroller/dist/vue-virtual-scroller.css'

export default {
  components: { DynamicScroller, DynamicScrollerItem },

  created () {
    this.height = window.innerHeight - 200 + 'px'
  },

  data () {
    return {
      slug: this.$route.params['slug'],
      book: null,
      height: null,
      title: '',
    }
  },

  apollo: {
    book: Object.freeze({
      query: gql`query Book($slug: String) {
        book(slug: $slug) {
          id
          pages {
            id
            title
            is_header
          }
        }
      }
      `,
      variables () {
        return{
          slug: this.slug,
        }
      },
    }),
  },

  methods: {
    getFirstId (pages) {
      for (var i = pages.length - 1; i >= 0; i--) {
        if (! pages[i].is_header) {
          return pages[i].id
        }
      }
    },

    bookContents (pages) {
      if (this.title) {
        let query = this.title
        return pages.filter(function (page) {
          return page.title.includes(query)
        })
      }
      return pages
    }
  },
}
</script>

<style scoped>
.book-contents {
  overflow-y: scroll;
}
.book-contents::-webkit-scrollbar {
  width: 0.3rem;
}

.book-contents::-webkit-scrollbar-thumb {
  background-color: #a2a2a2;
}
</style>
