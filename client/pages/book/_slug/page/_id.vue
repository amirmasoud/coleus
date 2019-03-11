<template>
  <div class="mb-5 mx-2">
    <div class="reading-container rounded overflow-hidden border border-grey-light bg-white">
      <div class="px-1lg:px-6 py-4">
        <template v-if="page && !loading">
          <div class="font-bold text-xl mb-8 mt-4 px-4">{{ page.title }}</div>
          <div class="text-grey-darkest text-base leading-loose flex flex-wrap" v-html="page.content"></div>
        </template>
        <oval-loader v-else class="mb-4" />
      </div>
    </div>
    <div class="flex">
      <div v-if="page && !loading && page.next" class="flex-1">
        <NuxtLink
          :class="{'ml-1': page && !loading && page.prev}"
          class="block text-right rounded overflow-hidden border border-grey-light bg-white lg:px-8 px-2 py-4 mt-2 h-full no-underline text-black hover:shadow transition"
          :to="{ name: 'book-slug-page-id', params: { slug: $route.params.slug, id: page.next }}"
        >
          {{ page.next_title }} <br>
          <small class="font-light block mt-2 text-grey-darkest">
            {{ $t('next') }}
          </small>
        </NuxtLink>
      </div>
      <div v-if="page && !loading && page.prev" class="flex-1">
        <NuxtLink
          :class="{'mr-1': page && !loading && page.next}"
          class="block text-left rounded overflow-hidden border border-grey-light bg-white lg:px-8 px-2 py-4 mt-2 h-full no-underline text-black hover:shadow transition"
          :to="{ name: 'book-slug-page-id', params: { slug: $route.params.slug, id: page.prev }}"
        >
          {{ page.prev_title }} <br>
          <small class="font-light block mt-2 text-grey-darkest">
            {{ $t('prev') }}
          </small>
        </NuxtLink>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  head() {
    return { title: this.$t('read_book') }
  },

  data: () => ({
    loading: false
  }),

  apollo: {
    page: {
      query: require('~/graphql/page.gql'),
      prefetch: ({ route }) => ({
        slug: route.params.slug,
        id: route.params.id
      }),
      variables() {
        return {
          slug: this.$route.params.slug,
          id: this.$route.params.id
        }
      },
      watchLoading(isLoading, countModifier) {
        this.loading = isLoading
      }
    }
  },

  methods: {
    loaded() {
      // return process.client ? !this.loading : (this.page || false)
    }
  }
}
</script>

<style>
.col-12 {
  -webkit-box-flex: 0;
  -ms-flex: 0 0 100%;
  flex: 0 0 100%;
  max-width: 100%;
  width: 100%;
}
.col-md-6 {
  position: relative;
  width: 100%;
  min-height: 1px;
  flex-grow: 1;
}
.col-md-6,
.col-12 {
  padding: 0 15px;
}
@media (min-width: 768px) {
  .col-md-6 {
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
  }
}
</style>
