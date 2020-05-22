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
    '@nuxtjs/eslint-module',
    '@nuxtjs/tailwindcss',
    '@nuxtjs/global-components',
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
  modules: [
    '@nuxtjs/pwa',
    '@nuxtjs/apollo'
    // '@nuxtjs/sitemap'
  ],
  // sitemap: {
  //   // @TODO: Change to .env
  //   hostname: 'https://www.coleus.app',
  //   gzip: true,
  //   exclude: [],
  //   routes: [
  //     '/page/1',
  //     '/page/2',
  //     {
  //       url: '/page/3',
  //       changefreq: 'daily',
  //       priority: 1,
  //       lastmod: '2017-06-30T13:30:00.000Z'
  //     }
  //   ]
  // },
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
      default: {
        httpEndpoint: process.env.GQL_URL
      },
      backend: {
        httpEndpoint: process.env.BACKEND_URL
      }
    }
  }
}
