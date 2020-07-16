<template>
  <div
    class="min-h-screen w-full lg:static lg:max-h-full lg:overflow-visible lg:w-3/4"
  >
    <div class="lg:mx-0 flex flex-col-reverse lg:flex-row">
      <div
        class="lg:min-h-screen w-full px-4 lg:static lg:overflow-visible lg:max-h-full lg:w-3/4"
      >
        <div v-if="pages && pages.length">
          <coleus-article class="mt-2">
            <p class="py-2 text-gray-500 font-light">
              <coleus-breadcrumb-element
                :user-username="pages[0].book.book_users[0].user.username"
                :user-name="pages[0].book.book_users[0].user.name"
                :book-title="pages[0].book.title"
              />
            </p>
            <h1 class="text-4xl mb-10 border-indigo-600">
              {{ pages[0].title }}
            </h1>
            <div class="flex flex-wrap content-wrapper sm:mb-20">
              <div
                v-for="block in pages[0].blocks"
                :key="block.id"
                class="w-full py-2"
                :class="{
                  'md:w-1/2': ['m-1/2', 't-1/2'].includes(block.type),
                  'leading-loose': ['p-full'].includes(block.type)
                }"
                v-html="block.content"
              ></div>
            </div>
          </coleus-article>
        </div>
        <template v-else>
          <div class="container">
            <coleus-spinner class="w-8 mx-auto my-4" />
          </div>
        </template>
      </div>
      <div class="w-full lg:w-1/4 order-first lg:order-last">
        <div dir="ltr" class="mx-auto max-w-xs">
          <div id="container-d9c0e25cb60646528947b767ad1840ef"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    page: null,
    parent: null
  }),
  mounted() {
    this.$root.$on('content-changed', (page, parent) => {
      this.page = page
      this.parent = parent
    })
  },
  head() {
    const title = this.pages && this.pages.length ? this.pages[0].title : ''
    const description = 'مطالعه صفحه ' + title
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
      ],
      script: [
        {
          src:
            '//pl15515995.passtechusa.com/d9c0e25cb60646528947b767ad1840ef/invoke.js',
          async: 'async',
          'data-cfasync': false
        }
      ]
    }
  },
  computed: {
    currentPage() {
      console.log(this.$route.params.page)
      return parseInt(this.page || this.$route.params.page)
    }
  },
  apollo: {
    pages: {
      query: require('~/graphql/page.gql'),
      prefetch: ({ route }) => ({ page: route.params.page }),
      variables() {
        return { page: this.currentPage }
      },
      update(data) {
        if (data.pages.length) {
          return data.pages
        } else {
          this.$nuxt.error({
            message: 'صفحه مورد نظر یافت نشد',
            statusCode: 404
          })
        }
      },
      skip() {
        const skip =
          !Number.isInteger(this.currentPage) || this.currentParent <= 0

        if (skip) {
          this.$root.$emit('graphql-error')
        }

        return skip
      }
    }
  }
}
</script>

<style lang="scss">
.content-wrapper .w-full:nth-child(2n) {
  @apply pb-6;
}
</style>
