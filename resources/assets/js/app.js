
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('owl.carousel');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('auto-complete', require('./components/Autocomplete.vue'));
Vue.component('search', require('./components/Search.vue'));

const app = new Vue({
    el: '#app',
    mounted: function() {
        let owl = $('.owl-carousel');
        owl.owlCarousel({
            rtl: true,
            nav: true,
            navText: ['<i class="fa fa-fw fa-angle-right"></i>', '<i class="fa fa-fw fa-angle-left"></i>'],
            lazyLoad: true,
            dots: false,
        });
        owl.on('mousewheel', '.owl-stage', function (e) {
            if (event.deltaX > 0) {
                owl.trigger('prev.owl');
            } else if (event.deltaX < 0) {
                owl.trigger('next.owl');
            }
        });
    },
    methods: {
      go(url) {
        window.location = url;
      }
    }
});
