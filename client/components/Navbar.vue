<template>
  <b-navbar toggleable="md" type="dark" variant="dark" sticky>

    <div class="container">
      <b-navbar-brand :to="{ name: 'welcome' }">
        <b-img class="logo logo-fa mr-2" fluid src="/images/logo-192x192.png" alt="Logo" />
      </b-navbar-brand>
        <template v-if="loading">
          <div class="linear-background rounded-circle profile-photo ml-1"></div>
        </template>
        <template v-else>
          <b-navbar-nav class="ml-auto" style="flex-direction: row;">
            <b-dropdown left variant="link" no-caret v-if="auth">
              <template slot="button-content">
                <b-img :src="auth.thumbnail || auth.photo_url" class="rounded-circle profile-photo ml-1" />
              </template>
              <b-dropdown-item :to="{ name: 'profile', params: { 'username': auth.username } }">{{ $t('my_books') }}</b-dropdown-item>
              <b-dropdown-item v-b-modal.modal-center-new-book>{{ $t('new_book') }}</b-dropdown-item>
              <b-dropdown-item :to="{ name: 'settings.profile' }"><fa icon="cog" fixed-width/>{{ $t('settings') }}</b-dropdown-item>
              <b-dropdown-divider></b-dropdown-divider>
              <b-dropdown-item @click.prevent="logout" href="#"><fa icon="sign-out-alt" fixed-width/>{{ $t('logout') }}</b-dropdown-item>
            </b-dropdown>
            <template v-else>
              <li class="nav-item">
                <login></login>
              </li>
              <li class="nav-item">
                <register></register>
              </li>
            </template>
          </b-navbar-nav>
        </template>
    </div>

    <new-book></new-book>

  </b-navbar>
</template>

<script>
import gql from 'graphql-tag'
import { auth } from '~/mixins/auth'

export default {
  mixins: [auth],

  async mounted () {
    this.$root.$on('refresh-navbar', this.attempLogin)
  },

  methods: {
    async logout () {
      let logoutMessage = this.$t('successful_logout_header')

      await this.$apollo.mutate({
        mutation: require('~/graphql/client/mutation/user'),
        variables: { user: null },
      })
      await this.$apolloHelpers.onLogout()

      this.$root.$emit('refresh-navbar')

      // Redirect to login.
      this.$router.push({ name: 'welcome' })

      try {
        this.$snotify.success(logoutMessage)
      } catch (e) {
        // console.warn(e)
      }
    }
  }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
</style>
