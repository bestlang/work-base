webpackJsonp([24],{"00fl":function(e,t){},YMpQ:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=n("fZjL"),a=n.n(r),s=n("Xxa5"),o=n.n(s),i=n("exGp"),l=n.n(i),c=n("woOf"),m=n.n(c),u=n("gyMJ"),d={data:function(){return{tableData:[],emptyText:"loading...",customProps:{children:"children",label:"show_name"},treeData:[],current:null,formVisible:!1,title:"添加子权限",form:{id:"",parent_id:"",name:"",show_name:""}}},methods:{edit:function(e){this.current=e;var t=e.id,n=e.parent_id,r=e.name,a=e.show_name;this.form={id:t,parent_id:n,name:r,show_name:a},this.formVisible=!0,this.title="编辑权限"},reset:function(){this.current=null,m()(this.form,{id:"",parent_id:"",name:"",show_name:""})},add:function(e){this.reset(),this.current=e,this.formVisible=!0},doSubmit:function(){this.form.id?this.doEdit():this.doAdd()},doAdd:function(){var e=this;return l()(o.a.mark(function t(){var n,r;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return n={show_name:e.form.show_name,disabled:!0,name:e.form.name,children:[]},e.current.children||e.$set(e.current,"children",[]),e.formVisible=!1,t.next=5,u.a.addPermission({parent_id:e.current.id,name:e.form.name,show_name:e.form.show_name});case 5:r=t.sent,n.id=r.data.id,e.current.children.push(n),r.success?(e.$message({type:"success",message:"添加成功!"}),e.reset()):e.formVisible=!0;case 9:case"end":return t.stop()}},t,e)}))()},doEdit:function(){var e=this;return l()(o.a.mark(function t(){return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,u.a.editPermission({id:e.form.id,name:e.form.name,show_name:e.form.show_name});case 2:t.sent,e.$message({type:"success",message:"修改成功!"}),e.current.name=e.form.name,e.current.show_name=e.form.show_name,e.reset(),e.formVisible=!1;case 8:case"end":return t.stop()}},t,e)}))()},remove:function(e){var t=this;this.$confirm("删除权限存在风险,是否继续?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then(l()(o.a.mark(function n(){return o.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,u.a.deletePermission({id:e.id});case 2:return n.sent,n.next=5,t.loadPermissionsTree();case 5:t.$message({type:"success",message:"删除成功!"});case 6:case"end":return n.stop()}},n,t)})))},handleCheckChange:function(e,t,n){return console.log(e,".............",t,".............",n),!0},loadPermissionsTree:function(){var e=this;return l()(o.a.mark(function t(){var n;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,u.a.getPermissionsTree({disabled:!0});case 2:n=t.sent,e.treeData=[n.data[a()(n.data)[0]]],e.tableData=e.treeData;case 5:case"end":return t.stop()}},t,e)}))()}},mounted:function(){var e=this;return l()(o.a.mark(function t(){return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.loadPermissionsTree();case 2:case"end":return t.stop()}},t,e)}))()}},f={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",[n("div",{directives:[{name:"title",rawName:"v-title",value:"权限管理",expression:"'权限管理'"}]}),e._v(" "),n("div",[n("div",{staticClass:"l-block"},[n("div",{staticClass:"l-block-header"},[e._v("所有权限")]),e._v(" "),n("div",{staticClass:"l-block-body"},[n("el-table",{staticStyle:{width:"100%","margin-bottom":"20px"},attrs:{data:e.tableData,"row-key":"id",border:"","tree-props":{children:"children",hasChildren:"hasChildren"}}},[n("el-table-column",{attrs:{prop:"show_name",label:"权限",sortable:"",width:"240"}}),e._v(" "),n("el-table-column",{attrs:{prop:"name",label:"权限字符串",sortable:""}}),e._v(" "),n("el-table-column",{attrs:{label:"操作"},scopedSlots:e._u([{key:"default",fn:function(t){return[n("span",[n("el-button",{attrs:{type:"text"},on:{click:function(){return e.edit(t.row)}}},[e._v("\n              编辑\n            ")]),e._v(" "),n("el-button",{attrs:{type:"text"},on:{click:function(){return e.add(t.row)}}},[e._v("\n              新增\n            ")]),e._v(" "),n("el-button",{attrs:{type:"text"},on:{click:function(){return e.remove(t.row)}}},[e._v("\n              删除\n            ")])],1)]}}])})],1)],1)])]),e._v(" "),n("el-dialog",{attrs:{title:e.title,visible:e.formVisible,"close-on-click-modal":!1},on:{"update:visible":function(t){e.formVisible=t}}},[n("el-form",{attrs:{model:e.form,"label-width":"100px"}},[n("el-form-item",{attrs:{label:"权限"}},[n("el-input",{attrs:{autocomplete:"off"},model:{value:e.form.show_name,callback:function(t){e.$set(e.form,"show_name",t)},expression:"form.show_name"}})],1),e._v(" "),n("el-form-item",{attrs:{label:"权限字符串"}},[n("el-input",{attrs:{autocomplete:"off",disabled:e.form.id>0},model:{value:e.form.name,callback:function(t){e.$set(e.form,"name",t)},expression:"form.name"}})],1)],1),e._v(" "),n("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[n("el-button",{on:{click:function(t){e.formVisible=!1}}},[e._v("取 消")]),e._v(" "),n("el-button",{attrs:{type:"primary"},on:{click:e.doSubmit}},[e._v("确 定")])],1)],1)],1)},staticRenderFns:[]};var h=n("VU/8")(d,f,!1,function(e){n("00fl")},"data-v-39427732",null);t.default=h.exports}});
//# sourceMappingURL=24.5393eeea5e88915e7783.js.map