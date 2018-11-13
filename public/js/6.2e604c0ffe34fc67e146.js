webpackJsonp([6],{FS3R:function(e,t){throw new Error('Module parse failed: Unexpected token (2:0)\nYou may need an appropriate loader to handle this file type.\n| \n| <b-row v-if="users">\n|   <b-col cols="6"\n|          sm="4"')},kFo4:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var o=n("FS3R"),r=(n("mtWM"),n("tlQw")),l=n.n(r),s={metaInfo(){return{title:this.$t("home")}},data:()=>({title:window.config.appName,users:null}),apollo:{users:{query:l.a`query FetchUsers {
        users(sticky: true) {
          id,
          name,
          small,
          photo_url,
          username
        }
      }`}}},a=n("K1/g"),u=Object(a.a)(s,o.render,o.staticRenderFns,!1,null,null,null);u.options.__file="welcome.vue";t.default=u.exports}});
//# sourceMappingURL=6.2e604c0ffe34fc67e146.js.map