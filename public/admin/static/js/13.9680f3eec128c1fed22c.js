webpackJsonp([13],{"cT/d":function(e,t){},gSSL:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=n("Xxa5"),r=n.n(a),s=n("exGp"),i=n.n(s),o=n("gyMJ"),l={data:function(){return{w:"80px",loading:!0,tableData:[]}},methods:{handleEdit:function(e){this.$router.push("/cms/operation/edit/ad?id="+e.id)},handleDelete:function(e){var t=this;this.$confirm("确认删除该广告?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then(i()(r.a.mark(function n(){return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,o.a.deleteAd({id:e.id});case 2:if(!n.sent.success){n.next=7;break}return t.$message({message:"操作成功",type:"success"}),n.next=7,t.loadAds();case 7:case"end":return n.stop()}},n,t)})))},add:function(){this.$router.push("/cms/operation/edit/ad")},positions:function(){this.$router.push("/cms/operation/ad/positions")},submit:function(){var e=this;return i()(r.a.mark(function t(){var n,a;return r.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,o.a.saveModelFieldType(e.form);case 2:(n=t.sent).success?(e.loading=!0,e.loadAds(),e.formVisible=!1,a="添加成功!",e.form.id&&(a="编辑成功!"),e.$message({message:a,type:"success"})):e.$message({message:n.error,type:"warning"});case 4:case"end":return t.stop()}},t,e)}))()},loadAds:function(){var e=this;return i()(r.a.mark(function t(){var n;return r.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,o.a.getAds();case 2:n=t.sent,e.loading=!1,e.tableData=n.data;case 5:case"end":return t.stop()}},t,e)}))()}},created:function(){var e=this;return i()(r.a.mark(function t(){return r.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.loadAds();case 2:case"end":return t.stop()}},t,e)}))()}},c={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",[n("div",{directives:[{name:"title",rawName:"v-title",value:"广告管理",expression:"'广告管理'"}]}),e._v(" "),n("div",{staticClass:"l-top-menu"},[n("div",[n("el-button",{attrs:{type:"primary",size:"small"},on:{click:e.add}},[e._v("新增")]),e._v(" "),n("el-button",{attrs:{type:"primary",size:"small"},on:{click:e.positions}},[e._v("广告位")])],1),e._v(" "),n("div")]),e._v(" "),n("el-table",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],staticStyle:{width:"100%"},attrs:{data:e.tableData}},[n("el-table-column",{attrs:{prop:"id",label:"ID",width:"100"}}),e._v(" "),n("el-table-column",{attrs:{prop:"name",label:"名称"}}),e._v(" "),n("el-table-column",{attrs:{label:"状态"},scopedSlots:e._u([{key:"default",fn:function(t){return[e._v("\n                "+e._s(1==t.row.enabled?"已启用":"未启用")+"\n            ")]}}])}),e._v(" "),n("el-table-column",{attrs:{label:"广告位"},scopedSlots:e._u([{key:"default",fn:function(t){return[e._v("\n                "+e._s(t.row.position.name)+"\n            ")]}}])}),e._v(" "),n("el-table-column",{attrs:{prop:"start_time",label:"开始时间"}}),e._v(" "),n("el-table-column",{attrs:{prop:"end_time",label:"结束时间"}}),e._v(" "),n("el-table-column",{attrs:{label:"操作"},scopedSlots:e._u([{key:"default",fn:function(t){return[n("el-button",{attrs:{type:"text",size:"small"},on:{click:function(n){return e.handleEdit(t.row)}}},[e._v("编辑")]),e._v(" "),n("el-button",{attrs:{type:"text",size:"small"},on:{click:function(n){return e.handleDelete(t.row)}}},[e._v("删除")])]}}])})],1)],1)},staticRenderFns:[]};var u=n("VU/8")(l,c,!1,function(e){n("cT/d")},"data-v-6c030636",null);t.default=u.exports}});
//# sourceMappingURL=13.9680f3eec128c1fed22c.js.map