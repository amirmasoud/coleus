webpackJsonp([8],{WY9G:function(r,t,o){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var s=o("Xxa5"),a=o.n(s),e=o("2gGM"),n=o.n(e);var i={scrollToTop:!1,metaInfo:function(){return{title:this.$t("settings")}},data:function(){return{form:new n.a({password:"",password_confirmation:""})}},methods:{update:function(){var r,t=(r=a.a.mark(function r(){return a.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,this.form.patch("/api/settings/password");case 2:this.form.reset();case 3:case"end":return r.stop()}},r,this)}),function(){var t=r.apply(this,arguments);return new Promise(function(r,o){return function s(a,e){try{var n=t[a](e),i=n.value}catch(r){return void o(r)}if(!n.done)return Promise.resolve(i).then(function(r){s("next",r)},function(r){s("throw",r)});r(i)}("next")})});return function(){return t.apply(this,arguments)}}()}},c={render:function(){var r=this,t=r.$createElement,o=r._self._c||t;return o("card",[o("form",{on:{submit:function(t){return t.preventDefault(),r.update(t)},keydown:function(t){r.form.onKeydown(t)}}},[o("alert-success",{attrs:{form:r.form,message:r.$t("password_updated")}}),r._v(" "),o("div",{staticClass:"form-group row"},[o("label",{staticClass:"col-md-3 col-form-label text-md-right"},[r._v(r._s(r.$t("new_password")))]),r._v(" "),o("div",{staticClass:"col-md-7"},[o("input",{directives:[{name:"model",rawName:"v-model",value:r.form.password,expression:"form.password"}],staticClass:"form-control",class:{"is-invalid":r.form.errors.has("password")},attrs:{type:"password",name:"password"},domProps:{value:r.form.password},on:{input:function(t){t.target.composing||r.$set(r.form,"password",t.target.value)}}}),r._v(" "),o("has-error",{attrs:{form:r.form,field:"password"}})],1)]),r._v(" "),o("div",{staticClass:"form-group row"},[o("label",{staticClass:"col-md-3 col-form-label text-md-right"},[r._v(r._s(r.$t("confirm_password")))]),r._v(" "),o("div",{staticClass:"col-md-7"},[o("input",{directives:[{name:"model",rawName:"v-model",value:r.form.password_confirmation,expression:"form.password_confirmation"}],staticClass:"form-control",class:{"is-invalid":r.form.errors.has("password_confirmation")},attrs:{type:"password",name:"password_confirmation"},domProps:{value:r.form.password_confirmation},on:{input:function(t){t.target.composing||r.$set(r.form,"password_confirmation",t.target.value)}}}),r._v(" "),o("has-error",{attrs:{form:r.form,field:"password_confirmation"}})],1)]),r._v(" "),o("div",{staticClass:"form-group row"},[o("div",{staticClass:"col-md-9 ml-md-auto"},[o("v-button",{attrs:{loading:r.form.busy}},[r._v(r._s(r.$t("update")))])],1)])],1)])},staticRenderFns:[]},m=o("VU/8")(i,c,!1,null,null,null);t.default=m.exports}});
//# sourceMappingURL=8.828e6c72b7041489fa3e.js.map