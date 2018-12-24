// import axios from 'axios'

// export default async ({ store, req }) => {
//   const token = this.$apolloHelpers.getToken()

//   console.log(token)

  // if (process.server) {
  //   if (token) {
  //     axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
  //   } else {
  //     delete axios.defaults.headers.common['Authorization']
  //   }
  // }

  // if (!store.getters['auth/check'] && token) {
  //   await store.dispatch('auth/fetchUser')
  // }
// }

// export default async ({ store, req }) => {
//   const token = this.$apolloHelpers.getToken()

//   if (!store.getters['auth/check'] && token) {
//     await store.dispatch('auth/fetchUser')
//   }
// }

// export default async ({ store, req }) => {
//   const hasToken = !!this.$apolloHelpers.getToken()

//   if (! hasToken) {
//     await store.dispatch('auth/fetchUser')
//   }
// }

import gql from 'graphql-tag'

export default async function ({ app }) {
  const token = await app.$apolloHelpers.getToken()
  await app.$apolloHelpers.onLogin(token)
  let client = app.apolloProvider.defaultClient
  client.query({
    query: require('~/graphql/user')
  }).then(({data}) => {
    console.log(data)
    // client.mutate({
    //   mutation: gql`
    //     mutation($user: String!) {
    //       setUser(user: $user) @client
    //     }
    //   `,
    //   variables: { user: data.user },
    // })
  })

  // app.$fetchUser()
  // app.$myInjectedFunction('test')
  // console.log(app.$apollo)
  // if (token) {
  //   app.$apolloHelpers.onLogin(token)

  //   console.log(token)
  // }
}
