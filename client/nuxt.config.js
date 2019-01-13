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
  // mode: 'spa',

  srcDir: __dirname,

  env: {
    apiUrl: process.env.API_URL,
    gqlUrl: process.env.GQL_URL,
    appName: process.env.APP_NAME || 'نگارین',
    appLocale: process.env.APP_LOCALE || 'fa',
    googleAuth: !!process.env.GOOGLE_CLIENT_ID,
    githubAuth: !!process.env.GITHUB_CLIENT_ID
  },

  head: {
    title: process.env.APP_NAME,
    titleTemplate: '%s → نگارین',

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
    ]
  },

  loading: { color: '#007bff' },

  router: {
    middleware: []
  },

  css: [
    { src: '~assets/sass/app.scss', lang: 'scss' }
  ],

  plugins: [
    '~components/global',
    '~plugins/i18n',
    '~plugins/axios',
    '~plugins/fontawesome',
    // '~plugins/nuxt-client-init',
    // { src: '~plugins/auth', ssr: false },
    { src: '~plugins/progressive', ssr: false },
    { src: '~plugins/snotify', ssr: false },
    { src: '~plugins/vee-validate.js', ssr: true },
    { src: '~plugins/scroller.js', ssr: false }
  ],

  modules: [
    '@nuxtjs/router',
    '~/modules/spa',
    '@nuxtjs/apollo',
    ['bootstrap-vue/nuxt', { css: false }],
  ],

  build: {
    extractCSS: true
  },

  apollo: {
    clientConfigs: {
      default: '~/plugins/apollo-default-config.js',
    },
  }
}
