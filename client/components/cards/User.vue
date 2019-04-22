<template>
  <NuxtLink
    :to="{ name: 'profile', params: { username: user.username }}"
    class="no-underline text-deep-space-sparkle hover:outer-space"
  >
    <div
      class="max-w-sm rounded overflow-hidden border border-x11-grey hover:border-silver-chalice transition bg-alabster hover:bg-almond"
    >
      <img :src="user.cover" class="hidden">
      <no-ssr>
        <progressive-img
          :src="user.small || user.photo_url"
          :placeholder="user.placeholder"
          :aspect-ratio="1"
        />
      </no-ssr>
      <div class="px-4 py-2">
        <div class="text-normal mb-1 py-1">{{ user.name }}</div>
      </div>
    </div>
  </NuxtLink>
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
