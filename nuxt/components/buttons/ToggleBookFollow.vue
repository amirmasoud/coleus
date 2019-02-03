<template>
  <div v-if="auth" class="ml-3">
    <template v-if="auth.username != $route.params.username">
      <v-button
        v-if="user.is_following"
        type="outline-primary"
        class="px-4 btn-sm"
        block
        :loading="mutateLoading"
        @click.native="toggleFollow"
      >
        {{ $t('unfollow') }}
      </v-button>
      <v-button
        v-else
        class="px-4 btn-sm"
        block
        :loading="mutateLoading"
        @click.native="toggleFollow"
      >
        + {{ $t('follow') }}
      </v-button>
    </template>
  </div>
</template>

<script>
export default {
  name: 'ToggleBookFollowButton',

  props: {
    auth: {
      type: Object,
      default: () => ({})
    },
    user: {
      type: Object,
      default: () => ({})
    },
    loading: {
      type: Boolean,
      default: true
    }
  },

  data: () => {
    return {
      mutateLoading: this.loading
    }
  },

  watch: {
    loading: function(newVal, oldVal) {
      this.mutateLoading = newVal
    }
  },

  methods: {
    toggleFollow() {
      this.mutateLoading = true
      this.$apollo
        .mutate({
          mutation: require('~/graphql/follow.gql'),
          variables: {
            user: this.user ? this.user.id : null
          }
        })
        .then(data => {
          this.$emit('toggle-follow')
        })
    }
  }
}
</script>
