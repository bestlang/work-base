webpackJsonp([31],{GWI2:function(e,t){},YMpQ:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=n("fZjL"),a=n.n(r),s=n("Xxa5"),i=n.n(s),o=n("exGp"),c=n.n(o),d=n("woOf"),l=n.n(d),m=n("gyMJ"),u={data:function(){return{emptyText:"loading...",customProps:{children:"children",label:"show_name"},treeData:[],current:null,formVisible:!1,title:"添加子权限",form:{id:"",parent_id:"",name:"",show_name:""}}},methods:{edit:function(e){this.current=e;var t=e.id,n=e.parent_id,r=e.name,a=e.show_name;this.form={id:t,parent_id:n,name:r,show_name:a},this.formVisible=!0,this.title="编辑权限"},reset:function(){this.current=null,l()(this.form,{id:"",parent_id:"",name:"",show_name:""})},add:function(e){this.reset(),this.current=e,this.formVisible=!0},doSubmit:function(){this.form.id?this.doEdit():this.doAdd()},doAdd:function(){var e=this;return c()(i.a.mark(function t(){var n,r;return i.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return n={show_name:e.form.show_name,disabled:!0,name:e.form.name,children:[]},e.current.children||e.$set(e.current,"children",[]),e.formVisible=!1,t.next=5,m.a.addPermission({parent_id:e.current.id,name:e.form.name,show_name:e.form.show_name});case 5:r=t.sent,n.id=r.data.id,e.current.children.push(n),r.success?(e.$message({type:"success",message:"添加成功!"}),e.reset()):e.formVisible=!0;case 9:case"end":return t.stop()}},t,e)}))()},doEdit:function(){var e=this;return c()(i.a.mark(function t(){return i.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,m.a.editPermission({id:e.form.id,name:e.form.name,show_name:e.form.show_name});case 2:t.sent,e.$message({type:"success",message:"修改成功!"}),e.current.name=e.form.name,e.current.show_name=e.form.show_name,e.reset(),e.formVisible=!1;case 8:case"end":return t.stop()}},t,e)}))()},remove:function(e,t){var n=this;this.$confirm("删除权限存在风险,是否继续?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then(c()(i.a.mark(function r(){var a,s,o;return i.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,m.a.deletePermission({id:t.id});case 2:r.sent,a=e.parent,s=a.data.children||a.data,o=s.findIndex(function(e){return e.id===t.id}),s.splice(o,1),n.$message({type:"success",message:"删除成功!"});case 8:case"end":return r.stop()}},r,n)})))},handleCheckChange:function(e,t,n){return console.log(e,".............",t,".............",n),!0},loadPermissionsTree:function(){var e=this;return c()(i.a.mark(function t(){var n;return i.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,m.a.getPermissionsTree({disabled:!0});case 2:n=t.sent,e.treeData=[n.data[a()(n.data)[0]]];case 4:case"end":return t.stop()}},t,e)}))()}},mounted:function(){var e=this;return c()(i.a.mark(function t(){return i.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.loadPermissionsTree();case 2:case"end":return t.stop()}},t,e)}))()}},f={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",[n("div",{directives:[{name:"title",rawName:"v-title",value:"权限管理",expression:"'权限管理'"}]}),e._v(" "),n("div",{staticStyle:{width:"50%"}},[n("div",{staticClass:"l-block"},[n("div",{staticClass:"l-block-header"},[e._v("所有权限")]),e._v(" "),n("div",{staticClass:"l-block-body"},[n("el-tree",{ref:"tree",attrs:{"empty-text":e.emptyText,data:e.treeData,"default-expanded-keys":[],"default-expand-all":!0,"node-key":"id",props:e.customProps,"default-checked-keys":[],"expand-on-click-node":!1},on:{check:e.handleCheckChange},scopedSlots:e._u([{key:"default",fn:function(t){var r=t.node,a=t.data;return n("span",{staticClass:"custom-tree-node"},[n("span",[a.children.length?e._e():n("span",{staticClass:"iconfont"},[e._v("")]),e._v(e._s(r.label))]),e._v(" "),n("span",[n("el-button",{attrs:{type:"text",size:"mini"},on:{click:function(){return e.edit(a)}}},[e._v("\n              编辑\n            ")]),e._v(" "),n("el-button",{attrs:{type:"text",size:"mini"},on:{click:function(){return e.add(a)}}},[e._v("\n              新增\n            ")]),e._v(" "),n("el-button",{attrs:{type:"text",size:"mini"},on:{click:function(){return e.remove(r,a)}}},[e._v("\n              删除\n            ")])],1)])}}])})],1)])]),e._v(" "),n("el-dialog",{attrs:{title:e.title,visible:e.formVisible,"close-on-click-modal":!1},on:{"update:visible":function(t){e.formVisible=t}}},[n("el-form",{attrs:{model:e.form,"label-width":"100px"}},[n("el-form-item",{attrs:{label:"权限显示名"}},[n("el-input",{attrs:{autocomplete:"off"},model:{value:e.form.show_name,callback:function(t){e.$set(e.form,"show_name",t)},expression:"form.show_name"}})],1),e._v(" "),n("el-form-item",{attrs:{label:"权限字符串"}},[n("el-input",{attrs:{autocomplete:"off",disabled:e.form.id>0},model:{value:e.form.name,callback:function(t){e.$set(e.form,"name",t)},expression:"form.name"}})],1)],1),e._v(" "),n("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[n("el-button",{on:{click:function(t){e.formVisible=!1}}},[e._v("取 消")]),e._v(" "),n("el-button",{attrs:{type:"primary"},on:{click:e.doSubmit}},[e._v("确 定")])],1)],1)],1)},staticRenderFns:[]};var h=n("VU/8")(u,f,!1,function(e){n("GWI2")},"data-v-0619ff32",null);t.default=h.exports}});
//# sourceMappingURL=31.7133e2f685bd712a6d69.js.map