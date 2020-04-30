<template>
  <span itemscope itemtype="http://schema.org/Person">
    <NuxtLink
      itemprop="url"
      :to="{ name: 'profile', params: { username: user.username }}"
      class="no-underline text-deep-space-sparkle hover:outer-space"
    >
      <div
        class="max-w-sm rounded overflow-hidden border border-x11-grey hover:border-silver-chalice transition bg-alabster hover:bg-almond"
      >
        <img itemprop="image" :src="user.small || user.photo_url" class="hidden">
        <p itemprop="description" class="hidden">{{ user.bio }}</p>
        <client-only>
          <progressive-img
            :src="user.small || user.photo_url"
            :placeholder="user.placeholder"
            :aspect-ratio="1"
          />
        </client-only>
        <div class="px-4 py-2">
          <div itemprop="name" class="text-normal mb-1 py-1">{{ user.name }}</div>
        </div>
      </div>
    </NuxtLink>
  </span>
</template>

<script>
export default {
  name: 'UserCard',

  props: {
    user: {
      type: Object,
      default: () => {}
    }
  }
}
</script>
