export default (ctx, inject) => {
  if (process.client && process.static) {
    return
  }
  const $docs = {
    get (path) {
      return fetch('<%= options.url %>' + path).then((response) => {
        if (!response.ok) {
          const error = new Error(response.statusText)
          error.response = response
          throw error
        }
        return response.json()
      })
    }
  }
  inject('docs', $docs)
  ctx.$docs = $docs
}
