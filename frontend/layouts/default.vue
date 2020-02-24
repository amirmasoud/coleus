<template>
  <div>
    <neg-header v-model="action" />
    <main class="lg:block relative pt-16 lg:pt-24" :class="{'hidden': action}">
      <nuxt />
    </main>
    <neg-footer class="pb-16 lg:pb-0 lg:block" :class="{'hidden': action}" />
  </div>
</template>

<script>
import negHeader from '@/components/partials/Header'
import negFooter from '@/components/partials/Footer'

export default {
  components: {
    negHeader,
    negFooter
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
    let canonical = `https://negar.in${this.$route.path}`
    const link = [
      { rel: 'canonical', href: canonical },
      { rel: 'alternate', hreflang: 'en', href: `https://negar.in${this.$route.path}` },
      { rel: 'alternate', hreflang: 'zh', href: `https://zh.negar.in${this.$route.path}` },
      { rel: 'alternate', hreflang: 'ru', href: `https://ru.negar.in${this.$route.path}` },
      { rel: 'alternate', hreflang: 'ja', href: `https://ja.negar.in${this.$route.path}` },
      { rel: 'alternate', hreflang: 'ko', href: `https://ko.negar.in${this.$route.path}` },
      { rel: 'alternate', hreflang: 'fr', href: `https://fr.negar.in${this.$route.path}` },
      { rel: 'alternate', hreflang: 'id', href: `https://id.negar.in${this.$route.path}` }
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
