<template>
  <div class="-mx-4 lg:mx-0 flex flex-col-reverse lg:flex-row">
    <div
      class="lg:min-h-screen w-full py-8 px-4 lg:static lg:overflow-visible lg:max-h-full lg:w-3/4"
      @mouseover="$store.dispatch('focusMode')"
      @mouseleave="$store.dispatch('clearFocusMode')"
    >
      <!-- <div v-if="page.langFallback" class="p-4 mb-6 bg-orange-200 rounded">
        ⚠️ You are looking at the english version of the page. Help us translate it
        <a :href="docLink" class="text-orange-600">here</a>.
      </div> -->

      <div v-if="pages && pages.length">
        <coleus-article>
          <h1>{{ pages[0].title }}</h1>
          <!-- <html-parser :content="page.body" /> -->
        </coleus-article>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  head() {
    return {
      title: this.pages && this.pages.length ? this.pages[0].title : ''
    }
  },
  apollo: {
    pages: {
      query: require('~/graphql/page.gql'),
      prefetch: ({ route }) => ({ page: route.params.page }),
      variables() {
        return { page: this.$route.params.page }
      }
    }
  }
}
</script>