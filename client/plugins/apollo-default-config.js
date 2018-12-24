export default function(context){
  return {
    clientState: {
      defaults: {
        token: null,
        user: {
          __typename: 'User'
        }
      },
      resolvers: {
        Mutation: {
          setToken: (_, { token }, { cache }) => {
            const data = { token };
            cache.writeData({ data });
            return token;
          },
          setUser: (_, { user }, { cache }) => {
            const data = { user };
            cache.writeData({ data });
            return data;
          }
        },
      }
    },
    httpEndpoint: context.env.gqlUrl,
  }
}
