<template>
  <coleus-container class="flex flex-wrap flex-row">
    <template v-if="users && users.length">
      <nuxt-link
        class="w-full md:w-1/4"
        v-for="user in users"
        :key="user.username"
        :to="{ name: 'username', params: { username: user.username }}"
        no-prefetch
      >
        <div class="p-2">
          <div
            class="bg-white border border-gray-300 flex flex-wrap items-center p-2 border border-gray-200 shadow-md rounded-full group-hover:shadow-lg transition-shadow duration-500 ease-in-out"
          >
            <div class="w-1/4 max-h-12 -mb-2">
              <no-ssr>
                <progressive-img
                  class="shadow rounded-full border border-gray-300"
                  :src="user.xsmall"
                  :placeholder="user.thumbnail"
                  :blur="30"
                  :aspect-ratio="1"
                />
              </no-ssr>
            </div>
            <div class="w-3/4 flex flex-col text-right pr-4">
              <h1 class="font-semibold">{{ user.name }}</h1>
              <div class="flex justify-between font-light" dir="rtl">
                <div class="text-gray-400">{{ user.book_users_aggregate.aggregate.count }} کتاب</div>
              </div>
            </div>
          </div>
        </div>
      </nuxt-link>
    </template>
    <template v-else>
      <div class="container">
        <coleus-spinner class="mx-auto my-4 bg-white rounded-full p-1 shadow" />
      </div>
    </template>
  </coleus-container>
</template>

<script>
export default {
  head: {
    title: 'خانه',
    meta: [
      {
        hid: 'description',
        name: 'description',
        content:
          'چایی برای ماندن'
      }
    ]
  },
  apollo: {
    users: {
      query: require('~/graphql/users.gql')
    }
  }
}
</script>
