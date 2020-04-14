<template>
  <div>
    <coleus-container>
      <div class="flex flex-wrap flex-row-reverse mb-4">
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
      </div>
    </coleus-container>
    <!-- <home-welcome /> -->
    <!-- <home-why /> -->
    <!-- <home-companies /> -->
    <!-- <home-modes /> -->
    <!-- <home-targets/>
    <home-features/>-->
    <!-- <home-sponsors /> -->
  </div>
</template>

<script>
import homeWelcome from '@/components/partials/home/welcome'
import homeWhy from '@/components/partials/home/why'
import homeCompanies from '@/components/partials/home/companies'
// import homeFeatures from '@/components/partials/home/features'
// import homeTargets from '@/components/partials/home/targets'
import homeSponsors from '@/components/partials/home/sponsors'
import homeModes from '@/components/partials/home/modes'

export default {
  components: {
    // homeWelcome,
    // homeWhy,
    // homeCompanies,
    // homeFeatures,
    // homeTargets,
    // homeSponsors,
    // homeModes
  },
  head() {
    return {
      title: this.$store.state.lang.homepage.meta.title,
      meta: [
        {
          name: 'description',
          hid: 'description',
          content: this.$store.state.lang.homepage.meta.description
        },
        // Open Graph
        {
          name: 'og:title',
          content: this.$store.state.lang.homepage.meta.title
        },
        {
          name: 'og:description',
          content: this.$store.state.lang.homepage.meta.description
        },
        { name: 'og:type', content: 'website' },
        { name: 'og:url', content: 'https://nuxtjs.org' },
        { name: 'og:image', content: 'https://nuxtjs.org/meta_640.png' },
        // Twitter Card
        { name: 'twitter:card', content: 'summary' },
        { name: 'twitter:site', content: '@nuxt_js' },
        {
          name: 'twitter:title',
          content: this.$store.state.lang.homepage.meta.title
        },
        {
          name: 'twitter:description',
          content: this.$store.state.lang.homepage.meta.description
        },
        { name: 'twitter:image', content: 'https://nuxtjs.org/meta_640.png' },
        { name: 'twitter:image:alt', content: 'NuxtJS Logo' }
      ]
    }
    // },
    // async asyncData () {
    //   let sponsors = await fetch('https://opencollective.com/nuxtjs/members/organizations.json').then(res => res.json())
    //   return {
    //     sponsors
    //   }
  },
  apollo: {
    users: {
      query: require('~/graphql/users.gql')
    }
  }
}
</script>
