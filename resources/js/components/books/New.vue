<template>
  <b-modal id="modal-center-new-book"
           centered
           :title="$t('new_book')"
           hide-footer
           ref="newBookModal">
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
                      dir="auto"></b-form-input>
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
  </b-modal>
</template>

<script>
import gql from 'graphql-tag'

export default {
  name: 'NewBook',

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

        this.form.title = null
        this.form.description = null
        this.form.cover = null

        let newBookMessage = this.$t('new_book_added')

        try {
          this.$snotify.success(newBookMessage)

          this.$refs.newBookModal.hide()
        } catch(e) {
          // console.warn(e)
        }
      }).catch((error) => {
        this.loading = false
        // Error
        // console.error(error)
      })
    }
  }
}
</script>
