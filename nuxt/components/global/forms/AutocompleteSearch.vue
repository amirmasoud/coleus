<template>
  <div class="relative">
    <div class="pointer-events-none absolute pin-y pin-r pr-3 flex items-center">
      <svg v-if="loading" class="fill-current pointer-events-none text-grey-dark w-4 h-4" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" stroke="#acacac"><g fill="none" fill-rule="evenodd"><g transform="translate(1 1)" stroke-width="2"><circle stroke-opacity=".5" cx="18" cy="18" r="18"/><path d="M36 18c0-9.94-8.06-18-18-18">
        <animateTransform
          attributeName="transform"
          type="rotate"
          from="0 18 18"
          to="360 18 18"
          dur="1s"
          repeatCount="indefinite"/></path></g></g>
      </svg>
      <svg v-else class="fill-current pointer-events-none text-grey-dark w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/></svg>
    </div>
    <input
      class="h-8 transition outline-none border border-transparent rounded focus:bg-white focus:border-grey-light placeholder-grey-darkest bg-grey-lighter py-2 pr-4 pr-10 block w-full appearance-none leading-normal"
      type="text"
      placeholder="جستجو"
      @focus="focus"
      @blur="unfocus"
      @input="update"
      v-model="query">
    <span
      v-if="search && (search.paragraphs || search.books || search.users)"
      class="search-result w-full bg-white rounded border border-grey-light border p-4 absolute pin-l block my-2 z-50 overflow-y-scroll"
      role="listbox"
      style="top: 100%; right: auto; max-height: 93vh;"
      v-show="focused || list"
      v-on-clickaway="away"
    >
      <template v-if="search.users">
        <div class="suggestion-header leading-normal border-b border-b-1 border-grey mb-1">
          <span class="font-normal">شاعران</span>
        </div>
        <NuxtLink v-for="user in search.users" :key="user.id" @click.native="navigate" :to="{ name: 'user-username', params: { username: user.username }}" class="suggestion-link no-underline text-black">
          <div class="suggestion-item leading-normal flex content-end pb-2">
            <div class="suggestion-category font-light w-1/3 text-left border-l border-grey px-3 py-1">{{ user.name }}<br><span class="px-2"></span>
              <template v-if="get(user, 'highlight[0].username[0]')"><span v-html="get(user, 'highlight[0].username[0]')" /></template>
              <template v-else><small class="font-light">{{ user.username }}</small></template>@<!-- An @ sign is living here -->
            </div>
            <div class="suggestion-content w-2/3 transition px-3 py-1">
              <p>
                <template v-if="get(user, 'highlight[0].name[0]')"><span v-html="get(user, 'highlight[0].name[0]')" /></template>
                <template v-else>{{ user.name }}</template>
              </p>
              <small class="font-light">
                <template v-if="get(user, 'highlight[0].bio[0]')"><span v-html="get(user, 'highlight[0].bio[0]')" /></template>
                <template v-else>{{ truncate(user.bio) }}</template>
              </small>
            </div>
          </div>
        </NuxtLink>
      </template>

      <template v-if="search.books">
        <div class="suggestion-header leading-normal border-b border-b-1 border-grey mb-1">
          <span class="font-normal">کتاب‌ها</span>
        </div>
        <NuxtLink v-for="book in search.books" :key="book.id" @click.native="navigate" :to="{ name: 'book-slug-page-id', params: { slug: book.slug, id: book.start }}" class="suggestion-link no-underline text-black">
          <div class="suggestion-item leading-normal flex content-end pb-2">
            <div class="suggestion-category font-light w-1/3 text-left border-l border-grey px-3 py-1">{{ book.collaborators[0].name }}</div>
            <div class="suggestion-content w-2/3 transition px-3 py-1">
              <p>
                <template v-if="book.highlight[0].title && book.highlight[0].title[0]"><span v-html="book.highlight[0].title[0]" /></template>
                <template v-else>{{ book.title }}</template>
              </p>
              <small class="font-light">
                <template v-if="book.highlight[0].description && book.highlight[0].description[0]"><span v-html="book.highlight[0].description[0]" /></template>
                <template v-else>{{ book.description }}</template>
              </small>
            </div>
          </div>
        </NuxtLink>
      </template>

      <template v-if="search.paragraphs">
        <div class="suggestion-header leading-normal border-b border-b-1 border-grey mb-1">
          <span class="font-normal">متون</span>
        </div>
        <NuxtLink v-for="paragraph in search.paragraphs" :key="paragraph.id" @click.native="navigate" :to="{ name: 'book-slug-page-id', params: { slug: paragraph.book[0].slug, id: paragraph.page[0].id }}" class="suggestion-link no-underline text-black">
          <div class="suggestion-item leading-normal flex content-end pb-2">
            <div class="suggestion-category font-light w-1/3 text-left border-l border-grey px-3 py-1">{{ paragraph.collaborators[0].name }} &raquo; {{ paragraph.book[0].title }}</div>
            <div class="suggestion-content w-2/3 transition px-3 py-1">
              <p>{{ paragraph.page[0].title }}</p>
              <small class="font-light">
                <template v-if="paragraph.highlight[0].content && paragraph.highlight[0].content[0]"><span v-html="paragraph.highlight[0].content[0]" /></template>
                <template v-else>{{ paragraph.content }}</template>
              </small>
            </div>
          </div>
        </NuxtLink>
      </template>
    </span>
  </div>
</template>

<script>
import _ from 'lodash'
import { directive as onClickaway } from 'vue-clickaway'

export default {
  name: 'AutocompleteSearch',

  directives: {
    onClickaway: onClickaway
  },

  data: () => ({
    query: '',
    focused: false,
    loading: false,
    search: null,
    list: true
  }),

  methods: {
    focus() {
      this.focused = true
    },

    unfocus() {
      this.focused = false
    },

    away() {
      if (this.focused) {
        this.list = true
      } else {
        this.list = false
      }
    },

    navigate() {
      this.list = false
    },

    update: _.debounce(async function(e) {
      if (this.query === '') {
        this.search = null
        return
      }

      this.loading = true
      await this.$apollo
        .query({
          query: require('~/graphql/autocomplete.gql'),
          variables: { query: this.query }
        })
        .then(({ data }) => {
          this.search = data.search
          this.loading = false
        })
    }, 300),

    get(obj, key) {
      return _(obj).get(key)
    },

    truncate(str) {
      return _.truncate(str, {
        length: 100,
        separator: /,? +/
      })
    }
  }
}
</script>

<style>
.suggestion-link:hover .suggestion-content {
  background-color: #dfe4ea;
}
.search-result::-webkit-scrollbar {
  width: 0.3rem;
}
.search-result::-webkit-scrollbar-thumb {
  background-color: #a2a2a2;
}
</style>
