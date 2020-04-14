<template>
  <div dir="rtl">
    <coleus-header v-model="action" />
    <main class="lg:block relative pt-20 lg:pt-24" :class="{'hidden': action}">
      <nuxt />
    </main>
    <coleus-footer class="pb-16 lg:pb-0 lg:block" :class="{'hidden': action}" />
  </div>
</template>

<script>
import coleusHeader from '@/components/partials/Header'
import coleusFooter from '@/components/partials/Footer'

export default {
  components: {
    coleusHeader,
    coleusFooter
  },
  data () {
    return {
      action: ''
    }
  },
  watch: {
    $route () {
      this.action = ''
    }
  },
  head () {
    let canonical = `https://coleus.app${this.$route.path}`
    const link = [
      { rel: 'canonical', href: canonical },
      { rel: 'alternate', hreflang: 'en', href: `https://coleus.app${this.$route.path}` },
      { rel: 'alternate', hreflang: 'zh', href: `https://zh.coleus.app${this.$route.path}` },
      { rel: 'alternate', hreflang: 'ru', href: `https://ru.coleus.app${this.$route.path}` },
      { rel: 'alternate', hreflang: 'ja', href: `https://ja.coleus.app${this.$route.path}` },
      { rel: 'alternate', hreflang: 'ko', href: `https://ko.coleus.app${this.$route.path}` },
      { rel: 'alternate', hreflang: 'fr', href: `https://fr.coleus.app${this.$route.path}` },
      { rel: 'alternate', hreflang: 'id', href: `https://id.coleus.app${this.$route.path}` }
    ]
    link.forEach((l) => {
      if (l.href.slice(-1) !== '/') {
        l.href = l.href + '/'
      }
    })
    return {
      htmlAttrs: { lang: this.$store.state.locale },
      link
    }
  }
}
</script>
