<template>
  <div class="main-layout rtl">
    <navbar/>

    <div class="container mt-2">
      <nuxt/>
    </div>
    <no-ssr>
      <vue-snotify></vue-snotify>
    </no-ssr>
  </div>
</template>

<script>
import Navbar from '~/components/Navbar'

export default {
  components: {
    Navbar
  }
}
</script>

