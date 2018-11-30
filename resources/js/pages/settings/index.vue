<template>
  <div class="row">
    <div class="col-md-3 mb-3">
      <b-list-group>
        <b-list-group-item class="text-left" :to="{ name: tab.route }" v-for="tab in tabs" :key="tab.route">
          <fa :icon="tab.icon" fixed-width/>
          {{ tab.name }}
        </b-list-group-item>
      </b-list-group>
    </div>

    <div class="col-md-9">
      <transition name="fade" mode="out-in">
        <router-view/>
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  middleware: 'auth',

  computed: {
    tabs () {
      return [
        {
          icon: 'user',
          name: this.$t('profile'),
          route: 'settings.profile'
        },
        {
          icon: 'lock',
          name: this.$t('password'),
          route: 'settings.password'
        }
      ]
    }
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
