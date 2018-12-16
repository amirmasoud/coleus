<template>
  <div v-if="err.has(field)" class="help-block invalid-feedback" v-html="err.get(field)"/>
</template>

<script>
export default {
  name: 'has-error',

  props: {
    err: {
      type: Object,
      required: true
    },

    field: {
      type: String,
      required: true
    }
  }
}
</script>
