webpackJsonp([11],{"9NoG":function(t,e){},gYjH:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=s("Xxa5"),i=s.n(n),a=s("exGp"),r=s.n(a),o=s("woOf"),l=s.n(o),c=s("gyMJ"),u={data:function(){return{total:0,params:{page:1,page_size:10},tableData:[],formVisible:!1,formTitle:"添加角色",form:{id:"",name:""}}},computed:{types:function(){return this.$store.getters.activityTypes}},methods:{editRole:function(t){this.formVisible=!0,this.form=l()(this.form,{id:t.id,name:t.name})},handleSubmit:function(){var t=this;return r()(i.a.mark(function e(){return i.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,c.a.saveRole(t.form);case 2:if(!e.sent.success){e.next=7;break}return t.formVisible=!1,e.next=7,t.loadRoles();case 7:case"end":return e.stop()}},e,t)}))()},viewRoleUsers:function(t){this.$store.dispatch(this.$types.PRIVILEGE_CURRENT_ROLE,t),this.$router.push("/privileges/roles/users")},editRolePermissions:function(t){this.$store.dispatch(this.$types.PRIVILEGE_CURRENT_ROLE,t),this.$router.push("/privileges/roles/permissions?role_id="+t.id)},handleDelete:function(t){var e=this;this.$confirm("确认删除该角色?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then(r()(i.a.mark(function s(){var n;return i.a.wrap(function(s){for(;;)switch(s.prev=s.next){case 0:return s.next=2,c.a.deleteRole({id:t.id});case 2:if(!(n=s.sent).success){s.next=9;break}return e.$message({type:"success",message:"删除成功!"}),s.next=7,e.loadRoles();case 7:s.next=10;break;case 9:e.$message({type:"info",message:n.error});case 10:case"end":return s.stop()}},s,e)}))).catch(function(){})},loadRoles:function(){var t=this;return r()(i.a.mark(function e(){var s;return i.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,c.a.getRoles(t.params);case 2:s=e.sent,t.tableData=s.data;case 4:case"end":return e.stop()}},e,t)}))()}},mounted:function(){var t=this;return r()(i.a.mark(function e(){return i.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.loadRoles();case 2:case"end":return e.stop()}},e,t)}))()}},f={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"l-block"},[s("div",{directives:[{name:"title",rawName:"v-title",value:"角色管理",expression:"'角色管理'"}]}),t._v(" "),s("div",{staticClass:"l-block-header"},[s("el-button",{attrs:{type:"primary",size:"small"},on:{click:function(e){t.formVisible=!0}}},[s("i",{staticClass:"iconfont"},[t._v("")]),t._v(" 添加")])],1),t._v(" "),s("div",{staticClass:"l-block-body"},[s("el-table",{staticStyle:{width:"100%"},attrs:{border:"",data:t.tableData,"cell-class-name":"cell-class","header-cell-class-name":"cell-class"}},[s("el-table-column",{attrs:{prop:"name",label:"角色名"}}),t._v(" "),s("el-table-column",{attrs:{prop:"guard_name",label:"guard",width:"120"}}),t._v(" "),s("el-table-column",{attrs:{fixed:"right",label:"操作"},scopedSlots:t._u([{key:"default",fn:function(e){return[s("el-button",{staticClass:"l-inline-btn",attrs:{type:"text",size:"medium"},on:{click:function(s){return t.editRole(e.row)}}},[s("i",{staticClass:"iconfont"},[t._v("")]),t._v("编辑")]),t._v(" "),s("el-button",{staticClass:"l-inline-btn",attrs:{type:"text",size:"medium"},on:{click:function(s){return t.handleDelete(e.row)}}},[s("i",{staticClass:"iconfont"},[t._v("")]),t._v("删除")]),t._v(" "),s("el-button",{staticClass:"l-inline-btn",attrs:{type:"text",size:"medium"},on:{click:function(s){return t.editRolePermissions(e.row)}}},[s("i",{staticClass:"iconfont"},[t._v("")]),t._v("权限")]),t._v(" "),s("el-button",{staticClass:"l-inline-btn",attrs:{type:"text",size:"medium"},on:{click:function(s){return t.viewRoleUsers(e.row)}}},[s("i",{staticClass:"iconfont"},[t._v("")]),t._v("成员")])]}}])})],1)],1),t._v(" "),s("div",{staticClass:"l-delimiter"}),t._v(" "),s("el-dialog",{attrs:{title:t.formTitle,visible:t.formVisible,"close-on-click-modal":!1},on:{"update:visible":function(e){t.formVisible=e}}},[s("el-form",{attrs:{model:t.form,"label-width":"80px"}},[s("el-form-item",{attrs:{label:"角色名称"}},[s("el-input",{attrs:{autocomplete:"off"},model:{value:t.form.name,callback:function(e){t.$set(t.form,"name",e)},expression:"form.name"}})],1)],1),t._v(" "),s("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[s("el-button",{on:{click:function(e){t.formVisible=!1}}},[t._v("取 消")]),t._v(" "),s("el-button",{attrs:{type:"primary"},on:{click:t.handleSubmit}},[t._v("确 定")])],1)],1)],1)},staticRenderFns:[]};var m=s("VU/8")(u,f,!1,function(t){s("9NoG")},"data-v-51152455",null);e.default=m.exports}});
//# sourceMappingURL=11.67bc3e320dfbcd982446.js.map