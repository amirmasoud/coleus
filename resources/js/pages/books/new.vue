<template>
  <div>
    <h2>{{ $t('new_book') }}</h2>
    <b-form @submit.prevent="onSubmit" enctype="multipart/form-data">
      <b-form-group>
        <b-form-file name="avatar"
                    v-model="form.cover"
                    accept="image/jpeg, image/png">
        </b-form-file>
      </b-form-group>
      <b-form-group>
        <b-form-input v-model="form.title"
                      type="text"
                      :placeholder="$t('title')"
                      dir="auto">
        </b-form-input>
      </b-form-group>
      <b-form-group>
        <textarea v-model="form.description"
                 :placeholder="$t('description')"
                 rows="3"
                 class="form-control"
                 dir="auto"></textarea>
      </b-form-group>
      <v-button :loading="loading">{{ $t('submit') }}</v-button>
    </b-form>
  </div>
  <!-- <div class="my-4 text-center"><img src="svg-loaders/oval.svg" /></div> -->
</template>

<script>
import axios from 'axios'
import gql from 'graphql-tag'

export default {
  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('new_book') }
  },

  data: () => ({
    form: new FormData({
      title: null,
      description: null,
      cover: null,
    }),
    loading: false
  }),

  methods: {
    async onSubmit () {
      this.loading = true
      const result = await this.$apollo.mutate({
        mutation: gql`mutation ($title: String!, $description: String!, $cover: Upload!) {
          newBook(title: $title, description: $description, cover: $cover) {
            id
          }
        }`,
        variables: {
          title: this.form.title,
          description: this.form.description,
          cover: this.form.cover
        },
      }).then((data) => {
        this.loading = false
        // Result
        // console.log(data)
      }).catch((error) => {
        this.loading = false
        // Error
        // console.error(error)
      })
    }
  }
}
</script>
