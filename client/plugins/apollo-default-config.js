export default function(context){
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
