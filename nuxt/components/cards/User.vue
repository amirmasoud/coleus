<template>
  <NuxtLink :to="{ name: 'user-username', params: { username: user.username }}" class="no-underline text-black">
    <div class="max-w-sm rounded overflow-hidden shadow-md hover:shadow-lg transition bg-white">
      <img :src="user.cover" class="hidden">
      <no-ssr>
        <progressive-img
          :src="user.small || user.photo_url"
          :placeholder="user.placeholder"
          :aspect-ratio="1"
        />
      </no-ssr>
      <div class="px-4 py-2">
        <div class="text-lg mb-1 py-1">
          {{ user.name }}
        </div>
      </div>
    </div>
  </NuxtLink>
</template>

<script>
export default {
  name: 'UserCard',

  props: {
    user: {
      type: Object
    }
  }
}
</script>
