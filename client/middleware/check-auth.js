import gql from 'graphql-tag'

export default function ({ app }) {
  const token = app.$apolloHelpers.getToken()

  if (token && ! app.user) {
    app.apolloProvider.defaultClient.query({
      query: require('~/graphql/user'),
    }).then(({data}) => {
      app.apolloProvider.defaultClient.mutate({
        mutation: gql`
          mutation($user: String!) {
            setUser(user: $user) @client
          }
        `,
        variables: { user: data.user },
      }).then(({data}) => {
        app.apolloProvider.defaultClient.query({
          query: gql`query user {
                user @client {
                  name
                  bio
                  email
                  locked
                  photo_url
                  small
                  thumbnail
                  username
                  website
                  xsmall
                }
              }
            `,
        }).then(({ data }) => {
          app.user = data.user
        })
      })
    })
  }

  // app.apolloProvider.defaultClient.query({
  //   query: require('~/graphql/user'),
  // }).then(({data}) => {
  //   app.apolloProvider.defaultClient.mutate({
  //     mutation: gql`
  //       mutation($user: String!) {
  //         setUser(user: $user) @client
  //       }
  //     `,
  //     variables: { user: data.user },
  //   })
  // })

  // if (token && ) {

  // }
  // If the user is not authenticated
  // if (!store.state.authenticated) {
  //   return redirect('/login')
  // }
}
