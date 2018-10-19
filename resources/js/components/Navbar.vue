<template>
  <div>
    <div class="text-center py-1" style="background: #96e7d3;color: white;"><small>{{ $t('beta_version') }}</small></div>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
      <div class="container">
        <router-link :to="{ name: 'welcome' }" class="navbar-brand" v-if="config">
          <b-img class="logo logo-en" fluid :src="config.logoEn" alt="Logo" v-if="$store.state.lang.locale == 'en'" />
          <b-img class="logo logo-fa" fluid :src="config.logoFa" alt="Logo" v-else />
          {{ $t('negarin') }}
        </router-link>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false">
          <span class="navbar-toggler-icon"/>
        </button>

        <div id="navbarToggler" class="collapse navbar-collapse">
          <ul class="navbar-nav">
            <locale-dropdown/>
            <!-- <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li> -->
          </ul>

          <ul class="navbar-nav ml-auto">
            <!-- Authenticated -->
            <li v-if="user" class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-dark"
                 href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img :src="user.thumbnail || user.photo_url" class="rounded-circle profile-photo mr-1">
              </a>
              <div class="dropdown-menu">
                <router-link :to="{ name: 'settings.profile' }" class="dropdown-item pl-3">
                  <fa icon="cog" fixed-width/>
                  {{ $t('settings') }}
                </router-link>

                <div class="dropdown-divider"/>
                <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
                  <fa icon="sign-out-alt" fixed-width/>
                  {{ $t('logout') }}
                </a>
              </div>
            </li>
            <!-- Guest -->
            <template v-else>
              <li class="nav-item">
                <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
                  {{ $t('login') }}
                </router-link>
              </li>
              <li class="nav-item">
                <router-link :to="{ name: 'register' }" class="nav-link" active-class="active">
                  {{ $t('register') }}
                </router-link>
              </li>
            </template>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },

  computed: mapGetters({
    user: 'auth/user'
  }),

  data: () => ({
    config: null
  }),

  created () {
    this.config = window.config
  },

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
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
