<template>
  <span>
    <img :src="user.small" class="d-none">
    <no-ssr>
      <progressive-img
        :src="user.xsmall"
        :placeholder="user.placeholder"
        :fallback="user.photo_url"
        :aspect-ratio="1"
        class="rounded float-left img-fluid mr-4"
        style="width: 64px; height: 64px;"
      />
    </no-ssr>
  </span>
</template>

<script>
export default {
  name: 'user-small-image',

  props: ['user']
}
</script>
