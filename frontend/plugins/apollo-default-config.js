export default function (context) {
  if (context.env.APP_ENV == 'local') {
  }
  process.env['NODE_TLS_REJECT_UNAUTHORIZED'] = 0

  return {
    httpEndpoint: context.env.GQL_URL
  }
}
