webpackJsonp([15],{"3em6":function(e,t){},YMpQ:function(e,t,i){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=i("fZjL"),s=i.n(n),o=i("woOf"),a=i.n(o),r={data:function(){return{emptyText:"loading...",customProps:{children:"children",label:"show_name"},treeData:[],current:null,formVisible:!1,title:"添加子权限",form:{id:"",parent_id:"",name:"",show_name:""}}},methods:{edit:function(e){this.current=e;var t=e.id,i=e.parent_id,n=e.name,s=e.show_name;this.form={id:t,parent_id:i,name:n,show_name:s},this.formVisible=!0,this.title="编辑权限"},recovery:function(){this.current=null,a()(this.form,{id:"",parent_id:"",name:"",show_name:""})},add:function(e){this.recovery(),this.current=e,this.formVisible=!0},doSubmit:function(){this.form.id?this.doEdit():this.doAdd()},doAdd:function(){var e=this,t={show_name:this.form.show_name,disabled:!0,name:this.form.name,children:[]};this.current.children||this.$set(this.current,"children",[]),this.formVisible=!1,this.$http.post("/admin/privileges/add/permission",{parent_id:this.current.id,name:this.form.name,show_name:this.form.show_name}).then(function(i){t.id=i.data.id,e.current.children.push(t),i.success?(e.$message({type:"success",message:"添加成功!"}),e.recovery()):e.formVisible=!0})},doEdit:function(){var e=this;this.$http.post("/admin/privileges/edit/permission",{id:this.form.id,name:this.form.name,show_name:this.form.show_name}).then(function(t){e.$message({type:"success",message:"修改成功!"}),e.current.name=e.form.name,e.current.show_name=e.form.show_name,e.recovery()}),this.formVisible=!1},remove:function(e,t){var i=this;this.$confirm("删除权限存在风险,是否继续?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then(function(){i.$http.post("/admin/privileges/delete/permission",{id:t.id}).then(function(n){var s=e.parent,o=s.data.children||s.data,a=o.findIndex(function(e){return e.id===t.id});o.splice(a,1),i.$message({type:"success",message:"删除成功!"})}).catch(function(){})})},handleCheckChange:function(e,t,i){return console.log(e,".............",t,".............",i),!0},loadPermissionsTree:function(){var e=this;this.$http.get("/admin/privileges/permissions/tree",{params:{disabled:!0}}).then(function(t){e.treeData=[t.data[s()(t.data)[0]]]})}},mounted:function(){this.loadPermissionsTree()}},l={render:function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("div",[i("div",{directives:[{name:"title",rawName:"v-title",value:"权限管理",expression:"'权限管理'"}]}),e._v(" "),i("div",{staticClass:"top-buttons",staticStyle:{display:"flex","flex-flow":"row nowrap","justify-content":"space-between"}}),e._v(" "),i("div",{staticStyle:{width:"50%"}},[i("div",{staticClass:"l-block"},[i("div",{staticClass:"l-block-header"},[e._v("所有权限")]),e._v(" "),i("div",{staticClass:"l-block-body"},[i("el-tree",{ref:"tree",attrs:{"empty-text":e.emptyText,data:e.treeData,"default-expanded-keys":[],"default-expand-all":!0,"node-key":"id",props:e.customProps,"default-checked-keys":[],"expand-on-click-node":!1},on:{check:e.handleCheckChange},scopedSlots:e._u([{key:"default",fn:function(t){var n=t.node,s=t.data;return i("span",{staticClass:"custom-tree-node"},[i("span",[s.children.length?e._e():i("span",{staticClass:"iconfont"},[e._v("")]),e._v(e._s(n.label))]),e._v(" "),i("span",[i("el-button",{attrs:{type:"text",size:"mini"},on:{click:function(){return e.edit(s)}}},[e._v("\n              编辑\n            ")]),e._v(" "),i("el-button",{attrs:{type:"text",size:"mini"},on:{click:function(){return e.add(s)}}},[e._v("\n              新增\n            ")]),e._v(" "),i("el-button",{attrs:{type:"text",size:"mini"},on:{click:function(){return e.remove(n,s)}}},[e._v("\n              删除\n            ")])],1)])}}])})],1)])]),e._v(" "),i("el-dialog",{attrs:{title:e.title,visible:e.formVisible,"close-on-click-modal":!1},on:{"update:visible":function(t){e.formVisible=t}}},[i("el-form",{attrs:{model:e.form,"label-width":"100px"}},[i("el-form-item",{attrs:{label:"权限显示名"}},[i("el-input",{attrs:{autocomplete:"off"},model:{value:e.form.show_name,callback:function(t){e.$set(e.form,"show_name",t)},expression:"form.show_name"}})],1),e._v(" "),i("el-form-item",{attrs:{label:"权限字符串"}},[i("el-input",{attrs:{autocomplete:"off",disabled:e.form.id>0},model:{value:e.form.name,callback:function(t){e.$set(e.form,"name",t)},expression:"form.name"}})],1)],1),e._v(" "),i("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[i("el-button",{on:{click:function(t){e.formVisible=!1}}},[e._v("取 消")]),e._v(" "),i("el-button",{attrs:{type:"primary"},on:{click:e.doSubmit}},[e._v("确 定")])],1)],1)],1)},staticRenderFns:[]};var c=i("VU/8")(r,l,!1,function(e){i("3em6")},"data-v-03d61be8",null);t.default=c.exports}});
//# sourceMappingURL=15.d1a06b930f0c130e5fd4.js.map