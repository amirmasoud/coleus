<template>
  <div class="mb-5">
    <div class="reading-container rounded overflow-hidden border border-grey-light bg-white">
      <div class="px-6 py-4">
        <template v-if="page">
          <div class="font-bold text-xl mb-8 mt-4 px-4">{{ page.title }}</div>
          <div class="text-grey-darker text-base leading-loose flex flex-wrap" v-html="page.content"></div>
        </template>
        <oval-loader v-else />
      </div>
    </div>
    <div class="flex">
      <div class="w-1/2">
        <div v-if="page && page.next">
          <NuxtLink
            class="block text-right rounded overflow-hidden border border-grey-light bg-white px-8 py-4 mt-2 ml-1 no-underline text-black hover:shadow transition"
            :to="{ name: 'book-slug-page-id', params: { slug: $route.params.slug, id: page.next }}"
          >
            <fa icon="angle-double-right" fixed-width /> {{ page.next_title }} <br>
            <small class="font-light block mt-2 pr-8">
              {{ $t('next') }}
            </small>
          </NuxtLink>
        </div>
      </div>
      <div class="w-1/2">
        <div v-if="page && page.prev">
          <NuxtLink
            class="block text-left rounded overflow-hidden border border-grey-light bg-white px-8 py-4 mt-2 mr-1 no-underline text-black hover:shadow transition"
            :to="{ name: 'book-slug-page-id', params: { slug: $route.params.slug, id: page.prev }}"
          >
            {{ page.prev_title }} <fa icon="angle-double-left" fixed-width /> <br>
            <small class="font-light block mt-2 pl-8">
              {{ $t('prev') }}
            </small>
          </NuxtLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  head() {
    return { title: this.$t('read_book') }
  },

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
      }
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
