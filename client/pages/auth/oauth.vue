<template>
  <div></div>
</template>

<script>

export default {
  head () {
    return { title: this.$t('login') }
  },

  async mounted () {
    const result = await this.$apollo.mutate({
      mutation: require('~/graphql/callback'),
      prefetch: false,
      variables: {
        driver: this.$route.params.driver,
        code: this.$route.query.code
      },
    }).then((res) => {
      console.log(res)
      completeCallback(res.data.callback.token)
    })
  },

  data: () => ({
    driver: null,
    code: null
  })
}

function completeCallback (token) {
  window.opener.postMessage({ token: token }, '/')
  window.close()
}
</script>
