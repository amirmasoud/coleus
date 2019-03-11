const pkg = require('./package')
require('dotenv').config()

const polyfills = [
  'Promise',
  'Object.assign',
  'Object.values',
  'Array.prototype.find',
  'Array.prototype.findIndex',
  'Array.prototype.includes',
  'String.prototype.includes',
  'String.prototype.startsWith',
  'String.prototype.endsWith',
  'IntersectionObserver'
]

module.exports = {
  mode: 'universal',

  debug: true,

  /*
  ** Global .env variables
  */
  env: {
    appUrl: process.env.APP_URL,
    apiUrl: process.env.API_URL,
    gqlUrl: process.env.GQL_URL,
    appName: process.env.APP_NAME || 'نگارین',
    appLocale: process.env.APP_LOCALE || 'fa',
    googleAuth: !!process.env.GOOGLE_CLIENT_ID,
    githubAuth: !!process.env.GITHUB_CLIENT_ID
  },

  /*
  ** Headers of the page
  */
  head: {
    title: pkg.name || process.env.APP_NAME,
    titleTemplate: '%s ← نگارین',

    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { name: 'theme-color', content: '#343a40' },

      // Open Graph
      { property: 'og:type', content: 'website'},
      { property: 'og:site_name', content: 'نگارین'},
      // { property: 'og:url', content: 'https://negar.in' + ___CURRENT_PATH___ },


      // Twitter
      {name: 'twitter:card', content: 'summary'},
      {name: 'twitter:site', content: '@negarinapp'},
      {name: 'twitter:creator', content: '@negarinapp'},

      // Sub pages
      // { itemprop: 'name', content: '', hid: 'name' },
      // { property: 'og:title', content: '', hid: 'og:title' },
      // { name: 'twitter:title', content: '', hid: 'twitter:title' },
      // { itemprop: 'description', content: '', hid: 'description' },
      // { hid: 'description', name: 'description', content: 'نگارین، جایی برای خواندن و مطالعه' },
      // { name: 'twitter:description', content: 'نگارین، جایی برای خواندن و مطالعه', hid: 'twitter:description' },
      // { property: 'og:description', content: 'نگارین، جایی برای خواندن و مطالعه', hid: 'description' },
      // { itemprop: 'image', content: 'https://negar.in/images/logo-512x512.png', hid: 'image' },
      // { property: 'twitter:image', content: 'https://negar.in/images/logo-512x512.png', hid: 'twitter:image' },
      // { property: 'og:image', content: 'https://negar.in/images/logo-512x512.png', hid: 'og:image' },
    ],

    link: [
      { rel: 'icon', sizes: '192x192', href: '/images/logo-192x192.png' },
      { rel: 'icon', sizes: '192x192', href: '/images/touch-icon-192x192.png' },
      { rel: 'icon', sizes: '32x32', href: '/images/favicon-32x32.png' },
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      // { rel: 'canonical', href: 'https://negar.in' + ___CURRENT_PATH___ },
      { rel: 'dns-prefetch', href: '//negar.in' }
    ],

    script: [
      { src: `https://cdn.polyfill.io/v2/polyfill.min.js?features=${polyfills.join(',')}` }
    ],

    bodyAttrs: {
      class: 'bg-white'
    }
  },

  /*
  ** Customize the progress-bar color
  */
  loading: { color: '#007bff' },

  /*
  ** Global CSS
  */
  css: [
    '~/assets/css/tailwind.css'
  ],

  /*
  ** Plugins to load before mounting the App
  */
  plugins: [
    '~components/global',
    '~plugins/i18n',
    '~plugins/fontawesome',
    { src: '~plugins/progressive', ssr: false },
    { src: '~plugins/snotify', ssr: false },
    { src: '~plugins/scroller.js', ssr: false }
  ],

  /*
  ** Nuxt.js modules
  */
  modules: [
    '@nuxtjs/apollo'
  ],

  /*
  ** Build configuration
  */
  build: {
    /*
    ** You can extend webpack config here
    */
    extend(config, ctx) {
      // Run ESLint on save
      if (ctx.isDev && ctx.isClient) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })
      }
    }
  },

  /*
  ** Apollo default config
  */
  apollo: {
    clientConfigs: {
      default: '~/plugins/apollo-default-config.js',
    },
  },

  router: {
    extendRoutes (routes, resolve) {
      routes.push({
        name: 'profile',
        path: '/@:username',
        component: resolve(__dirname, 'pages/user/_username.vue')
      })
    }
  }
}
