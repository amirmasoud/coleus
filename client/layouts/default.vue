<template>
  <div dir="rlt" style="direction: rtl;">
    <navbar />

    <div class="container mx-auto w-full h-full max-w-3xl mt-16">
      <div class="flex flex-wrap">
        <div class="w-full mb-6 border-b border-brown border-dashed cool-background">
          <nav role="navigation">
            <ol class="list-reset flex">
              <!-- <li v-if="$route.name === 'book-slug-page-id'" class="mb-4 pb-4 border-b border-gainsboro" v-shortkey="['esc']" @shortkey="closeMenu()">
                <span class="flex items-center px-2 py-2 mr text-smoky-black-dark hover:font-bold text-sm cursor-pointer" @click.prevent="openMenu" v-show="!showMenu">
                  <svg class="fill-current w-4 h-4 text-grey ml-2" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" /></svg>
                  باز کردن فهرست
                </span>
                <span class="flex items-center px-2 py-2 mr text-smoky-black-dark hover:font-bold text-sm cursor-pointer" @click.prevent="closeMenu" v-show="showMenu">
                  <svg class="fill-current w-4 h-4 text-grey ml-2" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z" /></svg>
                  بستن فهرست
                </span>
              </li> -->

              <li class="flex-1 text-center">
                <NuxtLink :to="{ name: 'index' }" :class="{'bg-smoky-black font-bold': $route.name === 'index'}" class="block px-2 py-2 text-smoky-black-dark text-sm no-underline">
                  خانه
                </NuxtLink>
              </li>
              <li class="flex-1 text-center">
                <NuxtLink :to="{ name: 'users' }" :class="{'bg-smoky-black font-bold': $route.name === 'users' || $route.name === 'profile' || ($route.name ? $route.name.startsWith('user-') : false)}" class="block px-2 py-2 text-smoky-black-dark hover:font-bold text-sm no-underline">
                  شاعران
                </NuxtLink>
              </li>
              <li class="flex-1 text-center">
                <NuxtLink :to="{ name: 'books' }" :class="{'bg-smoky-black font-bold': $route.name === 'books' || ($route.name ? $route.name.startsWith('book-') : false)}" class="block px-2 py-2 text-smoky-black-dark hover:font-bold text-sm no-underline">
                  کتاب‌ها
                </NuxtLink>
              </li>
            </ol>
          </nav>
        </div>
        <div class="md:w-5/8 border-l border-r border-gainsboro">
          <Nuxt />
        </div>
        <div class="md:w-1/4 p-4 min-h-screen">
          <div id="hot-network-questions">
              <h4 class="font-normal font-bold mt-2 mb-6">
                  <a href="#" class="no-underline text-charleston-green">
                      در حال نمایش‌ترین‌ها
                  </a>
              </h4>
              <ul class="list-reset">
                <li v-for="item in trending.data" :key="item.id" class="mt-5 flex">
                  <no-ssr>
                    <NuxtLink :to="{ name: 'book-slug-page-id', params: { slug: item.book.slug, id: item.id }}" class="no-underline">
                      <div class="h-8 w-8 min-h-full flex-no-grow ml-2">
                        <progressive-img
                          :src="item.book.collaborators[0].thumbnail || item.book.collaborators[0].photo_url"
                          :placeholder="item.book.collaborators[0].placeholder"
                          :aspect-ratio="1"
                          class="rounded"
                        />
                      </div>
                    </NuxtLink>
                  </no-ssr>
                  <span class="flex-grow">
                    <NuxtLink :to="{ name: 'book-slug-page-id', params: { slug: item.book.slug, id: item.id }}" class="text-smoky-black-dark hover:text-dark-liver text-sm no-underline">
                      {{ item.title }}
                    </NuxtLink>
                    <p class="text-xs text-grey-darker mt-1"><NuxtLink :to="{ name: 'profile', params: { username: item.book.collaborators[0].username }}" class="text-grey-darker hover:text-dark-liver no-underline">{{ item.book.collaborators[0].name }}</NuxtLink> <span class="text-black">></span> <NuxtLink :to="{ name: 'book-slug', params: { slug: item.book.slug } }" class="text-grey-darker hover:text-dark-liver no-underline">{{ item.book.title }}</NuxtLink></p>
                  </span>
                </li>
              </ul>
          </div>
        </div>
      </div>
    </div>

    <footer class="bg-champagne footer-footer border-t border-dashed shadow-inner border-brown">
      <p class="text-center pt-8 text-xs">
        <a class="mx-1 no-underline text-smoky-black-dark hover:text-black" href="#">فیسبوک</a>
        <a class="mx-1 no-underline text-smoky-black-dark hover:text-black" href="https://twitter.com/negarinapp">توییتر</a>
        <a class="mx-1 no-underline text-smoky-black-dark hover:text-black" href="https://t.me/negarin_telegram">تلگرام</a>
        <a class="mx-1 no-underline text-smoky-black-dark hover:text-black" href="#">اینستاگرام</a>
      </p>
      <p class="mt-24 text-xs text-center pb-6" style="color: rgba(12,13,14,0.5);">
        <span id="svnrev">rev&nbsp;2019.5.26.319</span>
      </p>
    </footer>
  </div>
</template>

<script>
import Navbar from '~/components/Navbar'

export default {
  components: { Navbar },

  mounted() {
    if (process.client && window) {
      window.history.scrollRestoration = 'auto'
    }
  },

  data: () => ({
    showMenu: false
  }),

  created() {
    this.$root.$on('close-menu-after-click', this.closeMenuAfterClick)
  },

  apollo: {
    trending: {
      query: require('~/graphql/trending.gql')
    }
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
