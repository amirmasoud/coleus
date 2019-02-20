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
      v-model="query">
    <span
      v-if="search"
      class="search-result w-full bg-white rounded border border-grey-light border p-4 absolute pin-l block mt-2 z-50 max-h-screen overflow-y-scroll"
      role="listbox"
      style="top: 100%; right: auto;"
      v-show="focused"
    >
      <template v-if="search.users">
        <div class="suggestion-header leading-normal border-b border-b-1 border-grey mb-1">
          <span class="font-normal">شاعران</span>
        </div>
        <a v-for="user in search.users" :key="user.id" href="#" class="suggestion-link no-underline text-black">
          <div class="suggestion-item leading-normal flex content-end pb-2">
            <div class="suggestion-category font-light w-1/3 text-left border-l border-grey px-3 py-1">{{ user.name }}<br><span class="px-2"></span>
              <template v-if="user.highlight[0].username && user.highlight[0].username[0]"><span v-html="user.highlight[0].username[0]" /></template>
              <template v-else><small class="font-light">{{ user.highlight[0].username[0] }}</small></template>@ <!-- An @ sign is living here -->
            </div>
            <div class="suggestion-content w-2/3 transition px-3 py-1">
              <p>
                <template v-if="user.highlight[0].name && user.highlight[0].name[0]"><span v-html="user.highlight[0].name[0]" /></template>
                <template v-else>{{ user.name }}</template>
              </p>
              <small class="font-light">{{ user.bio }}</small>
            </div>
          </div>
        </a>
      </template>

      <template v-if="search.books">
        <div class="suggestion-header leading-normal border-b border-b-1 border-grey mb-1">
          <span class="font-normal">کتاب‌ها</span>
        </div>
        <a v-for="book in search.books" :key="book.id" href="#" class="suggestion-link no-underline text-black">
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
        </a>
      </template>

      <div class="suggestion-header leading-normal border-b border-b-1 border-grey mb-1">
        <span class="font-normal">اشعار</span>
      </div>
      <a href="#" class="suggestion-link no-underline text-black">
        <div class="suggestion-item leading-normal flex content-end pb-2">
          <div class="suggestion-category font-light w-1/3 text-left border-l border-grey px-3 py-1"><span class="bg-teal-lightest text-teal-dark">مولانا</span> &raquo; شمس تبریزی</div>
          <div class="suggestion-content w-2/3 transition px-3 py-1">
            <p>حکایت شماره ۵</p>
            <small class="font-light">سراندازان همی‌آیی <span class="border-b border-b-1 border-dashed border-teal pb-1">نگارین</span> جگرخواره</small>
          </div>
        </div>
      </a>
    </span>
  </div>
</template>

<script>
export default {
  name: 'AutocompleteSearch',

  data: () => ({
    query: 'حافظ',
    focused: true,
    loading: false
  }),

  apollo: {
    search: {
      query: require('~/graphql/autocomplete.gql'),
      variables: {
        query: 'حافظ'
      }
    }
  },

  methods: {
    focus() {
      this.focused = true
      this.loading = true
    },

    unfocus() {
      this.focused = false
      this.loading = false
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
