<template>
  <div class="absolute">
    <header class="header shadow h-16">
      <template v-if="action === ''">
        <coleus-container class="flex flex-wrap justify-between">
          <ul class="hidden flex items-center justify-start lg:flex pr-2">
            <li class="header_nav_link ml-8">
              <nuxt-link class="block" :to="{ name: 'index' }" exact
                >شاعران</nuxt-link
              >
            </li>
            <li class="header_nav_link">
              <nuxt-link class="block" :to="{ name: 'books' }" exact
                >کتاب‌ها</nuxt-link
              >
            </li>
          </ul>
          <coleus-search class="hidden lg:flex" />
          <nuxt-link
            class="w-full lg:w-1/5 flex items-center justify-center lg:justify-end"
            :to="{ name: 'index' }"
          >
            <coleus-logo class="h-5" />
            <coleus-leaf class="h-6 w-6 lg:h-10 lg:w-10 mx-2" />
          </nuxt-link>
        </coleus-container>
      </template>
      <coleus-container v-else class="flex justify-between lg:hidden">
        <div class="flex items-end">
          <component
            :is="'coleus-' + action + '-icon'"
            class="block h-6 text-indigo-500 fill-current"
          />
          <span
            class="block text-lg font-medium uppercase text-gray-900 pl-4 h-6"
            >{{ action }}</span
          >
        </div>
      </coleus-container>
    </header>
    <div
      class="lg:hidden mt-16 w-screen absolute bg-white top-0 right-0 left-0 bottom-0 h-screen overflow-y-hidden mb-12 z-20"
      :class="[searchOpen ? 'block' : 'hidden']"
    >
      <coleus-search @result-clicked="closeSearch(0)" />
    </div>
    <nav class="header_mobile_nav block lg:hidden">
      <div class="flex justify-between">
        <button
          class="flex flex-col items-center justify-between md:justify-center w-full p-2 md:p-4 hover:no-underline text-center focus:outline-none"
          @click.prevent="
            $root.$emit('toggle-contents')
            closeSearch()
          "
          :disabled="$route.name !== 'username-book-parent-page'"
          :class="[
            $route.name !== 'username-book-parent-page'
              ? 'text-gray-400'
              : 'text-gray-900'
          ]"
        >
          <coleus-bars-icon class="w-4" />
          <span class="block text-xs md:text-base font-medium">فهرست</span>
        </button>
        <button
          class="flex flex-col items-center justify-between md:justify-center w-full p-2 md:p-4 text-gray-900 hover:no-underline hover:text-indigo-500 text-center focus:outline-none"
          @click.prevent="toggleSearch()"
          :class="[searchOpen === true ? 'text-indigo-500' : 'text-gray-900']"
        >
          <coleus-search-icon class="w-4" />
          <span class="block text-xs md:text-base font-medium">جستجو</span>
        </button>
        <nuxt-link
          class="flex flex-col items-center justify-between md:justify-center w-full p-2 md:p-4 hover:no-underline text-center focus:outline-none"
          :to="{ name: 'books' }"
          @click.native="closeSearch()"
          :class="[
            $route.name === 'books' && searchOpen === false
              ? 'text-indigo-500'
              : 'text-gray-900'
          ]"
        >
          <coleus-book-icon class="w-4" />
          <span class="block text-xs md:text-base font-medium">کتاب‌ها</span>
        </nuxt-link>
        <nuxt-link
          class="flex flex-col items-center justify-between md:justify-center w-full p-2 md:p-4 text-gray-900 hover:no-underline text-center focus:outline-none"
          :to="{ name: 'index' }"
          @click.native="closeSearch()"
          :class="[
            $route.name === 'index' && searchOpen === false
              ? 'text-indigo-500'
              : 'text-gray-900'
          ]"
        >
          <coleus-users-icon class="w-4" />
          <span class="block text-xs md:text-base font-medium">شاعران</span>
        </nuxt-link>
      </div>
    </nav>
    <div
      class="header_mobile_aside block lg:hidden"
      :class="{ 'header_mobile_aside--open': sublinks.length }"
    >
      <coleus-container>
        <transition-group
          v-for="(group, index) in sublinks"
          :key="index"
          tag="div"
          name="list"
          class="header_mobile_aside_group"
        >
          <h3 :key="`title-${index}`" class="uppercase text-gray-500 pb-2">
            {{ group.title }}
          </h3>
          <ul :key="`list-${index}`" class="pb-6">
            <li v-for="l in group.links" :key="l.to" class="py-2">
              <nuxt-link
                class="block text-gray-700 hover:text-indigo-500"
                :class="{ 'text-indigo-500': path === locale + l.to }"
                :to="locale + l.to"
                exact
                >{{ l.name }}</nuxt-link
              >
            </li>
          </ul>
        </transition-group>
      </coleus-container>
    </div>
  </div>
</template>

<script>
import coleusLogo from '@/components/svg/Coleus'
import coleusLeaf from '@/components/svg/Leaf'
import coleusGlobe from '@/components/svg/Globe'
import coleusBookIcon from '@/components/svg/Book'
import coleusUsersIcon from '@/components/svg/Users'
import coleusSearchIcon from '@/components/svg/Search'
import coleusBarsIcon from '@/components/svg/Bars'
import coleusSearch from '@/components/partials/Search'
import coleusArrowLeft from '@/components/svg/ArrowLeft'

export default {
  components: {
    coleusUsersIcon,
    coleusBookIcon,
    coleusLogo,
    coleusLeaf,
    coleusSearchIcon,
    coleusSearch,
    coleusArrowLeft,
    coleusGlobe,
    coleusBarsIcon
  },
  model: {
    prop: 'action',
    event: 'change'
  },
  props: {
    action: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      searchOpen: false,
      currentPos: 0,
      links: [
        {
          icon: 'books',
          text: 'کتاب‌ها'
        },
        {
          icon: 'users',
          text: 'شاعران'
        }
      ]
    }
  },
  computed: {
    path() {
      return this.$route.path.slice(-1) === '/'
        ? this.$route.path.slice(0, -1)
        : this.$route.path
    },
    locale() {
      return '/' + this.action
    },
    sublinks() {
      return []
      // return this.$store.state.menu[this.action] || []
    }
  },
  methods: {
    nav(section) {
      this.currentSection = this.currentSection === section ? '' : section
      this.mobileNav = !this.mobileNav
    },
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
        console.log(this.currentPos)
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

<style>
.header {
  @apply fixed bg-white top-0 left-0 right-0 z-30;
}
.header_mobile_nav {
  @apply fixed bg-white border-t border-gray-300 left-0 bottom-0 right-0 z-30;
}
.header_mobile_aside {
  @apply fixed left-0 bg-gray-100 pt-6 z-20 w-full overflow-y-auto;
  top: 72px;
  bottom: 60px;
  transform: translateX(-100%);
}
.header_mobile_aside--open {
  transform: translateX(0px);
  & .header_mobile_aside_group {
    transform: translateX(0px);
  }
}
.list-enter-active,
.list-leave-active {
  transition: all 1s;
}
.list-enter,
.list-leave-to {
  opacity: 0;
  transform: translateY(30px);
}
</style>
