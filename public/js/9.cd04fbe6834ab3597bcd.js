webpackJsonp([9],{VK4E:function(e,r){throw new Error('Module parse failed: Unexpected token (2:0)\nYou may need an appropriate loader to handle this file type.\n| \n| <div v-if="user">\n|   <b-row>\n|     <b-col cols="4" sm="2">')},mr8c:function(e,r,o){"use strict";Object.defineProperty(r,"__esModule",{value:!0});var t=o("VK4E"),n=o("tlQw"),a=o.n(n),s=o("NYxO"),l={metaInfo(){return{title:this.$t("books")}},computed:Object(s.mapGetters)({auth:"auth/user"}),data(){return{user:null,username:this.$route.params.username}},apollo:{user:{query:a.a`query FetchUserByUsername($username: String) {
          user(username: $username) {
            id,
            name,
            username,
            photo_url,
            small,
            following_count,
            followers_count,
            books_count,
            books {
              id,
              title,
              description,
              cover,
              slug,
              collaborators {
                collaboration_role,
                name,
                username,
                photo_url,
                xsmall
              }
            }
          }
        }`,variables(){return{username:this.username}}}}},u=o("K1/g"),i=Object(u.a)(l,t.render,t.staticRenderFns,!1,null,null,null);i.options.__file="profile.vue";r.default=i.exports}});
//# sourceMappingURL=9.cd04fbe6834ab3597bcd.js.map