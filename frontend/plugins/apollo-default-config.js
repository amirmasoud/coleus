export default function(context) {
   // DANGER!!!
    process.env['NODE_TLS_REJECT_UNAUTHORIZED'] = 0
    return {
      clientState: {
        defaults: {
          user: {
            __typename: 'User'
          }
        },
        resolvers: {
          Mutation: {
            setUser: (_, { user }, { cache }) => {
              const data = { user }
              cache.writeData({ data })
              return data
            }
          }
        }
      },
      httpEndpoint: context.env.GQL_URL
    }
  }
