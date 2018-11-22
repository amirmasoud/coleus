webpackJsonp([10],{mr8c:function(t,s,e){"use strict";Object.defineProperty(s,"__esModule",{value:!0});var a,l,r=e("tlQw"),o=e.n(r),n=e("NYxO"),c=(a=["query FetchUserByUsername($username: String) {\n          user(username: $username) {\n            id,\n            name,\n            username,\n            photo_url,\n            xsmall,\n            placeholder,\n            following_count,\n            followers_count,\n            books_count,\n            books {\n              id,\n              title,\n              description,\n              cover,\n              placeholder,\n              slug,\n            }\n          }\n        }"],l=["query FetchUserByUsername($username: String) {\n          user(username: $username) {\n            id,\n            name,\n            username,\n            photo_url,\n            xsmall,\n            placeholder,\n            following_count,\n            followers_count,\n            books_count,\n            books {\n              id,\n              title,\n              description,\n              cover,\n              placeholder,\n              slug,\n            }\n          }\n        }"],Object.freeze(Object.defineProperties(a,{raw:{value:Object.freeze(l)}})));var u={metaInfo:function(){return{title:this.$t("books")}},computed:Object(n.mapGetters)({auth:"auth/user"}),data:function(){return{user:null,username:this.$route.params.username}},apollo:{user:{query:o()(c),variables:function(){return{username:this.username}}}}},i={render:function(){var t=this,s=t.$createElement,e=t._self._c||s;return t.user?e("div",[e("b-row",[e("b-col",{staticClass:"text-left"},[e("div",{staticClass:"d-flex justify-content-start"},[e("progressive-img",{staticClass:"rounded float-left img-fluid mr-4",staticStyle:{width:"64px",height:"64px"},attrs:{src:t.user.xsmall,placeholder:t.user.placeholder,fallback:t.user.photo_url,"aspect-ratio":1}}),t._v(" "),e("div",[e("h4",[e("img",{attrs:{src:"/icons/correct.svg",width:"24",height:"24"}}),t._v(" "+t._s(t.user.name))]),t._v(" "),e("small",[t._v("@"+t._s(t.user.username))])]),t._v(" "),e("div",{staticClass:"ml-3"},[!t.auth||t.auth&&t.auth.id!=t.user.id?e("b-button",{staticClass:"px-4",attrs:{size:"sm",variant:"primary",block:""}},[t._v("+ "+t._s(t.$t("follow")))]):e("b-button",{staticClass:"px-4",attrs:{size:"sm",variant:"success",block:"",to:{name:"books.new"}}},[t._v("+ "+t._s(t.$t("new_book")))])],1)],1)])],1),t._v(" "),e("div",{staticClass:"d-flex justify-content-around text-center mt-3 border-top border-bottom py-2"},[e("b-col",[t._v(t._s(t.user.books_count)),e("br"),e("small",{staticClass:"text-muted"},[t._v(t._s(t.$t("books")))]),e("br"),e("small",{staticClass:"text-muted"},[t._v("#1")])]),t._v(" "),e("b-col",[t._v(t._s(t.user.followers_count)),e("br"),e("small",{staticClass:"text-muted"},[t._v(t._s(t.$t("followers")))]),e("br"),e("small",{staticClass:"text-muted"},[t._v("#7")])]),t._v(" "),e("b-col",[t._v(t._s(t.user.following_count)),e("br"),e("small",{staticClass:"text-muted"},[t._v(t._s(t.$t("following")))]),e("br"),e("small",{staticClass:"text-muted"},[t._v("#10")])]),t._v(" "),e("b-col",[t._v("0"),e("br"),e("small",{staticClass:"text-muted"},[t._v(t._s(t.$t("read_count")))]),e("br"),e("small",{staticClass:"text-muted"},[t._v("+#10k")])]),t._v(" "),e("b-col",[t._v("0"),e("br"),e("small",{staticClass:"text-muted"},[t._v(t._s(t.$t("reading_count")))]),e("br"),e("small",{staticClass:"text-muted"},[t._v("#100")])]),t._v(" "),e("b-col",[t._v("0"),e("br"),e("small",{staticClass:"text-muted"},[t._v(t._s(t.$t("toread_count")))]),e("br"),e("small",{staticClass:"text-muted"},[t._v("#69")])])],1),t._v(" "),t.user.books&&t.user.books.length?e("b-row",{staticClass:"mt-3"},t._l(t.user.books,function(s){return e("b-col",{key:s.id,attrs:{cols:"6",sm:"4",md:"4",lg:"3",xl:"2"}},[e("b-link",{attrs:{to:{name:"books.read",params:{slug:s.slug}}}},[e("div",{staticClass:"card mb-2"},[e("progressive-img",{staticClass:"card-img-top",attrs:{src:s.cover,placeholder:s.placeholder,"aspect-ratio":1.6666666667}}),t._v(" "),e("div",{staticClass:"card-body"},[e("p",{staticClass:"card-title"},[t._v(t._s(s.title))])])],1)])],1)})):e("div",{staticClass:"text-center mt-3"},[t._v(t._s(t.$t("no_book")))])],1):e("div",{staticClass:"my-4 text-center"},[e("img",{attrs:{src:"svg-loaders/oval.svg"}})])},staticRenderFns:[]},m=e("VU/8")(u,i,!1,null,null,null);s.default=m.exports}});
//# sourceMappingURL=10.62b1be2fc57cd3fe1369.js.map