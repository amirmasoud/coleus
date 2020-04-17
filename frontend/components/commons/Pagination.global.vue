<template>
  <div class="pt-4">
    <div class="clearfix">
      <span>
        ←
        <nuxt-link :to="prev">PREV</nuxt-link>
      </span>
      <span class="inline-block float-right">
        <nuxt-link :to="next">NEXT...</nuxt-link>→
      </span>
    </div>
  </div>
</template>
<script>
export default {}
</script>
