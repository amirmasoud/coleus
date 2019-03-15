<template>
  <div :class="[focused ? 'lg:w-2/3' : 'lg:w-1/3']" class="w-full mr-auto relative transition ">
    <div class="pointer-events-none absolute pin-y pin-r pr-3 flex items-center">
      <img v-if="loading" class="w-4" src="/icons/loading.svg">
      <img v-else class="w-4" src="/icons/search.svg">
    </div>
    <input
      ref="search"
      v-model="query"
      v-shortkey.once="['/']"
      class="h-8 transition outline-none border border-transparent rounded focus:bg-white focus:border-blue-light placeholder-grey-darkest bg-grey-lighter py-2 pr-4 pr-10 block w-full appearance-none leading-normal"
      type="text"
      placeholder="جستجو"
      @shortkey="focusSearch()"
      @focus="focus"
      @blur="unfocus"
      @input="update"
    >
    <div class="absolute pin-y pin-l pl-3 flex items-center">
      <span class="bg-grey-light text-grey-darkest font-bold px-2 border-b border-grey-darkests rounded font-mono">/</span>
    </div>
    <span
      v-if="search && (search.paragraphs || search.books || search.users)"
      v-show="focused || list"
      v-on-clickaway="away"
      class="search-result xl:w-full lg:w-full w-full bg-white rounded border border-grey-light border p-4 absolute pin-l block my-2 z-50 overflow-y-scroll"
      role="listbox"
      style="top: 100%; right: auto; max-height: 93vh;"
    >
      <template v-if="search.users">
        <div class="suggestion-header leading-normal border-b border-b-1 border-grey mb-1">
          <span class="font-normal">شاعران</span>
        </div>
        <NuxtLink v-for="user in search.users" :key="user.id" class="suggestion-link no-underline text-black" :to="{ name: 'user-username', params: { username: user.username }}" @click.native="navigate">
          <div class="suggestion-item leading-normal flex content-end pb-2">
            <div class="suggestion-category font-light w-1/3 text-left border-l border-grey px-3 py-1">{{ user.name }}<br><span class="px-2" />
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
        <NuxtLink v-for="book in search.books" :key="book.id" class="suggestion-link no-underline text-black" :to="{ name: 'book-slug-page-id', params: { slug: book.slug, id: book.start }}" @click.native="navigate">
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
        <NuxtLink v-for="paragraph in search.paragraphs" :key="paragraph.id" class="suggestion-link no-underline text-black" :to="{ name: 'book-slug-page-id', params: { slug: paragraph.book[0].slug, id: paragraph.page[0].id }}" @click.native="navigate">
          <div class="suggestion-item leading-normal flex content-end pb-2">
            <div class="suggestion-category font-light w-1/3 text-left border-l border-grey px-3 py-1">{{ paragraph.collaborators[0].name }} &raquo; {{ paragraph.book[0].title }}</div>
            <div class="suggestion-content w-2/3 transition px-3 py-1">
              <p>{{ paragraph.page[0].title }}</p>
              <small class="font-light">
                <template v-if="paragraph.highlight[0].content && paragraph.highlight[0].content[0]">
                  <span v-html="paragraph.highlight[0].content[0]" />
                </template>
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
          query: require('~/graphql/search.gql'),
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
    },

    focusSearch(e) {
      this.$nextTick(() => this.$refs.search.focus())
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
