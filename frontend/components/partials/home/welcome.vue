<template>
  <coleus-container>
    <div class="flex justify-between py-16 sm:py-24">
      <div class="lg:w-1/2 xl:w-6/12 text-center lg:text-left p-4 sm:p-0">
        <h1 class="text-3xl xl:text-4xl text-coleus-gray font-medium leading-normal mb-6" v-html="wordings.welcome.attrs.title" />
        <h3 class="xl:text-lg text-gray-600 font-medium leading-relaxed mb-6" v-html="wordings.welcome.body" />
        <div class="flex flex-col sm:block py-4">
          <coleus-button :to="{ name: 'section-slug', params: { section: 'guide', slug: 'installation'} }" class="sm:mr-4 py-3 px-6 text-base mb-4">
            <coleus-svg-meteor slot="icon" class="h-5 -mb-1 mr-1" />
            {{ buttonWordings.get_started }}
          </coleus-button>
          <coleus-button href="https://github.com/nuxt/nuxt.js" variant="gray" class="sm:mr-4 py-3 px-6 text-base">
            <coleus-svg-gh slot="icon" class="h-6 -mt-1 mr-1" />
            {{ buttonWordings.github_stars }}
          </coleus-button>
        </div>
      </div>
      <!-- <div class="hidden lg:block lg:w-5/12 bg-coleus-gray rounded-lg">
        <div class="">
          <div class="bg-red-500 w-3 h-3 rounded-full"></div>
          <div class="bg-orange-500 w-3 h-3 rounded-full"></div>
          <div class="bg-green-500 w-3 h-3 rounded-full"></div>
        </div>
      </div> -->
      <figure class="hidden lg:block lg:w-5/12">
        <coleus-media src="https://player.vimeo.com/video/311756540" />
        <p class="font-medium py-2 text-xs xl:text-sm text-center text-gray-600" v-html="wordings.welcome_figure.body" />
      </figure>
    </div>
  </coleus-container>
</template>

<script>
import coleusSvgMeteor from '@/components/svg/Meteor.vue'
import coleusSvgGh from '@/components/svg/Github.vue'

export default {
  components: {
    coleusSvgMeteor,
    coleusSvgGh
  },
  data () {
    return {
      wordings: this.$store.state.homepage,
      buttonWordings: this.$store.state.lang.homepage.welcome
    }
  }
}
</script>
