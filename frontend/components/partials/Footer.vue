<template>
  <footer class="footer z-10 relative bg-white">
    <!-- <newsletter-form/> -->
    <neg-container class="border-t border-gray-300 lg:border-0">
      <div class="flex flex-col sm:flex-row text-center sm:text-left items-center content-center justify-between lg:border-t lg:border-gray-300 pt-10 sm:py-10">
        <nav v-for="(l, title, index) in links" :key="title" class="flex-1 w-full sm:w-auto mb-8 sm:mb-0" :class="{'sm:text-center': index === 1, 'sm:text-right': index === 2}">
          <h3 class="font-bold uppercase text-lg pb-4">
            {{ title }}
          </h3>
          <ul>
            <li v-for="(link, i) in l" :key="i" class="py-2">
              <a v-if="link.href" :href="link.href" target="_blank" rel="noopener noreferrer" class="hover:text-negarin-lightgreen">
                {{ link.key }}
              </a>
              <nuxt-link v-else :to="link.to" class="hover:text-negarin-lightgreen">
                {{ link.key }}
              </nuxt-link>
            </li>
          </ul>
        </nav>
      </div>
    </neg-container>
    <neg-container class="border-t border-gray-300 lg:border-0">
      <div class="flex flex-row items-center content-center justify-between py-4 lg:border-t lg:border-gray-300">
        <div class="flex-1">
          <neg-select v-model="currentTheme" :options="themes">
            <template v-slot:icon>
              <component :is="currentThemeIcon" />
            </template>
          </neg-select>
        </div>
      </div>
    </neg-container>
  </footer>
</template>

<script>
import NewsletterForm from './NewsletterForm'
import negSun from '@/components/svg/Sun'
import negMoon from '@/components/svg/Moon'
import negGlobe from '@/components/svg/Globe'
import negLogo from '@/components/svg/Mountains'
import localeManager from '@/mixins/localeManager'

export default {
  components: {
    NewsletterForm,
    negSun,
    negMoon,
    negGlobe,
    negLogo
  },
  mixins: [
    localeManager
  ],
  data () {
    return {
      themes: [
        { value: 'light', text: 'روشن', icon: 'neg-sun' },
        { value: 'dark', text: 'تیره', icon: 'neg-moon' }
      ],
      links: {
        کشف: [
          { key: 'طراحی', to: '/design' },
          { key: 'تیم', to: '/team' },
          { key: 'آموزش', href: 'https://vueschool.io/?friend=nuxt&utm_source=Nuxtjs.org&utm_medium=Link&utm_content=Footer' }
        ],
        "دنبال‌کردن": [
          { key: 'گیت هاب', href: 'https://github.com/nuxt/nuxt.js' },
          { key: 'توییتر', href: 'https://twitter.com/nuxt_js' },
          { key: 'دیسکورد', href: 'https://discord.nuxtjs.org' }
        ],
        حمایت: [
          { key: 'پشتیبانی', to: '/sponsor-nuxtjs' },
          { key: 'فروشگاه', to: '/shop' },
          { key: 'مشاوره', to: '/support' }
        ]
      }
    }
  },
  computed: {
    currentTheme: {
      get () {
        return this.themes.map(l => l.value).indexOf(this.$store.state.theme)
      },
      set (value) {
        this.$store.commit('setTheme', this.themes[value].value)
      }
    },
    currentThemeIcon () {
      return this.themes[this.currentTheme].icon
    }
  }
}
</script>
