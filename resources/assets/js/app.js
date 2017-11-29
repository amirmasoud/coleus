
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
    data() {
      return {
        fontSize: 14,
        lineHeight: 1.6,
        width: 640,
        dark: false,
        sepia: false,
        show: true
      }
    },
    mounted: function() {
        let owl = $('.owl-carousel');
        $('[data-toggle="tooltip"]').tooltip();
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
      },
      increaseFontSize() {
        if (this.fontSize < 30) {
            this.fontSize += 2;
        }
      },
      decreaseFontSize() {
        if (this.fontSize > 10) {
            this.fontSize -= 2;
        }
      },
      increaseLineHeight() {
        if (this.lineHeight < 4.1) {
            this.lineHeight += 0.5;
        }
      },
      decreaseLineHeight() {
        if (this.lineHeight > 1.6) {
            this.lineHeight -= 0.5;
        }
      },
      increaseWidth() {
        if (this.width < 1140) {
            this.width += 50;
        }
      },
      decreaseWidth() {
        if (this.width > 500) {
            this.width -= 50;
        }
      },
      goDark() {
        this.show  = false;
        this.sepia = false;
        this.dark  = true;
        $( document ).ready(function() {
            $('body').css("background-color", "#333333");
            $('body').css("color", "#eeeeee !important");
        });
      },
      goSepia() {
        this.show  = false;
        this.sepia = true;
        this.dark  = false;
        $( document ).ready(function() {
            $('body').css("background-color", "#f4ecd8");
            $('body').css("color", "#5b4636 !important");
        });
      },
      goLight() {
        this.show  = false;
        this.sepia = false;
        this.dark  = false;
        $( document ).ready(function() {
            $('body').css("background-color", "#f5f8fa");
            $('body').css("color", "#5a5a5a !important");
        });
      },
    }
});
