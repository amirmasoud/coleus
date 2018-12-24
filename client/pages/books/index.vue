<template>
  <b-row v-if="book">
    <b-col cols="12"
           sm="12"
           md="4" class="sidebar-wrapper d-md-block"
           :class="{ 'd-block d-sm-block': menu, 'd-none d-sm-none': ! menu }">
      <no-ssr>
      <div class="sidebar-nav" :style="'max-width: ' + width" v-if="rendered">
        <div class="float-left d-block d-sm-block d-md-none" style="width: calc(100% - 46px);"><b-form-input v-model="title" type="search" class="mb-3" :placeholder="$t('search_title')"></b-form-input></div>
        <div class="d-none d-sm-none d-md-block"><b-form-input v-model="title" type="search" class="mb-3" :placeholder="$t('search_title')"></b-form-input></div>
        <span class="d-inline d-sm-inline d-md-none" @click="toggleMenu()"><b-button style="margin: 5px 0px 19px 0px;" variant="link"><fa icon="times-circle" fixed-width /></b-button></span>
        <div class="book-contents" :style="'height: ' + height">
          <b-list-group>
            <DynamicScroller
              class="scroller"
              :items="bookContents(book.pages)"
              :min-item-height="48"
              page-mode
              :prerender="100"
            >
              <template slot-scope="{ item, index, active }">
                <DynamicScrollerItem
                  :item="item"
                  :active="active"
                  :size-dependencies="[ item.title ]"
                  :data-index="index"
                >
                  <b-list-group-item v-if="item.is_header" class="text-left">
                    <strong>{{ item.title }}</strong>
                  </b-list-group-item>
                  <b-list-group-item v-else
                    :to="{ name: 'books.read', params: { slug: slug, page: item.id }}"
                    @click="toggleMenu()">
                    {{ item.title }}
                  </b-list-group-item>
                </DynamicScrollerItem>
              </template>
            </DynamicScroller>
          </b-list-group>
        </div>
      </div>
      <div v-else class="my-4 text-center"><img :src="'/svg-loaders/oval.svg'" /></div>
      </no-ssr>
    </b-col>

    <b-col cols="12"
           sm="12"
           md="8">
      <div class="reader-container d-md-block" :class="{ 'd-none d-sm-none': menu, 'd-block d-sm-block': ! menu }">
        <b-card class="mb-2 reading-help">
          <b-button size="sm" variant="link" @click="changeFontSize('up')"><fa icon="font" fixed-width /><fa icon="sort-up" fixed-width /></b-button>
          <b-button size="sm" variant="link" @click="changeFontSize('down')"><small><fa icon="font" fixed-width /></small><fa icon="sort-down" fixed-width /></b-button>
          <no-ssr><b-button class="d-inline d-sm-inline d-md-none" size="sm" variant="link" @click="toggleMenu()"><fa icon="bars" fixed-width /> {{ $t('contents') }}</b-button></no-ssr>
        </b-card>
          <div :style="'font-size: ' + fontSize">
            <nuxt-child />
          </div>
      </div>
    </b-col>

  </b-row>
  <div v-else class="my-4 text-center"><img :src="'/svg-loaders/oval.svg'" /></div>
</template>

<script>
import Vue from 'vue'
import gql from 'graphql-tag'
import { DynamicScroller, DynamicScrollerItem } from 'vue-virtual-scroller'

export default {
  components: { DynamicScroller, DynamicScrollerItem },

  asyncData ({ params }) {
    return {
      slug: params.slug,
      book: {}
    }
  },

  created () {
    if (process.browser) {
      window.addEventListener('scroll', this.handleScroll)
    }
  },

  mounted: function () {
    if (process.browser) {
      window.addEventListener('resize', this.handleResize)
    }
  },

  beforeDestroy: function () {
    if (process.browser) {
      window.removeEventListener('resize', this.handleResize)
    }
  },

  destroyed () {
    if (process.browser) {
      window.removeEventListener('scroll', this.handleScroll)
    }
  },

  updated: function () {
    this.$nextTick(function () {
      if (process.browser) {
        // this.width = document.querySelector('.sidebar-wrapper').clientWidth - 30 + 'px'
      }
    })
  },

  data () {
    return {
      book: null,
      height: null,
      width: null,
      title: '',
      top: 115,
      fontSize: 'inherit',
      menu: false,
      index: 0,
      path: this.$route,
      show: false,
      pageLoading: false,
      rendered: false
    }
  },

  apollo: {
    book: {
      query: require('~/graphql/book.gql'),
      prefetch: ({ params }) => {
        return {
          slug: params.slug
        }
      },
      variables () {
        return {
          slug: this.slug
        }
      },
      result (res) {
        if (process.browser) {
          if (document.querySelector('.sidebar-wrapper')) {
            this.width = document.querySelector('.sidebar-wrapper').clientWidth - 30 + 'px'
          }
          this.rendered = true
        }
      }
    },
  },

  methods: {
    bookContents (pages) {
      if (process.browser) {
        if (this.title) {
          let query = this.title
          return pages.filter(function (page) {
            return page.title.includes(query)
          })
        }

        return pages
      }
    },

    handleScroll (event) {
      if (process.browser) {
        if (window.scrollY > 115) {
          this.top = 15
        } else {
          for (var i = Math.min(this.top, window.scrollY); i <= Math.max(this.top, window.scrollY); i++) {
            this.top = Math.abs(115 - window.scrollY)
          }
        }
      }
    },

    changeFontSize (size) {
      if (process.browser) {
        let sizes = [
          'x-large',
          'larger',
          'large',
          'inherit',
          'smaller',
          'small',
          'x-small'
        ];
        let currentIndex = sizes.indexOf(this.fontSize)
        if (size == 'up') {
          if (currentIndex - 1 >= 0) {
            this.fontSize = sizes[currentIndex - 1]
          }
        } else { // down
          if (currentIndex + 1 < sizes.length) {
            this.fontSize = sizes[currentIndex + 1]
          }
        }
      }
    },

    handleResize () {
      if (process.browser) {
        let el = document.querySelector('.sidebar-wrapper')
        console.log(el)
        if (el) {
          this.width = el.clientWidth - 30 + 'px'
        }
      }
    },

    toggleMenu () {
      this.menu = ! this.menu
    }
  },
}
</script>

<style scoped>
.book-contents {
  overflow-y: scroll;
  height: calc(100vh - 144px)
}
.book-contents::-webkit-scrollbar {
  width: 0.3rem;
}
.book-contents::-webkit-scrollbar-thumb {
  background-color: #a2a2a2;
}
.sidebar-nav {
  position: fixed;
  width: 100%;
}
.reading-help .card-body {
  padding: 0.392rem 0.9375rem !important;
}
.sidebar-nav .form-control {
  background-color: #f8fafb;
}
</style>
