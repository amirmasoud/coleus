<template>
  <div class="relative">
    <div class="pointer-events-none absolute pin-y pin-r pr-3 flex items-center">
      <svg v-if="searching" class="fill-current pointer-events-none text-grey-dark w-4 h-4" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" stroke="#acacac"><g fill="none" fill-rule="evenodd"><g transform="translate(1 1)" stroke-width="2"><circle stroke-opacity=".5" cx="18" cy="18" r="18"/><path d="M36 18c0-9.94-8.06-18-18-18">
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
      @focus="search"
      @blur="loseFocus"
      v-model="query">
    <span
      class="w-full bg-white rounded border border-grey-light border p-4 absolute pin-l block mt-2 z-50"
      role="listbox"
      style="top: 100%; right: auto;"
      v-show="focused"
    >
      <div class="suggestion-header leading-normal border-b border-b-1 border-grey mb-1">
        <span class="font-normal">شاعران</span>
      </div>
      <a href="#" class="suggestion-link no-underline text-black">
        <div class="suggestion-item leading-normal flex content-end pb-2">
          <div class="suggestion-category font-light w-1/3 text-left border-l border-grey px-3 py-1">حافظ<br><span class="px-2"></span><small class="border-b border-b-1 border-dashed border-teal pb-1 font-light">hafez@</small></div>
          <div class="suggestion-content w-2/3 transition px-3 py-1">
            <p><span class="bg-teal-lightest text-teal-dark">خواجه حافظ شیرازی</span></p>
            <small class="font-light">...وی در قرن چندم هجری به دنیا <span class="border-b border-b-1 border-dashed border-teal pb-1">نیامد</span></small>
          </div>
        </div>
      </a>

      <div class="suggestion-header leading-normal border-b border-b-1 border-grey mb-1">
        <span class="font-normal">کتاب‌ها</span>
      </div>
      <a href="#" class="suggestion-link no-underline text-black">
        <div class="suggestion-item leading-normal flex content-end pb-2">
          <div class="suggestion-category font-light w-1/3 text-left border-l border-grey px-3 py-1">حافظ</div>
          <div class="suggestion-content w-2/3 transition px-3 py-1">
            <p>دیوان <span class="bg-teal-lightest text-teal-dark">حافظ</span></p>
            <small class="font-light">سراندازان همی‌آیی <span class="border-b border-b-1 border-dashed border-teal pb-1">نگارین</span> جگرخواره</small>
          </div>
        </div>
      </a>
      <a href="#" class="suggestion-link no-underline text-black">
        <div class="suggestion-item leading-normal flex content-end pb-2">
          <div class="suggestion-category font-light w-1/3 text-left border-l border-grey px-3 py-1"><span class="bg-teal-lightest text-teal-dark">مولانا</span></div>
          <div class="suggestion-content w-2/3 transition px-3 py-1">شمس تبریزی</div>
        </div>
      </a>
      <a href="#" class="suggestion-link no-underline text-black">
        <div class="suggestion-item leading-normal flex content-end pb-2">
          <div class="suggestion-category font-light w-1/3 text-left border-l border-grey px-3 py-1">مولانا</div>
          <div class="suggestion-content w-2/3 transition px-3 py-1"><span class="bg-teal-lightest text-teal-dark">مثنوی</span> معنوی</div>
        </div>
      </a>

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
    query: '',
    focused: false,
    searching: false
  }),

  methods: {
    search() {
      this.focused = true
      this.searching = true
    },

    loseFocus() {
      this.focused = false
      this.searching = false
    }
  }
}
</script>

<style>
.suggestion-link:hover .suggestion-content {
  background-color: #dfe4ea;
}
</style>
