<template>
  <coleus-container class="flex flex-wrap flex-row">
    <template v-if="users && users.length">
      <nuxt-link
        class="w-full md:w-1/4 group"
        v-for="user in users"
        :key="user.username"
        :to="{ name: 'username', params: { username: user.username }}"
        no-prefetch
      >
        <div class="p-2">
          <div
            class="flex flex-row-reverse p-4 border border-gray-200 shadow-sm rounded-md group-hover:shadow-lg transition-shadow duration-500 ease-in-out"
          >
            <div class="w-full flex flex-col mr-4 text-right">
              <h1 class="font-semibold">{{ user.name }}</h1>
              <div class="flex justify-between font-light" dir="rtl">
                <div>
                  <span class="font-medium">{{ user.book_users_aggregate.aggregate.count }}</span> کتاب
                </div>
              </div>
            </div>
            <img class="w-12 h-12 shadow rounded-full" :src="user.xsmall" />
          </div>
        </div>
      </nuxt-link>
    </template>
    <template v-else>
      <div class="container">
        <coleus-spinner class="mx-auto my-4" />
      </div>
    </template>
  </coleus-container>
</template>

<script>
export default {
  apollo: {
    users: {
      query: require('~/graphql/users.gql')
    }
  }
}
</script>
