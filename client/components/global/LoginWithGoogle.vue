<template>
  <button v-if="googleAuth" class="btn px-0 btn-google" type="button" @click="login">
    {{ $t('continue_with_google') }}
    <img style="float: left;background-color: #ffffff;height: 36px;width: 36px;margin: 1px;padding: 9px;margin-top: -5px;border-radius: 3px;" width="18px" alt="Google &quot;G&quot; Logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png"/>
  </button>
</template>

<script>
export default {
  name: 'LoginWithGoogle',

  computed: {
    googleAuth: () => process.env.googleAuth,
    url: () => `${process.env.apiUrl}/oauth/google`
  },

  mounted () {
    window.addEventListener('message', this.onMessage, false)
  },

  beforeDestroy () {
    window.removeEventListener('message', this.onMessage)
  },

  methods: {
    async login () {
      const newWindow = openWindow('', this.$t('login'))

      // const url = await this.$store.dispatch('auth/fetchOauthUrl', {
      //   provider: 'google'
      // })

      newWindow.location.href = url
    },

    /**
     * @param {MessageEvent} e
     */
    async onMessage (e) {

      if (e.origin !== window.origin || !e.data.token) {
        return
      }

      let loginMessage = this.$t('successful_login_header')

      // this.$store.dispatch('auth/saveToken', {
      //   token: e.data.token
      // })

      // Fetch the user.
      // await this.$store.dispatch('auth/fetchUser')

      try {
        this.$snotify.success(loginMessage)

        this.$root.$emit('close-modal')
      } catch(e) {
        // console.warn(e)
      }
    }
  }
}

/**
 * @param  {Object} options
 * @return {Window}
 */
function openWindow (url, title, options = {}) {
  if (typeof url === 'object') {
    options = url
    url = ''
  }

  options = { url, title, width: 600, height: 720, ...options }

  const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screen.left
  const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screen.top
  const width = window.innerWidth || document.documentElement.clientWidth || window.screen.width
  const height = window.innerHeight || document.documentElement.clientHeight || window.screen.height

  options.left = ((width / 2) - (options.width / 2)) + dualScreenLeft
  options.top = ((height / 2) - (options.height / 2)) + dualScreenTop

  const optionsStr = Object.keys(options).reduce((acc, key) => {
    acc.push(`${key}=${options[key]}`)
    return acc
  }, []).join(',')

  const newWindow = window.open(url, title, optionsStr)

  if (window.focus) {
    newWindow.focus()
  }

  return newWindow
}
</script>
