<template>
  <div v-if="users" class="flex mt-2">
    <div v-for="user in users" :key="user.id" class="w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 xl:w-1/12 mb-4 p-2">
      <div class="max-w-sm rounded overflow-hidden shadow-md">
        <img class="w-full" :src="user.small">
        <div class="px-6 py-2 px-0">
          <div class="text-lg mb-1 py-1">
            {{ user.name }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  head() {
    return {
      title: this.$t('home')
    }
  },

  apollo: {
    users: {
      query: require('~/graphql/users.gql'),
      prefetch: true
    }
  }
}
</script>
