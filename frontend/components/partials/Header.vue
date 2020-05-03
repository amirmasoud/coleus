<template>
  <div class="absolute">
    <header class="header">
      <template v-if="action === ''">
        <coleus-container class="flex flex-wrap py-4">
          <ul class="hidden w-4/5 flex items-start justify-start lg:flex pr-2">
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
          <nuxt-link
            class="w-full lg:w-1/5 flex items-center justify-center lg:justify-end"
            :to="{ name: 'index' }"
          >
            <coleus-logo class="h-5 lg:pl-2" />
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
            class="block text-lg font-medium uppercase text-coleus-gray pl-4 h-6"
            >{{ action }}</span
          >
        </div>
      </coleus-container>
    </header>
    <nav class="header_mobile_nav block lg:hidden">
      <div class="flex justify-between">
        <nuxt-link
          class="block md:flex md:justify-center w-full p-2 md:p-4 text-coleus-gray hover:no-underline hover:text-indigo-500 text-center visited:text-coleus-gray"
          :to="{ name: 'books' }"
        >
          <span class="block text-xs md:text-base md:pl-3 font-medium text-gray"
            >کتاب‌ها</span
          >
        </nuxt-link>
        <nuxt-link
          class="block md:flex md:justify-center w-full p-2 md:p-4 text-coleus-gray hover:no-underline hover:text-indigo-500 text-center visited:text-coleus-gray"
          :to="{ name: 'index' }"
        >
          <span class="block text-xs md:text-base md:pl-3 font-medium text-gray"
            >شاعران</span
          >
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
import coleusGlobe from '@/components/svg/Globe'
// import coleusBooksIcon from '@/components/svg/Books'
// import coleusUsersIcon from '@/components/svg/Users'
import coleusSearchIcon from '@/components/svg/Search'
import coleusSearch from '@/components/partials/Search'
import coleusArrowLeft from '@/components/svg/ArrowLeft'

export default {
  components: {
    // coleusUsersIcon,
    // coleusBooksIcon,
    coleusLogo,
    coleusSearchIcon,
    coleusSearch,
    coleusArrowLeft,
    coleusGlobe
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
  transition-property: transform;
  transition-duration: 1s;
  transition-timing-function: cubic-bezier(0.23, 1, 0.32, 1);
  /* transition-delay: .5s; */
  & .header_mobile_aside_group {
    transform: translateX(-100%);
    transition-property: transform;
    transition-duration: 0.3s;
    transition-timing-function: ease-in-out;
    &:nth-child(1) {
      transition-delay: 0.2s;
    }
    &:nth-child(2) {
      transition-delay: 0.3s;
    }
    &:nth-child(3) {
      transition-delay: 0.4s;
    }
    &:nth-child(4) {
      transition-delay: 0.5s;
    }
  }
}
.header_mobile_aside--open {
  transform: translateX(0px);
  transition-delay: 0s;
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
