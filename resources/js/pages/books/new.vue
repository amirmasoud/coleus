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
      <b-button type="submit" variant="primary">{{ $t('submit') }}</b-button>
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
  }),

  methods: {
    async onSubmit () {
      // Call to the graphql mutation
      // console.log(this.$apollo)
      // let formData = new FormData()
      // Object.keys(this.form).map(d => {
      //   formData.append(d, this.form[d])
      // })
      const result = await this.$apollo.mutate({
        // Query
        mutation: gql`mutation ($title: String!, $description: String!, $cover: Upload!) {
          newBook(title: $title, description: $description, cover: $cover) {
            id
          }
        }`,
        // Parameters
        variables: {
          title: this.form.title,
          description: this.form.description,
          cover: this.form.cover
        },
      })

      // let formData = new FormData()
      // Object.keys(this.form).map(d => {
      //   formData.append(d, this.form[d])
      // })

      // const { data } = axios.post((`graphql/?query=
      //   mutation+books {
      //     newBook(
      //       title: "${this.form.title}",
      //       description: "${this.form.description}",
      //       cover: ""
      //     ) {
      //       id
      //     }
      //   }`).replace(/\s+/g, ''), formData, { headers: { 'Content-Type': 'multipart/form-data' } })
    }
  }
}
</script>
