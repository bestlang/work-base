webpackJsonp([3],{XD3L:function(e,t){},jk0Z:function(e,t,n){"use strict";var a=n("Gu7T"),r=n.n(a),i=n("YgNb"),o={props:["value"],data:function(){var e=localStorage.getItem("accessToken");return{uploadUrl:this.SITE_URL+"/"+Object(i.a)()+"/admin/file/upload",headers:{Authorization:"Bearer "+e,"X-CSRF-TOKEN":this.$store.getters[this.$types.CSRF]},disabled:!1,vals:[],updated:[]}},methods:{handlePreview:function(){},beforeRemove:function(e,t){return this.$confirm("确定移除 "+e.name+"？")},preview:function(e){window.open(e.response.data.file)},handleRemove:function(e,t){this.updated=this.vals.filter(function(t){return t.url!=e.url}),this.$emit("input",this.updated)},uploadSuccess:function(e,t,n){var a={name:t.name,url:e.data.file};this.updated=[].concat(r()(this.vals),[a]),this.$emit("input",this.updated)}},mounted:function(){this.value&&(this.vals=[].concat(r()(this.value)),this.updated=[].concat(r()(this.value)))}},s={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("el-upload",{attrs:{"on-preview":e.handlePreview,action:e.uploadUrl,"on-remove":e.handleRemove,"before-remove":e.beforeRemove,"on-success":e.uploadSuccess,multiple:"","file-list":e.vals,name:"file","show-file-list":!1,headers:e.headers}},[n("el-button",{attrs:{size:"small",type:"primary"}},[e._v("点击上传")]),e._v(" "),n("div",{staticClass:"el-upload__tip",attrs:{slot:"tip"},slot:"tip"})],1)},staticRenderFns:[]};var l=n("VU/8")(o,s,!1,function(e){n("yHtR")},"data-v-2a3cae25",null);t.a=l.exports},uSH3:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=n("Xxa5"),r=n.n(a),i=n("exGp"),o=n.n(i),s=n("Dd8w"),l=n.n(s),c=n("w+Hh"),d=n("Pgpu"),u=n.n(d),f=n("trTH"),m=n("FO7G"),p=n("M+9c"),h=n("jk0Z"),v=n("NYxO"),_=n("gyMJ"),b={data:function(){return{checkList:[],showSwitch:!1,contents:[],formTitle:"编辑内容",form:{positions:[]},ueditorConfig:f.a,contentPositions:[],channel_id:0,content_id:0}},components:{"channel-tree":c.a,VueUeditorWrap:u.a,imageUpload:m.a,multipleImageUpload:p.a,attachment:h.a},computed:l()({},Object(v.b)(["parentChannel","currentChannel","currentModel"])),watch:{content_id:function(e){var t=this;return o()(r.a.mark(function n(){var a,i;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:if(!e){n.next=10;break}return n.next=3,t.loadWholeContent(e);case 3:return n.next=5,_.a.getCmsChannelWhole({id:t.channel_id});case 5:return a=n.sent,i=a.data,t.$store.commit(t.$types.CMS_CURRENT_CHANNEL,i),n.next=10,t.loadContentPositions(t.currentChannel.id);case 10:case"end":return n.stop()}},n,t)}))()}},methods:{goback:function(){this.$router.push("/cms/content?channel_id="+this.currentChannel.id)},loadWholeContent:function(e){var t=this;return o()(r.a.mark(function n(){var a,i,o,s;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,_.a.getWholeContent({id:e});case 2:a=n.sent,i=a.data,t.channel_id=i.channel_id,(o=a.data.model).fields=o.fields.filter(function(e){return!e.is_channel}),s=["channel_id","model_id","title","keywords","description"],t.$set(t.form,"id",e),s.forEach(function(e){t.$set(t.form,e,i[e])}),i.contents&&i.contents.length&&i.contents.forEach(function(e){t.$set(t.form,e.field,e.value)}),i.metas&&i.metas.length&&i.metas.forEach(function(e){t.$set(t.form,e.field,e.value)}),i.positions&&t.$set(t.form,"positions",i.positions),t.$store.dispatch(t.$types.CMS_CURRENT_MODEL,o);case 14:case"end":return n.stop()}},n,t)}))()},saveContent:function(){var e=this;return o()(r.a.mark(function t(){return r.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return e.form.channel_id||e.form.model_id||(e.$set(e.form,"model_id",e.currentModel.id),e.$set(e.form,"channel_id",e.currentChannel.id)),t.next=3,_.a.saveContent(e.form);case 3:t.sent.success&&(e.$message({type:"success",message:"添加成功!"}),e.goback());case 5:case"end":return t.stop()}},t,e)}))()},handleNodeClick:function(e){var t=this;return o()(r.a.mark(function n(){var a;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return a=e[0],t.channel_id=a.id,t.$store.dispatch(t.$types.CMS_CURRENT_CHANNEL,a),t.$store.dispatch(t.$types.CMS_PARENT_CHANNEL,a),n.next=6,t.loadModel(a.model.id);case 6:return n.next=8,t.loadContentPositions();case 8:case"end":return n.stop()}},n,t)}))()},loadModel:function(e){var t=this;return o()(r.a.mark(function n(){var a,i,o,s;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,_.a.getModel({id:e});case 2:for(o in a=n.sent,(i=a.data).fields=i.fields.filter(function(e){return!e.is_channel}),t.$store.dispatch(t.$types.CMS_CURRENT_MODEL,i),t.currentModel.fields)s=t.currentModel.fields[o],t.$set(t.form,s.field,""),"checkbox"!=s.type&&"multiple-image"!=s.type||t.$set(t.form,s.field,[]);t.$set(t.form,"positions",[]);case 8:case"end":return n.stop()}},n,t)}))()},loadContentPositions:function(){var e=this,t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:0;return o()(r.a.mark(function n(){var a;return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:if(t||e.currentChannel&&e.currentChannel.id&&(t=e.currentChannel.id),t){n.next=3;break}return n.abrupt("return");case 3:return n.next=5,_.a.getContentPositions({channel_id:t});case 5:a=n.sent,e.contentPositions=a.data;case 7:case"end":return n.stop()}},n,e)}))()}},mounted:function(){var e=this;return o()(r.a.mark(function t(){return r.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:e.content_id=parseInt(e.$route.query.content_id||0),e.$store.dispatch("toggleState");case 2:case"end":return t.stop()}},t,e)}))()}},C={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"l-content-list"},[n("div",{directives:[{name:"title",rawName:"v-title",value:"内容管理",expression:"'内容管理'"}]}),e._v(" "),n("div",{staticClass:"l-tree-content"},[e.currentModel?n("div",{staticClass:"l-block"},[n("div",{staticClass:"l-block-header"},[n("div",[n("span",{staticClass:"l-go-back",on:{click:e.goback}},[n("span",{staticClass:"iconfont"},[e._v("")]),e._v("返回")]),e._v(" "),n("el-divider",{attrs:{direction:"vertical"}}),e._v(" "),e.currentChannel?n("span",[e._v("在"),n("span",{staticStyle:{"font-weight":"700"}},[e._v("“"+e._s(e.currentChannel.name)+"”")]),e._v("下"+e._s(e.formTitle))]):e._e()],1)]),e._v(" "),n("div",{staticClass:"l-block-body"},[n("el-form",{attrs:{"label-width":"100px"}},[e._l(e.currentModel.fields,function(t,a){return["text"==t.type?n("el-form-item",{attrs:{label:t.label}},[n("el-input",{key:a,attrs:{name:t.field},model:{value:e.form[t.field],callback:function(n){e.$set(e.form,t.field,n)},expression:"form[item.field]"}})],1):e._e(),e._v(" "),"checkbox"==t.type&&Array.isArray(e.form[t.field])?n("el-form-item",{attrs:{label:t.label}},[n("el-checkbox-group",{model:{value:e.form[t.field],callback:function(n){e.$set(e.form,t.field,n)},expression:"form[item.field]"}},e._l(t.extra,function(t){return n("el-checkbox",{attrs:{label:t.value}},[e._v(e._s(t.name))])}),1)],1):e._e(),e._v(" "),"image"==t.type?n("el-form-item",{attrs:{label:t.label}},[n("image-upload",{model:{value:e.form[t.field],callback:function(n){e.$set(e.form,t.field,n)},expression:"form[item.field]"}})],1):e._e(),e._v(" "),"multiple-image"==t.type&&e.form[t.field]?n("el-form-item",{attrs:{label:t.label}},[n("multiple-image-upload",{model:{value:e.form[t.field],callback:function(n){e.$set(e.form,t.field,n)},expression:"form[item.field]"}})],1):e._e(),e._v(" "),"attachment"==t.type&&e.form[t.field]?n("el-form-item",{staticClass:"l-mb-22",attrs:{label:t.label}},[n("div",[n("attachment",{model:{value:e.form[t.field],callback:function(n){e.$set(e.form,t.field,n)},expression:"form[item.field]"}})],1)]):e._e(),e._v(" "),"textarea"==t.type?n("el-form-item",{attrs:{label:t.label}},[n("el-input",{attrs:{type:"textarea"},model:{value:e.form[t.field],callback:function(n){e.$set(e.form,t.field,n)},expression:"form[item.field]"}})],1):e._e(),e._v(" "),"content"==t.type?n("el-form-item",{staticClass:"l-mb-22",attrs:{label:t.label}},[n("div",[n("vue-ueditor-wrap",{attrs:{config:e.ueditorConfig},model:{value:e.form[t.field],callback:function(n){e.$set(e.form,t.field,n)},expression:"form[item.field]"}})],1)]):e._e()]}),e._v(" "),e.contentPositions&&e.contentPositions.length?n("el-form-item",{attrs:{label:"编辑推荐位"}},[n("el-checkbox-group",{model:{value:e.form.positions,callback:function(t){e.$set(e.form,"positions",t)},expression:"form['positions']"}},e._l(e.contentPositions,function(t){return n("el-checkbox",{attrs:{label:t.id}},[e._v(e._s(t.name))])}),1)],1):e._e(),e._v(" "),n("el-form-item",[n("el-button",{attrs:{type:"primary",size:"small"},on:{click:e.saveContent}},[e._v("提交")])],1)],2)],1)]):e._e()])])},staticRenderFns:[]};var x=n("VU/8")(b,C,!1,function(e){n("XD3L")},"data-v-d5d1a974",null);t.default=x.exports},yHtR:function(e,t){}});
//# sourceMappingURL=3.0c34e3cfb6b65e0bae23.js.map