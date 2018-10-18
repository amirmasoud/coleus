<template>
  <div class="main-layout" :class="$store.state.lang.locale == 'fa' ? 'rtl' : ''">
    <navbar/>

    <div class="container mt-4">
      <child/>
    </div>
  </div>
</template>

<script>
import Navbar from '~/components/Navbar'

export default {
  name: 'MainLayout',

  components: {
    Navbar
  }
}
</script>
