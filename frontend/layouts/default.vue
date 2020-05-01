<template>
  <div dir="rtl" class="bg-gray-100 min-h-screen">
    <coleus-header v-model="action" />
    <main class="lg:block relative pt-20 md:pt-24" :class="{'hidden': action}">
      <nuxt />
    </main>
    <!-- <coleus-footer class="pb-16 lg:pb-0 lg:block" :class="{'hidden': action}" /> -->
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
  data() {
    return {
      action: ''
    }
  },
  head: {
    script: [
      {
        src: 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js',
        'data-ad-client': process.env.GOOGLE_ADSENSE_ID
      }
    ]
  },
  watch: {
    $route() {
      this.action = ''
    }
  }
}
</script>
