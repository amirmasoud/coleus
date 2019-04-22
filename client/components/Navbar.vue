<template>
  <div class="flex bg-black fixed pin-t pin-x z-50 h-16 items-center">
    <div class="w-full max-w-3xl relative mx-auto">
      <div class="flex items-center">
        <div class="lg:w-1/4 xl:w-1/5 mr-2 xl:mr-3">
          <div class="flex justify-start items-center">
            <nuxt-link :to="{ name: 'index' }" class="flex lg:ml-4">
              <img class="self-center" src="/images/favicon-32x32.png" alt="Logo">
            </nuxt-link>
          </div>
        </div>
        <div class="flex flex-grow items-center mx-2 lg:w-full">
          <AutocompleteSearch />
          <span v-if="$route.name === 'book-slug-page-id'">
            <div v-show="!showMenu" id="sidebar-open" class="flex pr-4 pl-2 items-center lg:hidden" @click.prevent="openMenu">
              <svg class="fill-current w-4 h-4 cursor-pointer text-grey" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" /></svg>
            </div>
            <div v-show="showMenu" id="sidebar-close" class="flex pr-4 pl-2 items-center lg:hidden" @click.prevent="closeMenu">
              <svg class="fill-current w-4 h-4 cursor-pointer text-grey" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z" /></svg>
            </div>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data: () => ({
    showMenu: false
  }),

  created() {
    this.$root.$on('close-menu-after-click', this.closeMenuAfterClick)
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
    }
  }
}
</script>
