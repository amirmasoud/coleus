<template>
  <coleus-container class="flex flex-wrap flex-row">
    <template v-if="users && users.length">
      <h1 class="w-full px-4 mt-4 mb-2 text-2xl">شاعران</h1>
      <nuxt-link
        v-for="user in users"
        :key="user.username"
        class="w-full min-w-sm sm:w-1/2 md:w-1/3"
        :to="{ name: 'username', params: { username: user.username } }"
        no-prefetch
      >
        <div
          class="px-4 py-2 sm:p-2"
          itemscope
          itemprop="Person"
          itemtype="http://schema.org/Person"
          vocab="http://schema.org/"
          typeof="Person"
        >
          <div
            class="bg-white border border-gray-300 flex flex-wrap items-center shadow rounded"
          >
            <div class="w-1/4 -mb-2 p-2">
              <img
                class="hidden"
                itemprop="image"
                property="image"
                :src="user.xsmall"
                :alt="`عکس پروفایل ${user.name}`"
              />
              <client-only>
                <progressive-img
                  class="home-profile"
                  :src="user.xsmall"
                  :placeholder="user.thumbnail"
                  :blur="30"
                  :aspect-ratio="1"
                  :alt="`عکس پروفایل ${user.name}`"
                />
              </client-only>
            </div>
            <div class="w-3/4 flex flex-col text-right pr-4">
              <h2 class="font-semibold" itemprop="name" property="name">
                {{ user.name }}
              </h2>
              <div class="flex justify-between font-light" dir="rtl">
                <div class="text-gray-400">
                  {{ user.book_users_aggregate.aggregate.count }} کتاب
                </div>
              </div>
            </div>
          </div>
        </div>
      </nuxt-link>
    </template>
    <template v-else>
      <div class="container">
        <coleus-spinner class="w-8 mx-auto my-4" />
      </div>
    </template>
  </coleus-container>
</template>

<script>
export default {
  created() {
    if (process.client) {
      window.pageXOffset = 0 // eslint-disable-line nuxt/no-globals-in-created
      document.documentElement.scrollTop = 0 // eslint-disable-line nuxt/no-globals-in-created
      document.body.scrollTop = 0 // eslint-disable-line nuxt/no-globals-in-created
    }
  },
  head() {
    const title = 'خانه - Coleus'
    const description = 'مکانی برای خواندن و یاد گرفتن'
    return {
      title,
      meta: [
        { hid: 'description', name: 'description', content: description },
        // Open Graph
        { hid: 'og:title', property: 'og:title', content: title },
        {
          hid: 'og:description',
          property: 'og:description',
          content: description
        },
        // Twitter Card
        { hid: 'twitter:title', name: 'twitter:title', content: title },
        {
          hid: 'twitter:description',
          name: 'twitter:description',
          content: description
        }
      ]
    }
  },
  apollo: {
    users: {
      query: require('~/graphql/users.gql')
    }
  }
}
</script>
