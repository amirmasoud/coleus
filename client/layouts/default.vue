<template>
  <div dir="rlt" style="direction: rtl;">
    <navbar />

    <div class="container mx-auto w-full h-full max-w-3xl mt-16">
      <div class="flex flex-wrap">
        <div class="md:w-1/8 border-l border-gainsboro pt-4">
          <nav role="navigation">
            <ol class="list-reset">
              <li class=" youarehere">
                <NuxtLink :to="{ name: 'index' }" class="block px-2 py-2 bg-smoky-black border-l-4 border-sweet-brown font-bold text-smoky-black-dark text-sm no-underline">
                  خانه
                </NuxtLink>
              </li>
            </ol>
          </nav>
        </div>
        <div class="md:w-5/8">
          <Nuxt />
        </div>
        <div class="md:w-1/4 p-4 border-r border-gainsboro h-screen">
          <!-- <div id="hot-network-questions">
              <h4 class="font-normal my-2">
                  <a href="#" class="no-underline text-charleston-green">
                      صفحات داغ
                  </a>
              </h4>
              <ul class="list-reset">
                <li>
                  <a href="#">
                    Examples where existence is harder than evaluation
                  </a>
                </li>
              </ul>
              <a href="#" class="show-more js-show-more js-gps-track" data-gps-track="posts_hot_network.click({ item_type:3, location:8 })">
                  more hot questions
              </a>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from '~/components/Navbar'

export default {
  components: { Navbar },

  mounted() {
    if (process.client && window) {
      window.history.scrollRestoration = 'auto'
    }
  }
}
</script>
