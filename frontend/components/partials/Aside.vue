<template>
  <aside
    :class="{ 'opacity-25': $store.state.focusMode }"
    class="opacity-transition block bg-gray-100 mt-8 -mx-4 lg:bg-transparent lg:mt-0 lg:mx-0 lg:inset-0 z-90 lg:mb-0 lg:static lg:h-auto lg:overflow-y-visible lg:pt-0 lg:w-1/4 lg:block"
  >
    <div
      class="h-full overflow-y-auto scrolling-touch text-center lg:text-right lg:h-auto lg:block lg:relative lg:sticky lg:top-24"
    >
      <a
        v-if="breadcrumb"
        class="block text-right p-4 lg:hidden"
        href="#nav"
        @click.prevent="showNav = !showNav"
      >
        <coleus-times v-if="showNav" class="float-right mt-1 mr-1 h-5" />
        <coleus-caret-down v-else class="float-right mt-2 mr-1" />
        <span class="uppercase text-gray-500 ml-1">{{ breadcrumb.group }} :</span>
        {{ breadcrumb.title }}
      </a>
      <nav
        id="test"
        class="pt-8 lg:overflow-y-auto lg:block lg:pl-0 lg:pl-8 sticky?lg:h-(screen-24)"
        :class="{ hidden: !showNav }"
      >
        <div v-if="books && books.length">
          <template v-for="(page, index) in books[0].pages">
            <h3
              :key="`title-${index}`"
              :id="`page-${page.id}`"
              class="uppercase text-gray-500 pb-2"
            >{{ page.title }}</h3>
            <ul :key="`list-${index}`" class="pb-8">
              <li
                v-for="subpage in page.pages"
                :key="subpage.id"
                :id="`page-${subpage.id}`"
                @click.prevent="scrollTo(subpage.id)"
                class="py-2"
              >
                <nuxt-link
                  class="text-gray-700 hover:text-coleus-lightgreen"
                  :class="{'text-coleus-lightgreen': false}"
                  :to="{ name: 'username-book-page', params: { username: $route.params.username, book: $route.params.book, page: subpage.id } }"
                >{{ subpage.title }}</nuxt-link>
              </li>
            </ul>
          </template>
        </div>
      </nav>
    </div>
  </aside>
</template>

<script>
import throttle from 'lodash/throttle'
import coleusCaretDown from '@/components/svg/CaretDown'
import coleusTimes from '@/components/svg/Times'

export default {
  components: {
    coleusCaretDown,
    coleusTimes
  },
  data() {
    return { current: 0, setInter: null, showNav: false }
  },
  apollo: {
    books: {
      query: require('~/graphql/aside.gql'),
      prefetch: ({ route }) => ({ book: route.params.book }),
      variables() {
        return { book: this.$route.params.book }
      }
    }
  },
  computed: {
    // list() {
    //   // this.$store.state.menu[this.$route.params.section] ||
    //   return [
    //     { title: 'title', links: [{ to: '/', name: 'name' }] },
    //     { title: 'title', links: [{ to: '/', name: 'name' }] }
    //   ]
    // },
    // visible() {
    //   return this.$store.state.visibleAffix
    // },
    // path() {
    //   return this.$route.path.slice(-1) === '/'
    //     ? this.$route.path.slice(0, -1)
    //     : this.$route.path
    // },
    // menu() {
    //   return '/' + this.$route.params.section
    // },
    breadcrumb() {
      let breadcrumb = null
      if (this.books && this.books.length) {
        this.books[0].pages.forEach((group) => {
          group.pages.forEach((link) => {
            breadcrumb = { group: group.title, title: link.title }
          })
        })
      }
      // this.list.forEach((group) => {
      //   group.links.forEach((link) => {
      //     //           (this.$route.params.slug &&
      //     //   link.to === '/' + this.$route.params.slug) ||
      //     // (!this.$route.params.slug && (link.to === '' || link.to === '/'))
      //     if (true) {
      //       breadcrumb = { group: group.title, title: link.name }
      //     }
      //   })
      // })
      return breadcrumb
    },
    // contents() {
    //   const c = []
    //   this.list.forEach((group) => {
    //     if (Array.isArray(group.links) && !c.length) {
    //       const l = group.links.find((link) => {
    //         return this.path === this.menu + link.to
    //       })
    //       if (l && l.contents) {
    //         l.contents.forEach((content) => {
    //           const el = document.getElementById(content.to.slice(1))
    //           if (el) {
    //             c.push(el.offsetTop)
    //           }
    //         })
    //       }
    //     }
    //   })
    //   return c
    // }
  },
  // watch: {
  //   '$route.fullPath': 'hashChanged'
  // },
  // mounted() {
  //   this.$nextTick(() => {
  //     window.addEventListener(
  //       'scroll',
  //       throttle(() => this.scrolled(), 100)
  //     )
  //     if (this.$route.hash.length) {
  //       this.scrollTo(this.$route.hash)
  //     }
  //     this.scrolled()
  //   })
  // },
  methods: {
    // hashChanged(toPath, fromPath) {
    //   this.showNav = false
    //   toPath = toPath.split('#')
    //   fromPath = fromPath.split('#')
    //   this.$nextTick(() => this.scrollTo(this.$route.hash))
    // },
    toggle() {
      this.$store.commit('toggle', 'visibleAffix')
    },
    // scrolled() {
    //   const h =
    //     window.innerHeight ||
    //     document.documentElement.clientHeight ||
    //     document.body.clientHeight
    //   const doc = document.documentElement
    //   const top = (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0)
    //   const el = this.contents.find((pos) => {
    //     return pos > top + h / 2
    //   })
    //   this.current = (el ? this.contents.indexOf(el) : this.contents.length) - 1
    // },
    scrollTo(id) {
      console.log(`#page-${id}`)
      document.querySelector(`#page-${id}`).scrollIntoView()
    }
    // scrollTo(id) {
    //   if (this._scrolling) {
    //     return
    //   }
    //   this._scrolling = true
    //   if (this.$store.state.visibleAffix) {
    //     this.toggle()
    //   }
    //   if (id !== this.$route.hash) {
    //     this.$router.push(this.$route.fullPath.split('#')[0] + id)
    //   }
    //   this.$nextTick(() => {
    //     const el = document.getElementById(id.slice(1))
    //     if (!el) {
    //       this._scrolling = false
    //       return
    //     }
    //     const to = el.offsetTop - (window.outerWidth < 1024 ? 90 : 120)
    //     const doc = document.documentElement
    //     let top = (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0)
    //     const diff = (to > top ? to - top : top - to) / 25
    //     let i = 0
    //     window.clearInterval(this.setInter)
    //     this.setInter = window.setInterval(() => {
    //       top = to > top ? top + diff : top - diff
    //       window.scrollTo(0, top)
    //       i++
    //       if (i === 25) {
    //         this._scrolling = false
    //         window.clearInterval(this.setInter)
    //       }
    //     }, 10)
    //   })
    // }
  }
}
</script>
