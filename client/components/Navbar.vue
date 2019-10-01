<template>
  <div class="flex bg-black fixed pin-t pin-x z-50 h-16 items-center">
    <div class="w-full max-w-3xl relative mx-auto">
      <div class="flex items-center">
        <div class="xl:w-1/8 lg:w-1/4">
          <div class="flex justify-start items-center">
            {{auth}}
            <NuxtLink :to="{ name: 'index' }" class="flex lg:mr-4">
              <img class="self-center" src="/images/favicon-32x32.png" alt="Logo">
            </NuxtLink>
          </div>
        </div>
        <div class="flex flex-grow items-center lg:w-5/8">
          <AutocompleteSearch />
          <span v-if="$route.name === 'book-slug-page-id'">
            <div
              v-show="!showMenu"
              id="sidebar-open"
              class="flex pr-4 pl-2 items-center lg:hidden"
              @click.prevent="openMenu"
            >
              <svg class="fill-current w-4 h-4 cursor-pointer text-grey" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" /></svg>
            </div>
            <div
              v-show="showMenu"
              id="sidebar-close"
              class="flex pr-4 pl-2 items-center lg:hidden"
              @click.prevent="closeMenu"
            >
              <svg class="fill-current w-4 h-4 cursor-pointer text-grey" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z" /></svg>
            </div>
          </span>
        </div>
        <div class="w-1/4 lg:ml-4 flex justify-end" style="margin-right: -4px;">
          <NuxtLink :to="{ name: 'login' }" class="no-underline">
            <button class="text-white text-sm py-2 px-2 mr-3">ورود</button>
          </NuxtLink>
          <NuxtLink :to="{ name: 'register' }" class="no-underline">
            <button class="mr-3 active:bg-prune active:shadow-btn-active active:border-caput-mortuum bg-sweet-brown border border-burnt-umber py-2 px-2 text-white font-normal text-sm rounded shadow-btn hover:bg-vivid-auburn hover:shadow-btn-hover focus:outline-none focus:shadow-outline focus:shadow-btn-focus no-underline">ثبت‌نام</button>
          </NuxtLink>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data: () => ({
    showMenu: false,

    auth: null,
    protected: false,
    fresh: true,
    loading: true
  }),

  created() {
    this.$root.$on('close-menu-after-click', this.closeMenuAfterClick)
    this.attempLogin()
  },

  methods: {
    openMenu() {
      this.showMenu = true
      this.$root.$emit('open-menu')
    },

    closeMenu() {
      this.showMenu = false
      this.$root.$emit('close-menu')
    },

    closeMenuAfterClick() {
      this.showMenu = false
    },

    async attempLogin() {
      this.$apollo.skipAllQueries = true

      await this.$apollo
        .query({
          query: require('~/graphql/client/query/user'),
          prefetch: false
        })
        .then(({ data }) => {
          this.auth = data.user
          this.$root.$emit('auth-ready')
          this.$apollo.skipAllQueries = false
        })
        .catch(error => {
          console.log(error)
          this.auth = null

          this.$apollo.skipAllQueries = false
        })
    }
  }
}
</script>
