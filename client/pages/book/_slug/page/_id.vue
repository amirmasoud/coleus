<template>
  <div class="mb-5 mx-2">
    <div>
      <div class="px-1lg:px-6 py-4">
        <template v-if="!loading">
          <div class="font-bold pb-4 px-4">
            {{ page.title }}
          </div>
          <div class="text-grey-darkest text-base leading-loose flex flex-wrap" v-html="page.content" />
        </template>
        <oval-loader v-else class="mb-4" />
      </div>
    </div>
    <div class="flex mt-4">
      <div v-if="page && !loading && page.next" v-shortkey="['arrowright']" class="flex-1" @shortkey="next()">
        <NuxtLink
          :class="{'ml-1': page && !loading && page.prev}"
          class="block text-right rounded overflow-hidden border border-grey-light bg-white lg:px-8 px-2 py-4 mt-2 h-full no-underline text-black hover:shadow transition"
          :to="{ name: 'book-slug-page-id', params: { slug: $route.params.slug, id: page.next }}"
        >
          <strong>{{ page.next_title }}</strong> <br>
          <small class="block mt-2 text-blue-light">
            {{ $t('next') }}
          </small>
        </NuxtLink>
      </div>
      <div v-if="page && !loading && page.prev" v-shortkey="['arrowleft']" class="flex-1" @shortkey="prev()">
        <NuxtLink
          :class="{'mr-1': page && !loading && page.next}"
          class="block text-left rounded overflow-hidden border border-grey-light bg-white lg:px-8 px-2 py-4 mt-2 h-full no-underline text-black hover:shadow transition"
          :to="{ name: 'book-slug-page-id', params: { slug: $route.params.slug, id: page.prev }}"
        >
          <strong>{{ page.prev_title }}</strong> <br>
          <small class="block mt-2 text-blue-light">
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
    next() {
      if (this.page.next) {
        this.$router.push({
          name: 'book-slug-page-id',
          params: {
            slug: this.$route.params.slug,
            id: this.page.next
          }
        })
      }
    },

    prev() {
      if (this.page.prev) {
        this.$router.push({
          name: 'book-slug-page-id',
          params: {
            slug: this.$route.params.slug,
            id: this.page.prev
          }
        })
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
