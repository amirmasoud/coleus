webpackJsonp([13],{"4lTM":function(e,l,n){"use strict";Object.defineProperty(l,"__esModule",{value:!0});var o=n("iSEV"),t=n("tlQw"),r=n.n(t),u={data(){return{slug:this.$route.params.slug,book:null}},apollo:{book:{query:r.a`query Book($slug: String) {
        book(slug: $slug) {
          id
          pages {
            id
            title
          }
        }
      }
      `,variables(){return{slug:this.slug}}}}},s=n("K1/g"),a=Object(s.a)(u,o.render,o.staticRenderFns,!1,null,null,null);a.options.__file="index.vue";l.default=a.exports},iSEV:function(e,l){throw new Error('Module parse failed: Unexpected token (2:0)\nYou may need an appropriate loader to handle this file type.\n| \n| <b-row>\n|   <b-col cols="12"\n|          sm="4"')}});
//# sourceMappingURL=13.19f49877d91cd0ed1401.js.map