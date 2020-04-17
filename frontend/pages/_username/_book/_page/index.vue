<template>
  <coleus-container>
    <div class="lg:flex">
      <coleus-aside class="hidden lg:block" :loading="$apollo.loading" />
      <div class="min-h-screen w-full lg:static lg:max-h-full lg:overflow-visible lg:w-3/4">
        <div class="-mx-4 lg:mx-0 flex flex-col-reverse lg:flex-row">
          <div
            class="lg:min-h-screen w-full py-8 px-4 lg:static lg:overflow-visible lg:max-h-full lg:w-3/4"
          >
            <!--       @mouseover="$store.dispatch('focusMode')"
            @mouseleave="$store.dispatch('clearFocusMode')"-->
            <div v-if="pages && pages.length">
              <coleus-article>
                <h1 class="text-4xl mb-10 border-indigo-600">{{ pages[0].title }}</h1>
                <div class="flex flex-wrap">
                  <div
                    v-for="block in pages[0].blocks"
                    :key="block.id"
                    class="w-full py-2"
                    :class="{'md:w-1/2': ['m-1/2', 't-1/2'].includes(block.type)}"
                  >{{ block.content }}</div>
                </div>
              </coleus-article>
              <!-- <coleus-pagination /> -->
            </div>
            <template v-else>
              <div class="container">
                <coleus-spinner class="mx-auto my-4" />
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
  </coleus-container>
</template>

<script>
import coleusAside from '@/components/partials/Aside'

export default {
  scrollToTop: false,
  components: {
    coleusAside
  },
  data: () => ({
    page: null
  }),

  mounted() {
    this.$root.$on('content-changed', (param) => {
      this.page = param
    })
  },

  apollo: {
    pages: {
      query: require('~/graphql/page.gql'),
      prefetch: ({ route }) => ({ page: route.params.page }),
      variables() {
        return { page: this.page || this.$route.params.page }
      }
    }
  }
}
</script>
