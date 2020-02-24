require('dotenv').config()

const locale = process.env.NUXT_LOCALE || 'en'
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

export default {
  // modern: 'client',

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
  head: {
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'preconnect', href: 'https://www.google-analytics.com' }
    ]
  },
  buildModules: [
    '@nuxtjs/eslint-module',
    ['~/modules/docs/', { port: 3001 }],
    '~/modules/crawler/',
    '~/modules/static/',
    '~/modules/components/',
    // https://github.com/nuxt-community/netlify-files-module
    '@nuxtjs/netlify-files',
    // https://github.com/nuxt-community/style-resources-module
    '@nuxtjs/style-resources',
    // https://github.com/Developmint/nuxt-svg-loader/
    'nuxt-svg-loader',
    // https://github.com/Atinux/nuxt-tailwindcss/
    '@nuxtjs/tailwindcss',
    // https://pwa.nuxtjs.org
    '@nuxtjs/pwa'
  ],
  modules: [
    // https://http.nuxtjs.or
    '@nuxt/http',
    '@nuxtjs/apollo',
    '@nuxtjs/dotenv'
  ],
  http: {
    proxy: true
  },
  plugins: [
    '~/plugins/init.js',
    '~components/global',
    '~/plugins/intersection-observer.client.js',
    '~/plugins/ga.client.js',
    '~/plugins/adblock.client.js',
    '~/plugins/newsletter.client.js'
  ],
  env: {
    DOC_SEARCH_API_KEY: process.env.DOC_SEARCH_API_KEY || 'ff80fbf046ce827f64f06e16f82f1401',
    NUXT_API: process.env.NUXT_API || 'https://api.nuxtjs.com',
    LOCALE: locale
  },
  manifest: {
    lang: locale
  },
  loading: { color: '#41B883' },
  generate: {
    fallback: true,
    interval: 100
  },
  apollo: {
    clientConfigs: {
      default: '~/plugins/apollo-default-config.js'
    }
  },
}
