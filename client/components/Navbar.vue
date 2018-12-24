<template>
  <b-navbar toggleable="md" type="dark" variant="dark" sticky>

    <div class="container">
      <b-navbar-brand :to="{ name: 'welcome' }">
        <b-img class="logo logo-fa mr-2" fluid src="/images/logo-192x192.png" alt="Logo" />
      </b-navbar-brand>

      <b-navbar-nav class="ml-auto" style="flex-direction: row;">
<!--         <b-dropdown left variant="link" no-caret v-if="user">
          <template slot="button-content">
            <b-img :src="user.thumbnail || user.photo_url" class="rounded-circle profile-photo mr-1" />
          </template>
          <b-dropdown-item :to="{ name: 'profile', params: { 'username': user.username } }">{{ $t('my_books') }}</b-dropdown-item>
          <b-dropdown-item v-b-modal.modal-center-new-book>{{ $t('new_book') }}</b-dropdown-item>
          <b-dropdown-item :to="{ name: 'settings.profile' }"><fa icon="cog" fixed-width/>{{ $t('settings') }}</b-dropdown-item>
          <b-dropdown-divider></b-dropdown-divider>
          <b-dropdown-item @click.prevent="logout" href="#"><fa icon="sign-out-alt" fixed-width/>{{ $t('logout') }}</b-dropdown-item>
        </b-dropdown> -->

        <li class="nav-item">
          <login></login>
        </li>
        <li class="nav-item">
          <register></register>
        </li>
      </b-navbar-nav>
    </div>

    <new-book></new-book>
  </b-navbar>
</template>

<script>
// import { mapGetters } from 'vuex'

export default {

  // computed: mapGetters({
  //   user: 'auth/user'
  // }),

  methods: {
    async logout () {
      // let logoutMessage = this.$t('successful_logout_header')
      // // Log out the user.
      // await this.$store.dispatch('auth/logout')

      // // Redirect to login.
      // this.$router.push({ name: 'welcome' })

      // try {
      //   this.$snotify.success(logoutMessage)
      // } catch (e) {
      //   // console.warn(e)
      // }
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
