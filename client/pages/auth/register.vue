<template>
  <div class="row mt-5">
    <div class="col-md-6 m-auto">
      <!-- Register Form Card -->
      <card>
        <register-form></register-form>
      </card>
    </div>
  </div>
</template>

<script>
export default {
  head () {
    return { title: this.$t('register') }
  }
}
</script>
