<template>
  <div class="flex border-t border-b mt-2 mx-4">
    <div class="flex-1 text-grey-darker text-center px-4 py-2 m-2">
      <strong>{{ user.books_count }}</strong><br /><small class="text-muted">{{ $t('books') }}</small>
    </div>
    <div class="flex-1 text-grey-darker text-center px-4 py-2 m-2">
      <strong>{{ user.followers_count }}</strong><br /><small class="text-muted">{{ $t('followers') }}</small>
    </div>
    <div class="flex-1 text-grey-darker text-center px-4 py-2 m-2">
      <strong>{{ user.following_count }}</strong><br /><small class="text-muted">{{ $t('following') }}</small>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SocialStatusBar',

  props: {
    user: Object,
    default: () => ({})
  }
}
</script>
