webpackJsonp([32],{"n+mU":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n("Xxa5"),i=n.n(o),r=n("exGp"),s=n.n(r),a=n("woOf"),l=n.n(a),c=n("gyMJ"),u=(n("NYxO"),{data:function(){return{formVisible:!1,form:{id:null,name:"",is_channel:0,order_factor:100},position:{},subPositions:[],channel_position_id:null}},methods:{editChannel:function(t){l()(this.form,t),this.formVisible=!0},deleteChannel:function(t){this.$confirm("确定删除“ "+t.name+"”推荐位?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then(function(){})},handleAdd:function(){l()(this.form,{id:null,name:"",is_channel:0,order_factor:100,parent_id:this.channel_position_id}),this.formVisible=!0},getPosition:function(t){var e=this;return s()(i.a.mark(function n(){var o;return i.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,c.a.getPosition({id:t});case 2:o=n.sent,e.position=o.data;case 4:case"end":return n.stop()}},n,e)}))()},getSubPositions:function(t){var e=this;return s()(i.a.mark(function n(){var o;return i.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,c.a.getSubPositions({id:t});case 2:o=n.sent,e.subPositions=o.data;case 4:case"end":return n.stop()}},n,e)}))()},submit:function(){var t=this;return s()(i.a.mark(function e(){var n;return i.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,c.a.savePosition(t.form);case 2:if(!e.sent.success){e.next=10;break}return e.next=6,t.getSubPositions(t.channel_position_id);case 6:t.formVisible=!1,n="添加成功!",t.form.id&&(n="更新成功!"),t.$message({message:n,type:"success"});case 10:case"end":return e.stop()}},e,t)}))()}},mounted:function(){var t=this;return s()(i.a.mark(function e(){return i.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.channel_position_id=parseInt(t.$route.query.channel_position_id||0),e.next=3,t.getSubPositions(t.channel_position_id);case 3:return e.next=5,t.getPosition(t.channel_position_id);case 5:case"end":return e.stop()}},e,t)}))()}}),f={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",{staticClass:"l-block"},[n("div",{staticClass:"l-block-header"},[n("div",[n("router-link",{staticClass:"l-cursor",attrs:{to:"/cms/position/position",tag:"span"}},[n("span",{staticClass:"iconfont"},[t._v("")]),t._v(" 返回")]),t._v(" "),n("el-divider",{attrs:{direction:"vertical"}}),t._v(" "),n("span",[t._v("「"+t._s(t.position.name)+"」内容推荐位")])],1),t._v(" "),n("el-button",{attrs:{type:"primary",size:"small"},on:{click:t.handleAdd}},[t._v("新增")])],1),t._v(" "),n("div",{staticClass:"l-block-body"},[n("el-table",{staticStyle:{width:"100%"},attrs:{data:t.subPositions}},[n("el-table-column",{attrs:{prop:"id",label:"ID",width:"100"}}),t._v(" "),n("el-table-column",{attrs:{prop:"name",label:"推荐位名"}}),t._v(" "),n("el-table-column",{attrs:{prop:"order_factor",label:"排序值"}}),t._v(" "),n("el-table-column",{attrs:{width:"300",label:"操作"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("el-button",{attrs:{type:"text"},on:{click:function(n){return t.editChannel(e.row)}}},[t._v("编辑")]),t._v(" "),n("el-button",{attrs:{type:"text"},on:{click:function(n){return t.deleteChannel(e.row)}}},[t._v("删除")])]}}])})],1)],1),t._v(" "),n("div",{staticClass:"l-block-bottom"})]),t._v(" "),n("el-dialog",{attrs:{title:"添加类型",visible:t.formVisible,"close-on-click-modal":!1},on:{"update:visible":function(e){t.formVisible=e}}},[n("el-form",{attrs:{model:t.form}},[n("el-form-item",{attrs:{label:"名称","label-width":"100px"}},[n("el-input",{attrs:{autocomplete:"off"},model:{value:t.form.name,callback:function(e){t.$set(t.form,"name",e)},expression:"form.name"}})],1),t._v(" "),n("el-form-item",{attrs:{label:"排序值","label-width":"100px"}},[n("el-input",{attrs:{type:"number",autocomplete:"off"},model:{value:t.form.order_factor,callback:function(e){t.$set(t.form,"order_factor",e)},expression:"form.order_factor"}})],1)],1),t._v(" "),n("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[n("el-button",{on:{click:function(e){t.formVisible=!1}}},[t._v("取消")]),t._v(" "),n("el-button",{attrs:{type:"primary"},on:{click:t.submit}},[t._v("确定")])],1)],1)],1)},staticRenderFns:[]},d=n("VU/8")(u,f,!1,null,null,null);e.default=d.exports}});
//# sourceMappingURL=32.6f53154ebbfd4c7229bb.js.map