<template>
  <card>
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <!-- <alert-success :form="form" :message="$t('password_updated')"/> -->

      <!-- Password -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('new_password') }}</label>
        <div class="col-md-7">
          <input v-model="form.password" type="password" name="password"
                 class="form-control">
          <!-- <has-error :form="form" field="password"/> -->
        </div>
      </div>

      <!-- Password Confirmation -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('confirm_password') }}</label>
        <div class="col-md-7">
          <input v-model="form.password_confirmation" type="password" name="password_confirmation"
                 class="form-control">
          <!-- <has-error :form="form" field="password_confirmation"/> -->
        </div>
      </div>

      <!-- Submit Button -->
      <div class="form-group row">
        <div class="col-md-9 ml-md-auto">
          <v-button :loading="form.busy" type="success">{{ $t('update') }}</v-button>
        </div>
      </div>
    </form>
  </card>
</template>

<script>
export default {
  scrollToTop: false,

  head () {
    return { title: this.$t('password') }
  },

  data: () => ({
    form: {
      password: '',
      password_confirmation: ''
    }
  }),

  methods: {
    async update () {
      await this.form.patch('/settings/password')

      this.form.reset()
    }
  }
}
</script>
