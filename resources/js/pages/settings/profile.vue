<template>
  <card>
    <form @submit.prevent="update" @keydown="form.onKeydown($event)" enctype="multipart/form-data">
      <alert-success :form="form" :message="$t('info_updated')"/>

      <!-- Avatar -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('avatar') }}</label>
        <div class="col-md-7">
          <template v-if="user">
            <b-img v-if="user.small" rounded="circle" width="128" height="128" alt="avatar" class="my-1" :src="user.small" />
            <b-img v-else rounded="circle" width="128" height="128" alt="avatar" class="my-1" :src="user.photo_url" />
          </template>
          <b-form-file :lang="$store.state.lang.locale" name="avatar" v-model="form.avatar" accept="image/jpeg, image/png"></b-form-file>
          <has-error :form="form" field="avatar" />
        </div>
      </div>

      <!-- Name -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
        <div class="col-md-7">
          <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
          <has-error :form="form" field="name"/>
        </div>
      </div>

      <!-- Email -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
        <div class="col-md-7">
          <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
          <has-error :form="form" field="email" />
        </div>
      </div>

      <!-- Website -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('website') }}</label>
        <div class="col-md-7">
          <input v-model="form.website" :class="{ 'is-invalid': form.errors.has('website') }" class="form-control" type="text" name="website">
          <has-error :form="form" field="website"/>
        </div>
      </div>

      <!-- Bio -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('bio') }}</label>
        <div class="col-md-7">
          <textarea v-model="form.bio" :class="{ 'is-invalid': form.errors.has('website') }" class="form-control" name="bio"></textarea>
          <has-error :form="form" field="bio"/>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="form-group row">
        <div class="col-md-9 ml-md-auto">
          <v-button :loading="form.busy">{{ $t('update') }}</v-button>
        </div>
      </div>
    </form>
  </card>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'
import objectToFormData from 'object-to-formdata'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: '',
      avatar: '',
      website: '',
      bio: ''
    })
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  created () {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
  },

  methods: {
    async update () {
      this.form['_method'] = 'PATCH'
      const { data } = await this.form.submit('post', '/api/settings/profile', {
        // Transform form data to FormData
        transformRequest: [function (data, headers) {
          return objectToFormData(data)
        }]
      })
    }
  }
}
</script>
