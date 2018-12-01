<template>
  <div id="app">
    <loading ref="loading"/>

    <transition name="page" mode="out-in">
      <component v-if="layout" :is="layout"/>
    </transition>
  </div>
</template>

<script>
import Loading from './Loading'

// Load layout components dynamically.
const requireContext = require.context('~/layouts', false, /.*\.vue$/)

const layouts = requireContext.keys()
  .map(file =>
    [file.replace(/(^.\/)|(\.vue$)/g, ''), requireContext(file)]
  )
  .reduce((components, [name, component]) => {
    components[name] = component.default || component
    return components
  }, {})

export default {
  el: '#app',

  components: {
    Loading
  },

  data: () => ({
    layout: null,
    defaultLayout: 'default'
  }),

  metaInfo () {
    const { appName } = window.config

    return {
      title: appName,
      titleTemplate: `%s → نگارین`,

      meta: [
        { name: 'description', content: 'نگارین، جایی برای خواندن و مطالعه' },

        // Open Graph
        {
          'property': 'og:title',
          'content': '',
          'template': chunk => `${chunk} → نگارین`,
          'vmid': 'og:title'
        },
        { property: 'og:site_name', content: 'نگارین'},
        { property: 'og:type', content: 'website'},
        { property: 'og:url', content: 'https://negar.in' + window.location.pathname},
        { property: 'og:image', content: 'https://negar.in/images/logo-512x512.png', vmid: 'og:image' },
        {
          'property': 'og:description',
          'content': 'نگارین، جایی برای خواندن و مطالعه',
          'template': chunk => `${chunk} → نگارین`,
          'vmid': 'description'
        },

        // Twitter
        {name: 'twitter:card', content: 'summary'},
        {name: 'twitter:site', content: '@negarinapp'},
        {name: 'twitter:creator', content: '@negarinapp'},
        {
          'name': 'twitter:title',
          'content': '',
          'template': chunk => `${chunk} → نگارین`,
          'vmid': 'twitter:title'
        },
        {
          'name': 'twitter:description',
          'content': 'نگارین، جایی برای خواندن و مطالعه',
          'template': chunk => `${chunk} → نگارین`,
          'vmid': 'twitter:description'
        },
        { property: 'twitter:image', content: 'https://negar.in/images/logo-512x512.png', vmid: 'twitter:image' },

        // Google / Schema.org
        {
          'itemprop': 'name',
          'content': '',
          'template': chunk => `${chunk} → نگارین`,
          'vmid': 'name'
        },
        {
          'itemprop': 'description',
          'content': '',
          'template': chunk => `${chunk}`,
          'vmid': 'description'
        },
        { itemprop: 'image', content: 'https://negar.in/images/logo-512x512.png', vmid: 'image' },
      ],
      links: [
        {rel: 'canonical', href: 'https://negar.in' + window.location.pathname}
      ]
    }
  },

  mounted () {
    this.$loading = this.$refs.loading
  },

  methods: {
    /**
     * Set the application layout.
     *
     * @param {String} layout
     */
    setLayout (layout) {
      if (!layout || !layouts[layout]) {
        layout = this.defaultLayout
      }

      this.layout = layouts[layout]
    }
  }
}
</script>
