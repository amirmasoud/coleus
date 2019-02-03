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
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: pkg.description }
    ],
    link: [{ rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }]
  },

  /*
  ** Customize the progress-bar color
  */
  loading: { color: '#fff' },

  /*
  ** Global CSS
  */
  css: ['~/assets/css/tailwind.css'],

  /*
  ** Plugins to load before mounting the App
  */
  plugins: [
    '~components/global',
    '~plugins/i18n',
    '~plugins/fontawesome',
    { src: '~plugins/progressive', ssr: false },
    { src: '~plugins/snotify', ssr: false }
  ],

  /*
  ** Nuxt.js modules
  */
  modules: [
    '@nuxtjs/pwa',
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
