webpackJsonp([9],{J4LN:function(e,n,t){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var a=t("woOf"),l=t.n(a),s=t("Xxa5"),o=t.n(s),r=t("mvHQ"),i=t.n(r),c=t("exGp"),h=t.n(c),d=t("Dd8w"),u=t.n(d),m=t("bOdI"),p=t.n(m),f=t("trTH"),C=t("Pgpu"),v=t.n(C),_=t("NYxO"),b=t("gyMJ"),x=p()({data:function(){return{checkList:[],optionalTemplatePath:[],channelPositions:[],customProps:{children:"children",label:"name"},title:"添加子栏目",showChannelChildren:!0,channelForm:{id:null,model_id:"",parent_id:null,name:null,positions:[]},customChannelFields:[],ueditorConfig:f.a}},watch:p()({},"channelForm.model_id",function(e){this.loadTemplatePath(e)}),components:{VueUeditorWrap:v.a},computed:u()({},Object(_.b)(["loading","channels","channelChildren","models","parentChannel"])),methods:{loadTemplatePath:function(e){var n=this;return h()(o.a.mark(function t(){var a,l;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,b.a.getOptionalTemplatePath({model_id:e});case 2:a=t.sent,l=a.data,console.log(i()(l)),n.optionalTemplatePath=l;case 6:case"end":return t.stop()}},t,n)}))()},addChannel:function(e){this.showChannelChildren=!1,this.channelForm=l()({},{id:null,parent_id:e.id,model_id:"",channel_id:null,name:null,positions:[]}),this.$store.dispatch(this.$types.CMS_PARENT_CHANNEL,e),this.customChannelFields=[]},editChannel:function(e){this.loadWholeChannel(e),this.showChannelChildren=!1,this.$store.dispatch(this.$types.CMS_CURRENT_CHANNEL,e)},deleteChannel:function(e){var n=this;this.$confirm("确定删除“"+e.name+"”栏目?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then(h()(o.a.mark(function t(){var a;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,b.a.deleteCmsChannel({id:e.id});case 2:(a=t.sent).success?(n.$store.dispatch(n.$types.CMS_CHANNELS,{id:e.parent_id}),n.showChannelChildren=!0,n.$message({type:"success",message:"删除成功!"})):n.$message({type:"error",message:a.error});case 4:case"end":return t.stop()}},t,n)}))).catch(function(){})},handleNodeClick:function(e){e.children.length>0?(this.$store.dispatch(this.$types.CMS_CHANNEL_CHILDREN,e),this.showChannelChildren=!0,this.$store.dispatch(this.$types.CMS_PARENT_CHANNEL,e)):(this.showChannelChildren=!1,this.loadWholeChannel(e))},doSubmit:function(){this.channelForm.id?this.doEdit():this.doAdd()},doCancel:function(){this.showChannelChildren=!0},doAdd:function(){var e=this;return h()(o.a.mark(function n(){var t;return o.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return e.showChannelChildren=!1,n.next=3,b.a.saveCmsChannel(e.channelForm);case 3:(t=n.sent).success?(e.showChannelChildren=!0,e.$store.dispatch(e.$types.CMS_CHANNELS,e.parentChannel),e.$message({type:"success",message:"添加成功!"})):e.$message({type:"error",message:"添加失败!"+t.error});case 5:case"end":return n.stop()}},n,e)}))()},doEdit:function(){var e=this;return h()(o.a.mark(function n(){var t;return o.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,b.a.saveCmsChannel(e.channelForm);case 2:(t=n.sent).success?(e.$message({type:"success",message:"修改成功!"}),e.$store.dispatch(e.$types.CMS_CHANNELS,{id:e.channelForm.parent_id})):e.$message({type:"warning",message:"修改失败!"+t.error});case 4:case"end":return n.stop()}},n,e)}))()},loadWholeChannel:function(e){var n=this,t=e.id;return h()(o.a.mark(function e(){var a,l;return o.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,b.a.getCmsChannelWhole({id:t});case 2:a=e.sent,l=a.data,n.channelForm={},["id","model_id","parent_id","name","title","keywords","description","template","content_template"].forEach(function(e){n.$set(n.channelForm,e,l[e])}),l.contents&&l.contents.length&&l.contents.forEach(function(e){n.$set(n.channelForm,e.field,e.value)}),l.metas&&l.metas.length&&l.metas.forEach(function(e){n.$set(n.channelForm,e.field,e.value)}),l.positions&&n.$set(n.channelForm,"positions",l.positions);case 10:case"end":return e.stop()}},e,n)}))()},loadChannelPositions:function(){var e=this;return h()(o.a.mark(function n(){var t;return o.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,b.a.getCmsPositions({is_channel:1});case 2:t=n.sent,e.channelPositions=t.data;case 4:case"end":return n.stop()}},n,e)}))()}},mounted:function(){var e=this;return h()(o.a.mark(function n(){return o.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return console.log("current meta:",e.$route.meta),e.$store.dispatch("toggleState"),e.$store.dispatch(e.$types.CMS_CHANNELS),e.$store.dispatch(e.$types.CMS_MODELS),n.next=6,e.loadChannelPositions();case 6:case"end":return n.stop()}},n,e)}))()}},"watch",p()({},"channelForm.model_id",function(e){var n=this;return h()(o.a.mark(function t(){return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return console.log("###########",e),t.next=3,n.loadTemplatePath(e);case 3:e?n.models.length>0&&n.models.forEach(function(e){e.id==n.channelForm.model_id&&(n.customChannelFields=e.fields.filter(function(e){return e.is_channel&&(n.channelForm.hasOwnProperty(e.field)||(n.$set(n.channelForm,e.field,""),"checkbox"==e.type&&n.$set(n.channelForm,e.field,[]))),e.is_channel}))}):n.customChannelFields=[];case 4:case"end":return t.stop()}},t,n)}))()})),F={render:function(){var e=this,n=e.$createElement,t=e._self._c||n;return t("div",{staticClass:"l-channel-list"},[t("div",{directives:[{name:"title",rawName:"v-title",value:"栏目管理",expression:"'栏目管理'"}]}),e._v(" "),t("div",{staticClass:"l-tree-containner"},[t("el-tree",{ref:"tree",attrs:{"icon-class":"el-icon-caret-right","default-expand-all":!0,data:e.channels,"node-key":"id",props:e.customProps,"expand-on-click-node":!1},on:{"node-click":e.handleNodeClick},scopedSlots:e._u([{key:"default",fn:function(n){var a=n.node,l=n.data;return t("span",{staticClass:"custom-tree-node"},[t("span",[l.children.length?e._e():t("span",{staticClass:"iconfont"},[e._v("")]),e._v(e._s(a.label))])])}}])})],1),e._v(" "),e.showChannelChildren?t("div",{staticClass:"l-tree-content"},[t("div",{staticClass:"l-block"},[e.parentChannel&&e.parentChannel.id?t("div",{staticClass:"l-block-header"},[t("span",[t("i",{staticClass:"iconfont"},[e._v("")]),e._v(" "+e._s(e.parentChannel.hasOwnProperty("name")?e.parentChannel.name:""))]),e._v(" "),t("el-button-group",[t("el-button",{staticStyle:{padding:"3px 10px"},attrs:{type:"text"},on:{click:function(n){return e.editChannel(e.parentChannel)}}},[e._v("编辑")]),e._v(" "),t("el-button",{staticStyle:{padding:"3px 10px"},attrs:{type:"text"},on:{click:function(n){return e.addChannel(e.parentChannel)}}},[e._v("新增子栏目")])],1)],1):e._e(),e._v(" "),e.channels.length?e._e():t("div",{staticClass:"l-block-header"},[t("el-button",{staticStyle:{padding:"3px 10px"},attrs:{type:"text"},on:{click:function(n){return e.addChannel({id:0})}}},[e._v("新增栏目")])],1),e._v(" "),t("div",{staticClass:"l-block-body"},[t("el-table",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],staticStyle:{width:"100%"},attrs:{data:e.channelChildren}},[t("el-table-column",{attrs:{prop:"id",label:"ID",width:"80"}}),e._v(" "),t("el-table-column",{attrs:{prop:"name",label:"栏目名"}}),e._v(" "),t("el-table-column",{attrs:{label:"操作"},scopedSlots:e._u([{key:"default",fn:function(n){return[t("el-button",{staticClass:"l-lighter",attrs:{type:"text"},on:{click:function(t){return e.editChannel(n.row)}}},[e._v("编辑")]),e._v(" "),t("el-button",{staticClass:"l-lighter",attrs:{type:"text"},on:{click:function(t){return e.addChannel(n.row)}}},[e._v("新增子栏目")]),e._v(" "),t("el-button",{staticClass:"l-lighter",attrs:{type:"text"},on:{click:function(t){return e.deleteChannel(n.row)}}},[e._v("删除")])]}}],null,!1,3573291426)})],1)],1)])]):e._e(),e._v(" "),e.showChannelChildren?e._e():t("div",{staticClass:"l-tree-content"},[e.showChannelChildren?e._e():t("div",{staticClass:"l-block"},[e.parentChannel&&e.parentChannel.id?t("div",{staticClass:"l-block-header"},[t("span",[e.channelForm.id?t("span",[t("i",{staticClass:"iconfont"},[e._v("")]),e._v(" "+e._s(e.channelForm.name))]):t("span",[e._v("\n                在 "),t("span",{staticStyle:{"font-weight":"700"}},[e._v("“"+e._s(e.parentChannel.name)+"”")]),e._v("下新增栏目")])]),e._v(" "),t("el-button-group",[t("el-button",{staticStyle:{padding:"3px 10px"},attrs:{type:"text"},on:{click:function(n){return e.addChannel(e.channelForm)}}},[e._v("新增子栏目")]),e._v(" "),t("el-button",{staticStyle:{padding:"3px 10px"},attrs:{type:"text"},on:{click:function(n){return e.deleteChannel(e.channelForm)}}},[e._v("删除")])],1)],1):e._e(),e._v(" "),t("div",{staticClass:"l-block-body"},[t("el-form",{attrs:{model:e.channelForm,"label-width":"100px"}},[t("el-form-item",{attrs:{label:"模型"}},[t("el-select",{attrs:{placeholder:"请选择"},model:{value:e.channelForm.model_id,callback:function(n){e.$set(e.channelForm,"model_id",n)},expression:"channelForm.model_id"}},e._l(e.models,function(e){return t("el-option",{key:e.name,attrs:{label:e.name,value:e.id}})}),1)],1),e._v(" "),t("el-form-item",{attrs:{label:"栏目名"}},[t("el-input",{attrs:{autocomplete:"off"},model:{value:e.channelForm.name,callback:function(n){e.$set(e.channelForm,"name",n)},expression:"channelForm.name"}})],1),e._v(" "),t("el-form-item",{attrs:{label:"栏目模板"}},[t("el-select",{attrs:{placeholder:"请选择"},model:{value:e.channelForm.template,callback:function(n){e.$set(e.channelForm,"template",n)},expression:"channelForm.template"}},e._l(e.optionalTemplatePath,function(e,n){return t("el-option",{key:n,attrs:{label:e,value:e}})}),1)],1),e._v(" "),t("el-form-item",{attrs:{label:"内容模板"}},[t("el-select",{attrs:{placeholder:"请选择"},model:{value:e.channelForm.content_template,callback:function(n){e.$set(e.channelForm,"content_template",n)},expression:"channelForm.content_template"}},e._l(e.optionalTemplatePath,function(e,n){return t("el-option",{key:n,attrs:{label:e,value:e}})}),1)],1),e._v(" "),e._l(e.customChannelFields,function(n,a){return["text"==n.type?t("el-form-item",{attrs:{label:n.label}},[t("el-input",{key:a,attrs:{name:n.field},model:{value:e.channelForm[n.field],callback:function(t){e.$set(e.channelForm,n.field,t)},expression:"channelForm[item.field]"}})],1):e._e(),e._v(" "),"checkbox"==n.type&&Array.isArray(e.channelForm[n.field])?t("el-form-item",{attrs:{label:n.label}},[t("el-checkbox-group",{model:{value:e.channelForm[n.field],callback:function(t){e.$set(e.channelForm,n.field,t)},expression:"channelForm[item.field]"}},e._l(n.extra,function(n){return t("el-checkbox",{attrs:{label:n.value}},[e._v(e._s(n.name))])}),1)],1):e._e(),e._v(" "),"textarea"==n.type?t("el-form-item",{attrs:{label:n.label}},[t("el-input",{attrs:{type:"textarea"},model:{value:e.channelForm[n.field],callback:function(t){e.$set(e.channelForm,n.field,t)},expression:"channelForm[item.field]"}})],1):e._e(),e._v(" "),"content"==n.type?t("el-form-item",{staticClass:"l-mb-22",attrs:{label:n.label}},[t("div",[t("vue-ueditor-wrap",{attrs:{config:e.ueditorConfig},model:{value:e.channelForm[n.field],callback:function(t){e.$set(e.channelForm,n.field,t)},expression:"channelForm[item.field]"}})],1)]):e._e()]}),e._v(" "),e.channelPositions.length?t("el-form-item",{attrs:{label:"栏目推荐位"}},[t("el-checkbox-group",{model:{value:e.channelForm.positions,callback:function(n){e.$set(e.channelForm,"positions",n)},expression:"channelForm['positions']"}},e._l(e.channelPositions,function(n){return t("el-checkbox",{attrs:{label:n.id}},[e._v(e._s(n.name))])}),1)],1):e._e(),e._v(" "),t("el-form-item",[t("el-button",{attrs:{type:"primary"},on:{click:e.doSubmit}},[e._v("确定")])],1)],2)],1)])])])},staticRenderFns:[]};var k=t("VU/8")(x,F,!1,function(e){t("OB+k")},"data-v-e03f3c56",null);n.default=k.exports},"OB+k":function(e,n){}});
//# sourceMappingURL=9.e9ed3e0caaccbd8ea688.js.map