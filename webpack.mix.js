
const path = require('path')
const mix = require('laravel-mix')
// const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer')

mix.config.vue.esModule = true

mix
  .js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')

  .sourceMaps()
  .disableNotifications()

if (mix.inProduction()) {
  mix.version()

  mix.extract([
    'vue',
    'axios',
    'vuex',
    'jquery',
    'tiptap',
    'graphql',
    'vue-i18n',
    'vue-meta',
    'popper.js',
    'js-cookie',
    'bootstrap',
    'vue-router',
    'vue-apollo',
    'sweetalert2',
    'graphql-tag',
    'apollo-boost',
    'apollo-link',
    'vuedraggable',
    'apollo-client',
    'bootstrap-vue',
    'apollo-link-http',
    'vuex-router-sync',
    'tiptap-extensions',
    'object-to-formdata',
    'apollo-upload-client',
    'apollo-cache-inmemory',
    '@fortawesome/vue-fontawesome',
    '@fortawesome/fontawesome-svg-core'
  ])
}

mix.webpackConfig({
  plugins: [
    // new BundleAnalyzerPlugin()
  ],
  resolve: {
    extensions: ['.js', '.json', '.vue'],
    alias: {
      '~': path.join(__dirname, './resources/js')
    }
  },
  output: {
    chunkFilename: 'js/[name].[chunkhash].js',
    publicPath: mix.config.hmr ? '//localhost:8080' : '/'
  },
  module: {
    rules: [
      {
        test: /\.(graphql|gql)$/,
        exclude: /node_modules/,
        loader: 'graphql-tag/loader',
      },
    ],
  }
})
