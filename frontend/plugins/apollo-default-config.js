export default function (context) {
  // DANGER!!!
  process.env['NODE_TLS_REJECT_UNAUTHORIZED'] = 0
  return {
    httpEndpoint: context.env.GQL_URL
  }
}
