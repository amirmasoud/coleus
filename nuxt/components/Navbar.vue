<template>
  <div class="flex bg-black fixed pin-t pin-x z-100 h-16 items-center">
    <div class="w-full max-w-3xl relative mx-auto px-6">
      <div class="flex items-center">
        <div class="lg:w-1/4 xl:w-1/5 mr-3">
          <div class="flex justify-start items-center">
            <a href="/" class="flex lg:ml-4">
              <img class="self-center" src="/images/favicon-32x32.png" alt="Logo">
            </a>
          </div>
        </div>
        <div class="flex flex-grow items-center lg:w-3/4 xl:w-4/5">
          <div id="sidebar-open" class="flex px-6 items-center lg:hidden">
            <svg class="fill-current w-4 h-4 cursor-pointer text-grey" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
          </div>
          <div id="sidebar-close" class="hidden flex px-6 items-center lg:hidden">
            <svg class="fill-current w-4 h-4 cursor-pointer text-grey" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
          </div>
          <div class="w-full lg:px-6 lg:w-3/4 xl:px-12">
            <div class="relative">
              <input id="docsearch" class="h-8 transition focus:outline-0 border border-transparent focus:bg-white focus:border-grey-light placeholder-grey-darkest rounded bg-grey-lighter py-2 pr-4 pl-10 block w-full appearance-none leading-normal" type="text" placeholder="Search the docs (Press &quot;/&quot; to focus)">
              <div class="pointer-events-none absolute pin-y pin-l pl-3 flex items-center">
                <svg class="fill-current pointer-events-none text-grey-dark w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/></svg>
              </div>
            </div>
          </div>
          <div class="hidden lg:block lg:w-1/4">
            <div class="flex justify-end items-center text-grey">
              <a class="block flex items-center no-underline text-white hover:text-grey-darker mr-6" href="https://github.com/tailwindcss/tailwindcss">
                {{ $t('login') }}
              </a>
              <a class="block flex items-center no-underline text-white hover:text-grey-darker mr-6" href="https://twitter.com/tailwindcss">
                {{ $t('register') }}
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
