<template>
  <b-row v-if="book">
    <b-col cols="12"
           sm="4"
           md="4">
      <div class="sidebar-nav d-none d-sm-block">
          <b-form-input v-model="title" type="search" class="mb-3"
                        :placeholder="$t('search_title')"></b-form-input>
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
                      <strong>{{ item.title }}</strong>
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
      </div>
    </b-col>

    <b-col cols="12"
           sm="8"
           md="8">
      <transition name="fade"
                  mode="out-in">
        <b-card class="p-2">
          <router-view :key="$route.fullPath"
                       :firstId="getFirstId(book.pages)"/>
        </b-card>
      </transition>
    </b-col>
  </b-row>
  <div v-else class="my-4 text-center"><img :src="'/svg-loaders/oval.svg'" /></div>
</template>

<script>
import gql from 'graphql-tag'
import 'vue-virtual-scroller/dist/vue-virtual-scroller.css'
import { DynamicScroller, DynamicScrollerItem } from 'vue-virtual-scroller'

export default {
  components: { DynamicScroller, DynamicScrollerItem },

  created () {
    // this.height = window.innerHeight - 200 + 'px'
    window.addEventListener('scroll', this.handleScroll);
  },

  destroyed () {
    window.removeEventListener('scroll', this.handleScroll);
  },

  data () {
    return {
      slug: this.$route.params['slug'],
      book: null,
      height: null,
      title: '',
      top: 115
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
      for (let i = pages.length - 1; i >= 0; i--) {
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
    },

    handleScroll (event) {
      if (window.scrollY > 115) {
        this.top = 15
        // this.height = window.innerHeight - 80 + 'px'
      } else {
        for (var i = Math.min(this.top, window.scrollY); i <= Math.max(this.top, window.scrollY); i++) {
          this.top = Math.abs(115 - window.scrollY)
          // this.height = window.innerHeight - 80 - (115 - window.scrollY) + 'px'
        }
      }
    }
  },
}
</script>

<style scoped>
.book-contents {
  overflow-y: scroll;
  height: calc(100vh - 140px)
}
.book-contents::-webkit-scrollbar {
  width: 0.3rem;
}
.book-contents::-webkit-scrollbar-thumb {
  background-color: #a2a2a2;
}
.sidebar-nav {
  position: fixed;
  max-width: 350px;
  width: 100%;
}
</style>
