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
    apiUrl: process.env.APP_URL,
    appName: process.env.APP_NAME || 'نگارین',
    appLocale: process.env.APP_LOCALE || 'fa',
    googleAuth: !!process.env.GOOGLE_CLIENT_ID
  },

  head: {
    title: process.env.APP_NAME,
    titleTemplate: '%s → نگارین',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'Nuxt.js project' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ],
    script: [
      { src: `https://cdn.polyfill.io/v2/polyfill.min.js?features=${polyfills.join(',')}` }
    ]
  },

  loading: { color: '#007bff' },

  router: {
    middleware: ['locale', 'check-auth']
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
      default: {
        httpEndpoint: process.env.GQL_URL,
        // persisting: true,
      }
    }
  }
}
