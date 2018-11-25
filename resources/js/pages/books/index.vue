<template>
  <b-row v-if="book">
    <b-col cols="12"
           sm="12"
           md="4" class="sidebar-wrapper d-md-block" :class="{ 'd-block d-sm-block': menu, 'd-none d-sm-none': ! menu }">
      <div class="sidebar-nav" :style="'max-width: ' + width">
        <div class="float-left d-block d-sm-block d-md-none" style="width: calc(100% - 46px);"><b-form-input v-model="title" type="search" class="mb-3" :placeholder="$t('search_title')"></b-form-input></div>
        <div class="d-none d-sm-none d-md-block"><b-form-input v-model="title" type="search" class="mb-3" :placeholder="$t('search_title')"></b-form-input></div>
        <span class="d-inline d-sm-inline d-md-none" @click="toggleMenu()"><b-button style="margin-bottom: 16px;" variant="link"><fa icon="times-circle" fixed-width /></b-button></span>
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
    </b-col>

    <b-col cols="12"
           sm="12"
           md="8">
      <div class="reader-container d-md-block" :class="{ 'd-none d-sm-none': menu, 'd-block d-sm-block': ! menu }">
        <b-card class="mb-2 reading-help">
          <b-button class="d-inline d-sm-inline d-md-none" size="sm" variant="link" @click="toggleMenu()"><fa icon="bars" fixed-width /> {{ $t('contents') }}</b-button>
          <b-button size="sm" variant="link" @click="changeFontSize('up')"><fa icon="font" fixed-width /><fa icon="sort-up" fixed-width /></b-button>
          <b-button size="sm" variant="link" @click="changeFontSize('down')"><small><fa icon="font" fixed-width /></small><fa icon="sort-down" fixed-width /></b-button>
        </b-card>
        <transition name="fade"
                    mode="out-in">
          <div :style="'font-size: ' + fontSize">
            <b-card class="p-2 reading-container">
              <router-view :key="$route.fullPath"
                           :firstId="getFirstId(book.pages)"/>
            </b-card>
          </div>
        </transition>
      </div>
    </b-col>
  </b-row>
  <div v-else class="my-4 text-center"><img :src="'/svg-loaders/oval.svg'" /></div>
</template>

<script>
import gql from 'graphql-tag'
import 'vue-virtual-scroller/dist/vue-virtual-scroller.css'
import { DynamicScroller, DynamicScrollerItem } from 'vue-virtual-scroller'
import { Slide } from 'vue-burger-menu'

export default {
  components: { DynamicScroller, DynamicScrollerItem, Slide },

  created () {
    // this.height = window.innerHeight - 200 + 'px'
    window.addEventListener('scroll', this.handleScroll);
  },

  destroyed () {
    window.removeEventListener('scroll', this.handleScroll);
  },

  mounted: function () {
    window.addEventListener('resize', this.handleResize)
  },

  updated: function () {
    this.$nextTick(function () {
      this.width = document.querySelector('.sidebar-wrapper').clientWidth - 30 + 'px'
    })
  },

  beforeDestroy: function () {
    window.removeEventListener('resize', this.handleResize)
  },

  data () {
    return {
      slug: this.$route.params['slug'],
      book: null,
      height: null,
      width: null,
      title: '',
      top: 115,
      fontSize: 'inherit',
      menu: false
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
    },

    changeFontSize (size) {
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
    },

    handleResize () {
      this.width = document.querySelector('.sidebar-wrapper').clientWidth - 30 + 'px'
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
  width: 100%;
}
.reading-help .card-body {
  padding: 0.219rem 0.9375rem !important;
}
</style>
