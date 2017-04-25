Vue.component('author-extra', require('../components/authors/Extra.vue'));

const create = new Vue({
    el: '#author',
    data: {
        email: '',
        name: $('#name').val()
    },
    computed: {
        suggestEmail: function () {
            return this.name.replace(' ', '_')
                            .replace('@', '_')
                            .toLowerCase() + '@example.com'
        }
    },
    methods: {
        use: function () {
            this.email = this.suggestEmail
        }
    }
});
