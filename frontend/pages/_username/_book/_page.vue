<template>
  <coleus-container>
    <div class="lg:flex">
      <coleus-aside class="hidden lg:block"/>
      <div class="min-h-screen w-full lg:static lg:max-h-full lg:overflow-visible lg:w-3/4">
        <nuxt-child />
      </div>
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
