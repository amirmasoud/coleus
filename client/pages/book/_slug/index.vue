<template>
  <div v-if="book">
    <div class="py-2 mx-4 border-b border-platinum">
      <div class="flex justify-start">
        <user-small-image :user="book.collaborators[0]"/>
        <div class="mr-2 float-right">
          <h4>{{ book.collaborators[0].name }}</h4>
          <small>@{{ book.collaborators[0].username }}</small>
        </div>
      </div>
    </div>

    <div class="flex flex-wrap content-start mx-4 py-2 border-b border-platinum">
      <div class="w-full sm:w-1/3 md:w-1/3 lg:w-1/4 xl:w-1/6">
        <book-card :book="book"/>
        <NuxtLink
          :to="{ name: 'book-slug-page-id', params: { slug: book.slug, id: book.start }}"
          class="no-underline"
        >
          <button
            class="w-full active:bg-prune active:shadow-btn-active active:border-caput-mortuum bg-sweet-brown border border-burnt-umber mt-4 py-4 text-white font-normal text-sm rounded shadow-btn hover:bg-vivid-auburn hover:shadow-btn-hover focus:outline-none focus:shadow-outline focus:shadow-btn-focus mb-4"
          >{{ `خواندن ${this.book.title} ${this.book.collaborators[0].name}` }}</button>
        </NuxtLink>
      </div>
      <div class="w-full sm:w-2/3 md:w-2/3 lg:w-3/4 xl:w-5/6 pr-2">
        <div
          :class="{'max-h-64 overflow-hidden': !expanded}"
          class="leading-loose"
        >{{ book.description }}</div>
        <div class="flex items-stretch bg-anti-flash-white h-8 mt-2">
          <button
            class="self-auto flex-1 font-normal text-sm rounded text-sweet-brown text-center px-4 border-t-0 focus:outline-none focus:shadow-btn-focus"
            @click.prevent="toggle"
          >{{ `توضیحات ${expanded ? 'کمتر' : 'بیشتر'} درباره‌ی ${this.book.title} ${this.book.collaborators[0].name}` }} {{ expanded ? '▲' : '▼' }}</button>
        </div>
      </div>
    </div>
  </div>
  <div v-else>Wrong</div>
</template>

<script>
import BookCard from '~/components/cards/Book'
import UserSmallImage from '~/components/images/UserSmall'

export default {
  head() {
    return {
      title: this.book
        ? `${this.book.title} ${this.book.collaborators[0].name}`
        : ''
    }
  },

  components: {
    UserSmallImage,
    BookCard
  },

  data: () => ({
    expanded: false
  }),

  apollo: {
    book: {
      query: require('~/graphql/book/single.gql'),
      prefetch: ({ route }) => ({ slug: route.params.slug }),
      variables() {
        return { slug: this.$route.params.slug }
      }
    }
  },

  methods: {
    toggle() {
      this.expanded = !this.expanded
    }
  }
}
</script>
