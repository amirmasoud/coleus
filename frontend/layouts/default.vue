<template>
  <div dir="rtl" class="bg-white min-h-screen mb-16">
    <coleus-header v-model="action" />
    <main class="lg:block relative pt-12" :class="{ hidden: action }">
      <nuxt />
    </main>
    <!-- <coleus-footer class="pb-16 lg:pb-0 lg:block" :class="{'hidden': action}" /> -->
  </div>
</template>

<script>
import coleusHeader from '@/components/partials/Header'
// import coleusFooter from '@/components/partials/Footer'

export default {
  components: {
    coleusHeader
    // coleusFooter
  },
  data() {
    return {
      action: ''
    }
  },
  watch: {
    $route() {
      this.action = ''
    }
  }
}
</script>
