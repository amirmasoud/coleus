webpackJsonp([5],{hNU6:function(e,t){var n={kind:"Document",definitions:[{kind:"OperationDefinition",operation:"query",name:{kind:"Name",value:"FetchPageById"},variableDefinitions:[{kind:"VariableDefinition",variable:{kind:"Variable",name:{kind:"Name",value:"id"}},type:{kind:"NamedType",name:{kind:"Name",value:"Int"}}}],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"page"},arguments:[{kind:"Argument",name:{kind:"Name",value:"id"},value:{kind:"Variable",name:{kind:"Name",value:"id"}}}],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"id"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"title"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"content"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"next"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"prev"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"next_title"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"prev_title"},arguments:[],directives:[]}]}}]}}],loc:{start:0,end:133}};n.loc.source={body:"query FetchPageById($id: Int) {\n  page(id: $id) {\n    id\n    title\n    content\n    next\n    prev\n    next_title\n    prev_title\n  }\n}\n",name:"GraphQL request",locationOffset:{line:1,column:1}};var i={};function a(e,t){for(var n=0;n<e.definitions.length;n++){var i=e.definitions[n];if(i.name&&i.name.value==t)return i}}n.definitions.forEach(function(e){if(e.name){var t=new Set;!function e(t,n){if("FragmentSpread"===t.kind)n.add(t.name.value);else if("VariableDefinition"===t.kind){var i=t.type;"NamedType"===i.kind&&n.add(i.name.value)}t.selectionSet&&t.selectionSet.selections.forEach(function(t){e(t,n)}),t.variableDefinitions&&t.variableDefinitions.forEach(function(t){e(t,n)}),t.definitions&&t.definitions.forEach(function(t){e(t,n)})}(e,t),i[e.name.value]=t}}),e.exports=n,e.exports.FetchPageById=function(e,t){var n={kind:e.kind,definitions:[a(e,t)]};e.hasOwnProperty("loc")&&(n.loc=e.loc);for(var r=i[t]||new Set,s=new Set,d=new Set(r);d.size>0;){var l=d;d=new Set,l.forEach(function(e){s.has(e)||(s.add(e),(i[e]||new Set).forEach(function(e){d.add(e)}))})}return s.forEach(function(t){var i=a(e,t);i&&n.definitions.push(i)}),n}(n,"FetchPageById")},sQ2g:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});n("tlQw");var i={metaInfo:function(){return{title:this.$t("read_book")}},props:{firstId:Number,slug:String},data:function(){return{id:this.$route.params.page,page:null}},apollo:{page:{query:n("hNU6"),variables:function(){return{id:this.id||this.firstId}},result:function(e){this.$root.$emit("page-title-changed",this.page.title)}}},created:function(){var e=this;this.$nextTick(function(){e.$apollo.queries.page.refetch()})}},a={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return e.page&&!this.$apollo.queries.page.loading?n("div",[n("b-card",{staticClass:"p-2 reading-container"},[n("div",{staticClass:"row",domProps:{innerHTML:e._s(e.page.content)}})]),e._v(" "),n("b-row",[n("b-col",[e.page.next?n("b-card",{staticClass:"mt-3",attrs:{"no-body":""}},[n("b-link",{staticClass:"d-block text-left p-3",attrs:{to:{name:"books.read",params:{slug:e.slug,page:e.page.next}}}},[n("fa",{attrs:{icon:"angle-double-right","fixed-width":""}}),e._v(" "+e._s(e.$t("next"))+" "),n("br"),e._v(" "),n("small",{staticClass:"text-muted"},[e._v(e._s(e.page.next_title))])],1)],1):e._e()],1),e._v(" "),n("b-col",[e.page.prev?n("b-card",{staticClass:"mt-3",attrs:{"no-body":""}},[n("b-link",{staticClass:"d-block text-right p-3",attrs:{to:{name:"books.read",params:{slug:e.slug,page:e.page.prev}}}},[e._v("\n          "+e._s(e.$t("prev"))+" "),n("fa",{attrs:{icon:"angle-double-left","fixed-width":""}}),e._v(" "),n("br"),e._v(" "),n("small",{staticClass:"text-muted"},[e._v(e._s(e.page.prev_title))])],1)],1):e._e()],1)],1)],1):n("div",[n("b-card",{staticClass:"p-2 reading-container"},[n("img",{staticClass:"d-block mx-auto",attrs:{src:"/svg-loaders/oval.svg"}})])],1)},staticRenderFns:[]},r=n("VU/8")(i,a,!1,null,null,null);t.default=r.exports}});
//# sourceMappingURL=5.daccf379c34bb43f4483.js.map