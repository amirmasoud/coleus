webpackJsonp([15],{Iexn:function(e,t,s){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=s("IpW8"),n=s("2gGM"),r=s.n(n),o={middleware:"guest",metaInfo(){return{title:this.$t("reset_password")}},data:()=>({status:"",form:new r.a({email:""})}),methods:{async send(){const{data:e}=await this.form.post("/api/password/email");this.status=e.status,this.form.reset()}}},i=s("K1/g"),l=Object(i.a)(o,a.render,a.staticRenderFns,!1,null,null,null);l.options.__file="email.vue";t.default=l.exports},IpW8:function(e,t){throw new Error('Module parse failed: Unexpected token (2:0)\nYou may need an appropriate loader to handle this file type.\n| \n| <div class="row">\n|   <div class="col-lg-8 m-auto">\n|     <card :title="$t(\'reset_password\')">')}});
//# sourceMappingURL=15.96bffafc8a1c88de959e.js.map