<template>
  <nuxt-link :to="{ name: 'profile', params: { username: user.username }}">
    <div class="card mb-2">
      <img :src="user.small" class="d-none">
      <no-ssr>
        <progressive-img
          class="card-img-top"
          :src="user.small"
          :placeholder="user.placeholder"
          :fallback="user.photo_url"
          :aspect-ratio="1"
        />
      </no-ssr>
      <div class="card-body">
        <p class="card-title">{{ user.name }}</p>
      </div>
    </div>
  </nuxt-link>
</template>

<script>
export default {
  name: 'user-card',

  props: {
    user: {
      type: Object
    }
  }
}
</script>
