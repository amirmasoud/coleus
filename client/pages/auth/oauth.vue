<template>
  <span></span>
</template>

<script>

export default {
  head () {
    return { title: this.$t('login') }
  },

  /**
   * When component mounted, call oauth callback for fetching token and pass it
   * to application using window postMessage method.
   *
   * @return {void}
   */
  async mounted () {
    await this.$apollo.mutate({
      mutation: require('~/graphql/callback'),
      prefetch: false,
      variables: {
        driver: this.$route.params.driver,
        code: this.$route.query.code
      },
    })

    completeCallback(res.data.callback.token)
  },

  data: () => ({
    driver: null,
    code: null
  })
}

/**
 * Send back the token after successful oauth registration
 *
 * @param  {String} token
 * @return {void}
 */
function completeCallback (token) {
  window.opener.postMessage({ token: token }, '/')
  window.close()
}
</script>
