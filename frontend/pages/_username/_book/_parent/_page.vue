<template>
  <coleus-container>
    <div class="lg:flex">
      <coleus-aside class="hidden lg:block" :loading="$apollo.loading" />
      <nuxt-child />
    </div>
  </coleus-container>
</template>

<script>
import coleusAside from '@/components/partials/Aside'
export default {
  components: {
    coleusAside
  }
}
</script>
