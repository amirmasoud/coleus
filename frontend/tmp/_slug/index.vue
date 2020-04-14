<template>
  <div v-if="book">
    <div class="py-2 mx-4 border-b border-platinum">
      <div class="flex justify-start">
        <user-small-image :user="book.collaborators[0]" />
        <div class="mr-2 float-right">
          <h4>{{ book.collaborators[0].name }}</h4>
          <small>@{{ book.collaborators[0].username }}</small>
        </div>
      </div>
    </div>

    <div class="flex flex-wrap content-start mx-4 py-2 border-b border-platinum">
      <div class="w-full md:w-1/4">
        <book-card :book="book" />
        <NuxtLink
          :to="{ name: 'book-slug-page-id', params: { slug: book.slug, id: book.start }}"
          class="no-underline"
        >
          <button
            class="w-full active:bg-prune active:shadow-btn-active active:border-caput-mortuum bg-sweet-brown border border-burnt-umber mt-4 py-4 px-2 text-white font-normal text-sm rounded shadow-btn hover:bg-vivid-auburn hover:shadow-btn-hover focus:outline-none focus:shadow-outline focus:shadow-btn-focus mb-4"
          >
            خواندن
          </button>
        </NuxtLink>
      </div>
      <div class="w-full md:w-3/4 pr-2">
        <div
          :class="{'max-h-64 overflow-hidden': !expanded}"
          class="leading-loose"
        >
          {{ book.description }}
        </div>
        <div class="flex items-stretch bg-anti-flash-white h-8 mt-2">
          <button
            class="self-auto flex-1 font-normal text-sm rounded text-sweet-brown text-center px-4 border-t-0 focus:outline-none focus:shadow-btn-focus"
            @click.prevent="toggle"
          >
            {{ `توضیحات ${expanded ? 'کمتر' : 'بیشتر'} درباره‌ی ${book.title} ${book.collaborators[0].name}` }} {{ expanded ? '▲' : '▼' }}
          </button>
        </div>
      </div>
    </div>

    <div class="flex flex-wrap mt-4">
      <h4 class="flex-1 my-4 mr-4 inline-block">فهرست {{ book.title }} ({{ $toPersian(book.pages.filter(item => { return item.title.includes(query) }).length) }} مورد)</h4>
      <input
        v-model="query"
        class="flex-1 appearance-none inline max-w-full bg-floral-white text-grey-darker border border-black-dark rounded py-2 px-4 mx-4 mb-5 leading-tight focus:outline-none focus:bg-white focus:border-grey"
        id="grid-last-name"
        type="search"
        placeholder="جستجو در فهرست"
      />
    </div>
    <div v-if="!book.pages.filter(item => { return item.title.includes(query) }).length" dir="rlt" style="direction: rtl;" class="mt-12 mx-4 text-center">
      موردی که شامل «{{ query }}» باشد یافت نشد.
      <p class="cursor-pointer text-sweet-brown hover:bittersweet-shimmer mt-4" @click="query = ''">نمایش همه فهرست «{{ book.title }}» از «{{ book.collaborators[0].name }}»</p>
    </div>
    <div v-else class="max-h-screen overflow-y-scroll book-contents mx-4">
      <no-ssr>
        <DynamicScroller
          :items="book.pages.filter(item => { return item.title.includes(query) })"
          :prerender="100"
          :min-item-size="54"
          class="h-full book-contents"
        >
          <template slot-scope="{ item, index, active }">
            <DynamicScrollerItem
              :item="item"
              :active="active"
              :size-dependencies="[ item.title ]"
              :data-index="index"
            >
              <strong
                v-if="item.is_header"
                class="block py-2 px-4 mb-1 text-davys-grey"
              >{{ item.title }}</strong>
              <NuxtLink
                v-else
                class="no-underline text-davys-grey block py-2 px-2 hover:text-smoky-black-dark"
                :class="{ 'font-bold border-l-4 border-sweet-brown text-smoky-black-dark bg-smoky-black': item.id == $route.params.id }"
                :to="{ name: 'book-slug-page-id', params: { slug: $route.params.slug, id: item.id }}"
              >
                {{ item.title }}
              </NuxtLink>
            </DynamicScrollerItem>
          </template>
        </DynamicScroller>
      </no-ssr>
    </div>

  </div>
  <oval-loader v-else />
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
    expanded: false,
    query: ''
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

<style scoped>
.book-contents {
  direction: ltr;
  text-align: center;
}
.book-contents a {
  direction: rtl !important;
  text-align: right;
}
.book-contents::-webkit-scrollbar {
  width: 0.3rem;
  background-color: #d6d9dc;
}
.book-contents::-webkit-scrollbar-thumb {
  background-color: #ae3737;
}
</style>
