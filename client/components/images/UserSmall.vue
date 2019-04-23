<template>
  <span>
    <img :src="user.small" class="hidden">
    <no-ssr>
      <progressive-img
        :src="user.xsmall"
        :placeholder="user.placeholder"
        :fallback="user.photo_url"
        :aspect-ratio="1"
        class="rounded float-right"
        style="width: 64px; height: 64px;"
      />
    </no-ssr>
  </span>
</template>

<script>
export default {
  name: 'UserSmallImage',

  props: {
    user: {
      type: Object,
      default: () => ({})
    }
  }
}
</script>
