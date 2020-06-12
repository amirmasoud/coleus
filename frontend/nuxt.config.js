import dotenv from 'dotenv'
dotenv.config()

export default {
  mode: 'universal',

  /**
   * Component to auto-load and their prefixes.
   */
  components: [
    { path: '~/components/', prefix: 'coleus' },
    { path: '~/components/svg/', prefix: 'coleus-svg' }
  ],

  /*
   ** Headers of the page
   */
  head: {
    htmlAttrs: {
      lang: 'fa'
    },
    title: 'Coleus',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial scale=1' }
    ],
    link: [{ rel: 'icon', type: 'image/png', href: '/favicon.png' }]
  },

  /*
   ** Plugins to load before mounting the App
   **
   */
  plugins: [{ src: '~/plugins/progressive-image.js', mode: 'client' }],

  /*
   ** Nuxt.js dev-modules
   */
  buildModules: [
    '@nuxtjs/eslint-module',
    '@nuxtjs/tailwindcss',
    '@nuxt/components',
    '@nuxtjs/dotenv',
    [
      '@nuxtjs/google-analytics',
      {
        id: process.env.GOOGLE_ANALYTICS_ID
      }
    ]
  ],

  /*
   ** Nuxt.js modules
   */
  modules: ['@nuxtjs/pwa', '@nuxtjs/apollo'],

  apollo: {
    clientConfigs: {
      default: {
        httpEndpoint: process.env.GQL_URL
      },
      backend: {
        httpEndpoint: process.env.BACKEND_URL
      }
    }
  }
}
