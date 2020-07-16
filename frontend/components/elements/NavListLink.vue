<template>
  <li>
    <nuxt-link class="block" :to="to" exact>
      <slot></slot>
    </nuxt-link>
  </li>
</template>

<script>
export default {
  props: {
    to: {
      type: Object,
      default: () => {}
    }
  }
}
</script>
