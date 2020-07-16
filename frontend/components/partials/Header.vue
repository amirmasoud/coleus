<template>
  <div class="absolute">
    <header class="fixed bg-white top-0 left-0 right-0 z-30 shadow h-16">
      <coleus-container class="flex flex-wrap h-16 justify-between">
        <ul class="hidden flex items-center justify-start lg:flex pr-2">
          <coleus-nav-list-link :to="{ name: 'index' }" class="ml-8"
            >شاعران</coleus-nav-list-link
          >
          <coleus-nav-list-link :to="{ name: 'books' }" class="ml-8"
            >کتاب‌ها</coleus-nav-list-link
          >
        </ul>
        <coleus-search class="hidden lg:flex" />
        <coleus-logo-link
          class="flex items-center w-full lg:w-1/5 justify-center lg:justify-end"
        />
      </coleus-container>
    </header>
    <div
      class="lg:hidden w-screen absolute bg-white top-0 right-0 left-0 bottom-0 h-screen overflow-y-hidden mb-12 z-30"
      :class="[searchOpen ? 'block' : 'hidden']"
    >
      <coleus-search @close="closeSearch(0)" />
    </div>
    <nav
      class="fixed bg-white border-t border-gray-300 left-0 bottom-0 right-0 z-30 lg:hidden"
    >
      <div class="flex justify-between">
        <coleus-nav-mobile-menu-link @click.prevent="closeSearch()"
          >فهرست</coleus-nav-mobile-menu-link
        >
        <coleus-nav-mobile-search-link
          :search-open="searchOpen"
          @click.native="toggleSearch()"
          >جستجو</coleus-nav-mobile-search-link
        >
        <coleus-nav-mobile-link
          :to="{ name: 'books' }"
          route-name="books"
          :search-open="searchOpen"
          svg="coleus-svg-book"
          @click.native="closeSearch()"
          >کتاب‌ها</coleus-nav-mobile-link
        >
        <coleus-nav-mobile-link
          :to="{ name: 'index' }"
          route-name="index"
          :search-open="searchOpen"
          svg="coleus-svg-users"
          @click.native="closeSearch()"
          >شاعران</coleus-nav-mobile-link
        >
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchOpen: false,
      currentPos: 0
    }
  },
  methods: {
    toggleSearch() {
      this.searchOpen = !this.searchOpen

      if (process.client && this.searchOpen === true) {
        this.currentPos =
          document.documentElement.scrollTop || document.body.scrollTop
        window.pageXOffset = 0
        document.documentElement.scrollTop = 0
        document.body.scrollTop = 0
        document.body.style.overflowY = 'hidden'
      }

      if (process.client && this.searchOpen === false) {
        document.body.style.removeProperty('overflow-y')
        window.pageXOffset = this.currentPos
        document.documentElement.scrollTop = this.currentPos
        document.body.scrollTop = this.currentPos
      }
    },
    closeSearch(pos = -1) {
      this.searchOpen = false
      if (process.client && pos === -1) {
        document.body.style.removeProperty('overflow-y')
        window.pageXOffset = this.currentPos
        document.documentElement.scrollTop = this.currentPos
        document.body.scrollTop = this.currentPos
      }

      if (process.client && pos !== -1) {
        document.body.style.removeProperty('overflow-y')
        window.pageXOffset = 0
        document.documentElement.scrollTop = 0
        document.body.scrollTop = 0
      }
    }
  }
}
</script>
