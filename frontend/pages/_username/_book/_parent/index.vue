<template>
  <coleus-container>
    <div class="container">
      <coleus-spinner class="mx-auto my-4 bg-white rounded-full p-1 shadow" />
      <p class="text-center">در حال انتقال...</p>
    </div>
  </coleus-container>
</template>

<script>
export default {
  apollo: {
    pages: {
      query: require('~/graphql/child.gql'),
      prefetch: ({ route }) => ({ parent: route.params.parent }),
      variables() {
        return { parent: this.$route.params.parent }
      },
      result({ data }) {
        if (data.pages && data.pages.length) {
          this.$router.push({
            name: 'username-book-parent-page',
            params: {
              username: this.$route.params.username,
              book: this.$route.params.book,
              parent: this.$route.params.parent,
              page: data.pages[0].id
            }
          })
        } else {
          this.$router.push({ name: 'index' })
        }
      }
    }
  }
}
</script>