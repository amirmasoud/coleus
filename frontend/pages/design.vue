<template>
  <neg-container class="pt-16">
    <div class="flex flex-wrap justify-between mb-8">
      <div class="lg:w-6/12 lg:text-left text-center p-4 sm:p-0">
        <h1 class="text-3xl xl:text-4xl text-coleus-gray font-medium leading-normal mb-6 lg:pt-4">
          Nuxt<span class="text-coleus-lightgreen">JS</span> Design
        </h1>
        <h3 class="xl:text-lg text-gray-600 font-medium leading-relaxed mb-6">
          NuxtJS is an MIT licensed open source project and completely free to use.<br>
          You can freely use our logos as long as you mention NuxtJS and link to nuxtjs.org.
        </h3>
      </div>
      <i-design class="w-2/3 mx-auto lg:mx-0 lg:w-5/12 lg:-mt-8"/>
    </div>
    <div class="flex flex-wrap -mx-4">
      <div class="w-full lg:w-1/2 p-4">
        <section class="bg-gray-100 rounded p-6">
          <h2 class="text-2xl text-coleus-gray font-medium leading-normal mb-6">
            Light theme
          </h2>
          <figure class="rounded hover:bg-gray-200">
            <img src="/logos/nuxt.svg" alt="coleus-logo">
            <figcaption><a href="/logos/nuxt.svg" target="_blank" rel="noopener">nuxt.svg</a> / <a href="/logos/coleus-square.svg" target="_blank" rel="noopener">coleus-square.svg</a></figcaption>
          </figure>
          <figure class="rounded hover:bg-gray-200 mt-6">
            <img src="/logos/coleus-icon.png" srcset="/logos/coleus-icon@2x.png 2x" alt="coleus-logo">
            <figcaption><a href="/logos/coleus-icon.png" target="_blank" rel="noopener">coleus-icon.png</a></figcaption>
            <span class="dimensions">512 x 512</span>
          </figure>
          <figure class="rounded hover:bg-gray-200 mt-6">
            <img src="/logos/coleus-emoji.png" srcset="/logos/coleus-emoji@2x.png 2x" alt="coleus-logo">
            <figcaption><a href="/logos/coleus-emoji.png" target="_blank" rel="noopener">coleus-emoji.png</a></figcaption>
            <span class="dimensions">128 x 128</span>
          </figure>
          <figure class="rounded hover:bg-gray-200 mt-6">
            <img src="/logos/nuxtjs-typo.svg" alt="coleus-logo">
            <figcaption><a href="/logos/nuxtjs-typo.svg" target="_blank" rel="noopener">nuxtjs-typo.svg</a></figcaption>
          </figure>
          <figure class="rounded hover:bg-gray-200 mt-6">
            <img src="/logos/built-with-nuxt.svg" alt="built-with-coleus-logo">
            <figcaption><a href="/logos/built-with-nuxt.svg" target="_blank" rel="noopener">built-with-nuxt.svg</a></figcaption>
          </figure>
        </section>
      </div>
      <div class="w-full lg:w-1/2 p-4">
        <section class="bg-coleus-gray rounded p-6">
          <h2 class="text-2xl text-white font-medium leading-normal mb-6">
            Dark theme
          </h2>
          <figure class="rounded hover:bg-gray-800">
            <img src="/logos/coleus-white.svg" alt="coleus-logo">
            <figcaption><a href="/logos/coleus-white.svg" target="_blank" rel="noopener">coleus-white.svg</a> / <a href="/logos/coleus-square-white.svg" target="_blank" rel="noopener">coleus-square-white.svg</a></figcaption>
          </figure>
          <figure class="rounded hover:bg-gray-800 mt-6">
            <img src="/logos/coleus-icon-white.png" srcset="/logos/coleus-icon-white@2x.png 2x" alt="coleus-logo">
            <figcaption><a href="/logos/coleus-icon-white.png" target="_blank" rel="noopener">coleus-icon-white.png</a></figcaption>
            <span class="dimensions">512 x 512</span>
          </figure>
          <figure class="rounded hover:bg-gray-800 mt-6">
            <img src="/logos/coleus-emoji-white.png" srcset="/logos/coleus-emoji-white@2x.png 2x" alt="coleus-logo">
            <figcaption><a href="/logos/coleus-emoji-white.png" target="_blank" rel="noopener">coleus-emoji-white.png</a></figcaption>
            <span class="dimensions">128 x 128</span>
          </figure>
          <figure class="rounded hover:bg-gray-800 mt-6">
            <img src="/logos/nuxtjs-typo-white.svg" alt="coleus-logo">
            <figcaption><a href="/logos/nuxtjs-typo-white.svg" target="_blank" rel="noopener">nuxtjs-typo-white.svg</a></figcaption>
          </figure>
          <figure class="rounded hover:bg-gray-800 mt-6">
            <img src="/logos/built-with-coleus-white.svg" alt="built-with-coleus-logo">
            <figcaption><a href="/logos/built-with-coleus-white.svg" target="_blank" rel="noopener">built-with-coleus-white.svg</a></figcaption>
          </figure>
        </section>
      </div>
    </div>
    <p class="text-center mt-8">
      You can also download our <a href="/favicon.ico" target="_blank" rel="noopener">favicon</a> or our  <a href="/logos/coleus-logos.sketch" target="_blank" rel="noopener">Sketch file</a>.
    </p>
  </neg-container>
</template>

<script>
import iDesign from '@/components/svg/fogg/design'

export default {
  transition: 'logos',
  components: {
    iDesign
  },
  head: {
    title: 'Design Resources - NuxtJS',
    meta: [
      { hid: 'description', name: 'description', content: 'Download NuxtJS design resources (SVG, icons, emoji and favicon).' },
      { name: 'og:image', content: 'https://nuxtjs.org/meta_640.png' }
    ]
  }
}
</script>

<style scoped>
figure {
  @apply relative p-4 text-center text-gray-500 table w-full;
  &:hover {
    & .dimensions {
      @apply opacity-100;
      top: 10px;
    }
  }
  & img {
    @apply inline-block;
  }
  & figcaption {
    @apply pt-4;
  }
  & .dimensions {
    @apply font-normal absolute top-0 opacity-0;
    right: 20px;
    transition-property: all;
    transition-duration: 0.3s;
  }
}
a {
  @apply text-coleus-lightgreen font-normal;
  &:hover {
    @apply underline;
  }
}
</style>
