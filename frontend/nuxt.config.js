import dotenv from 'dotenv'
dotenv.config()

export default {
  mode: 'universal',

  env: {
    //   APP_ENV: process.env.APP_ENV,
    //   APP_LOCALE: process.env.APP_LOCALE,
    //   FRONT_URL: process.env.FRONT_URL,
    //   GQL_URL: process.env.GQL_URL,
    //   BASE_URL: process.env.BASE_URL,
    GOOGLE_ANALYTICS_ID: process.env.GOOGLE_ANALYTICS_ID
  },

  /*
   ** Headers of the page
   */
  head: {
    title: process.env.npm_package_name || '',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      {
        hid: 'description',
        name: 'description',
        content: process.env.npm_package_description || ''
      }
    ],
    link: [{ rel: 'icon', type: 'image/png', href: '/favicon.png' }]
  },
  /*
   ** Customize the progress-bar color
   */
  loading: { color: '#fff' },
  /*
   ** Global CSS
   */
  css: [],
  /*
   ** Plugins to load before mounting the App
   **
   */
  plugins: [{ src: '~/plugins/progressive-image.js', mode: 'client' }],
  /*
   ** Nuxt.js dev-modules
   */
  buildModules: [
    // Doc: https://github.com/nuxt-community/eslint-module
    '@nuxtjs/eslint-module',
    // Doc: https://github.com/nuxt-community/nuxt-tailwindcss
    '@nuxtjs/tailwindcss',
    // Doc: https://github.com/nuxt-community/global-components
    '@nuxtjs/global-components',
    // Doc: https://github.com/nuxt-community/dotenv-module
    '@nuxtjs/dotenv',
    [
      '@nuxtjs/google-analytics',
      {
        id: process.env.GOOGLE_ANALYTICS_ID
        // debug: {
        //   enabled: true,
        //   sendHitTask: true
        // }
      }
    ]
  ],
  /*
   ** Nuxt.js modules
   */
  modules: ['@nuxtjs/pwa', '@nuxtjs/apollo'],
  /*
   ** Build configuration
   */
  build: {
    /*
     ** You can extend webpack config here
     */
    extend(config, ctx) {}
  },
  apollo: {
    clientConfigs: {
      default: '~/plugins/apollo-default-config.js'
    }
  }
}
