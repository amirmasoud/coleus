<template>
  <div class="flex bg-black fixed pin-t pin-x z-100 h-16 items-center">
    <div class="w-full max-w-3xl mx-auto px-6 relative">
      <div class="flex items-center mx-6">

        <div class="pl-6 pr-6 lg:pr-8">
          <div class="flex items-center">
            <a href="/" class="block lg:mr-4">
              <svg class="w-8 h-8 lg:w-12 lg:h-12 block" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg"><path d="M13.5 11.1C15.3 3.9 19.8.3 27 .3c10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05zM0 27.3c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05z" transform="translate(5 16)" fill="url(#logoGradient)" fill-rule="evenodd"></path></svg>
            </a>
          </div>
        </div>


          <div class="w-full lg:px-6 xl:px-12">
            <div class="relative">
              <input id="docsearch" class="h-8 transition focus:outline-0 border border-transparent focus:bg-white focus:text-black focus:border-grey text-grey-dark rounded bg-grey-darkest py-2 pr-4 pl-10 block w-full appearance-none leading-normal" type="text" placeholder="جستجو یا پرش به...">
              <div class="pointer-events-none absolute pin-y pin-l pl-3 flex items-center">
                <svg class="fill-current pointer-events-none text-grey-dark w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/></svg>
              </div>
            </div>
          </div>

          <div id="sidebar-open" class="flex px-6 items-center lg:hidden">
            <svg class="fill-current w-4 h-4 cursor-pointer text-grey" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
          </div>

          <div id="sidebar-close" class="hidden flex px-6 items-center lg:hidden">
            <svg class="fill-current w-4 h-4 cursor-pointer text-grey" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
          </div>
      </div>
    </div>
  </div>
</template>
