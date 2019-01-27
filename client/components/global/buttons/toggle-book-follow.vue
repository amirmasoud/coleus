<template>
  <div class="ml-3" v-if="auth">
    <template v-if="auth.username != $route.params.username">
      <v-button v-if="user.is_following"
                type="outline-primary"
                class="px-4 btn-sm"
                block
                :loading="mutateLoading"
                @click.native="toggleFollow">
        {{ $t('unfollow') }}
      </v-button>
      <v-button v-else
                class="px-4 btn-sm"
                block
                :loading="mutateLoading"
                @click.native="toggleFollow">
        + {{ $t('follow') }}
      </v-button>
    </template>
    <b-button v-else class="px-4" size="sm" variant="success" block v-b-modal.modal-center-new-book>+ {{ $t('new_book') }}</b-button>
  </div>
</template>

<script>
export default {
  name: 'toggle-book-follow-button',

  props: ['auth', 'user', 'loading'],

  data () {
    return {
      mutateLoading: this.loading
    }
  },

  methods: {
    toggleFollow () {
      this.mutateLoading = true
      this.$apollo.mutate({
        mutation: require('~/graphql/follow.gql'),
        variables: {
          user: this.user ? this.user.id : null
        },
      }).then((data) => {
        this.$emit('toggle-follow')
      })
    }
  },

  watch: {
    loading: function(newVal, oldVal) {
      this.mutateLoading = newVal
    }
  }
}
</script>
