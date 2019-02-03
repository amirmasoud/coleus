<template>
  <div class="d-flex justify-content-around text-center mt-2 border-top border-bottom py-2">
    <b-col>{{ user.books_count }}<br /><small class="text-muted">{{ $t('books') }}</small></b-col>
    <b-col>{{ user.followers_count }}<br /><small class="text-muted">{{ $t('followers') }}</small></b-col>
    <b-col>{{ user.following_count }}<br /><small class="text-muted">{{ $t('following') }}</small></b-col>
  </div>
</template>

<script>
export default {
  name: 'social-status-bar',

  props: {
    user: Object
  }
}
</script>
