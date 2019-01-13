<template>
  <div class="row mt-5">
    <div class="col-md-6 m-auto">
      <card>
        <login-form :redirect="true"></login-form>
      </card>
    </div>
  </div>
</template>

<script>
export default {
  head () {
    return { title: this.$t('login') }
  }
}
</script>
