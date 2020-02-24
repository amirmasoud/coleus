<template>
  <span itemscope itemtype="http://schema.org/Person">
    <div class="border-b border-platinum flex flex-wrap p-2">
      <img itemprop="image" :src="user.small || user.photo_url" class="hidden">
      <p itemprop="description" class="hidden">{{ user.bio }}</p>
      <div class="w-1/10 -mb-1">
        <NuxtLink
          itemprop="url"
          :to="{ name: 'profile', params: { username: user.username }}"
        >
          <no-ssr>
            <progressive-img
              :src="user.xsmall || user.photo_url"
              :placeholder="user.placeholder"
              :aspect-ratio="1"
              class="rounded"
            />
          </no-ssr>
        </NuxtLink>
      </div>
      <div class="w-9/10 flex flex-col">
        <div class="pr-4 flex-1 mb-1">
          <h3 itemprop="name" class="font-normal mb-1 py-1">
            <NuxtLink
              itemprop="url"
              :to="{ name: 'profile', params: { username: user.username }}"
              class="no-underline text-eerie-black hover:text-dark-liver transition "
            >
              {{ user.name }}
            </NuxtLink>
          </h3>
        </div>
        <div class="pr-4 flex-1">
          <span v-for="(book, index) in user.books" :key="book.id" class="mt-4">
            <NuxtLink v-if="index < 2" :to="{ name: 'book-slug', params: { slug: book.slug } }" class="text-sm no-underline bg-alabster border border-x11-grey rounded text-deep-space-sparkle hover:text-outer-space hover:border-silver-chalice hover:bg-almond px-2 ml-1">{{ book.title }}</NuxtLink>
            <NuxtLink
              v-else-if="index === 2 && user.books.length > 1"
              itemprop="url"
              :to="{ name: 'profile', params: { username: user.username }}"
              class="text-sm no-underline text-manatee hover:text-burnt-umber px-2 ml-1 transition"
            >
              +{{ $toPersian(user.books.length - 2) }} کتاب دیگر
            </NuxtLink>
          </span>
        </div>
      </div>
    </div>
  </span>
</template>

<script>
export default {
  name: 'UserRow',

  props: {
    user: {
      type: Object,
      default: () => {}
    }
  }
}
</script>
