import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'

import '~/plugins'
import '~/components'

import { ApolloClient } from 'apollo-client'
import { HttpLink } from 'apollo-link-http'
import { InMemoryCache } from 'apollo-cache-inmemory'
import VueApollo from 'vue-apollo'
import { createUploadLink } from 'apollo-upload-client';

const httpLink = new HttpLink({
  // You should use an absolute URL here
  uri: '/graphql',
})

// Create the apollo client
const apolloClient = new ApolloClient({
  link: createUploadLink(),
  cache: new InMemoryCache(),
  connectToDevTools: true,
})

const apolloProvider = new VueApollo({
  defaultClient: apolloClient,
})

// Install the vue plugin
Vue.use(VueApollo)

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  apolloProvider,
  ...App
})
