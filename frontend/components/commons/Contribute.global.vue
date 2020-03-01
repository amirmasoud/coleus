<template>
  <div class="pt-4">
    <div class="clearfix">
      <span v-if="prevLink">← <negarin-link :to="baseLink + prevLink.to">{{ prevLink.name }}</negarin-link></span>
      <span v-if="nextLink" class="inline-block float-right"><negarin-link :to="baseLink + nextLink.to">{{ nextLink.name }}</negarin-link> →</span>
    </div>
    <div class="pt-3 mt-6 border-t border-gray-300">
      <h3 v-if="contributors.length" class="my-2">Contributors</h3>
      <div v-if="contributors.length">
        <a v-for="contributor of contributors" :key="contributor.author" :href="`https://github.com/${contributor.author}`" rel="noopener" target="_blank" class="text-negarin-gray rounded overflow-hidden rounded-md inline-flex mb-2 mr-2 border hover:bg-gray-200">
          <img :alt="contributor.author" :src="`https://github.com/${contributor.author}.png?size=32`" class="h-8">
          <span class="inline-block px-2 leading-loose">{{ contributor.author }}</span>
        </a>
      </div>
      <p v-if="docLink" class="text-gray-700 pt-1 mb-3">{{ $store.state.lang.guide.contribute }} <a :href="docLink" target="_blank" rel="noopener">{{ $store.state.lang.guide.edit_on_github }}</a></p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    docLink: {
      type: String,
      required: false,
      default: ''
    },
    contributors: {
      type: Array,
      required: false,
      default: () => []
    }
  },
  computed: {
    baseLink () {
      return '/' + this.$route.params.section
    },
    list () {
      return this.$store.state.menu[this.$route.params.section].reduce((links, section) => links.concat(section.links), [])
    },
    lastPathPart () {
      return this.$route.path.replace(/\/$/, '').split('/')[2] || ''
    },
    prevLink () {
      const index = this.list.findIndex(link => (link.to || '/') === `/${this.lastPathPart}`)

      return this.list[index - 1] || null
    },
    nextLink () {
      const index = this.list.findIndex(link => (link.to || '/') === `/${this.lastPathPart}`)

      return this.list[index + 1] || null
    }
  }
}
</script>
