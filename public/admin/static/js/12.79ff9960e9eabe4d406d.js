webpackJsonp([12],{YHij:function(e,t){},glAp:function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=r("Xxa5"),o=r.n(a),s=r("exGp"),n=r.n(s),l=r("woOf"),i=r.n(l),c=r("gyMJ"),u={data:function(){return{showForm:!1,total:0,tableData:[],roleName:"",form:{role_id:this.$route.params.id,mobile:"",password:"",confirm_password:"",name:""}}},computed:{types:function(){return this.$store.getters.activityTypes},currentRole:function(){return this.$store.getters.currentRole}},methods:{addNewUser:function(){this.showForm=!0,i()(this.form,{mobile:"",password:"",confirm_password:"",name:""})},doAddNewUser:function(){var e=this;return n()(o.a.mark(function t(){var r;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,c.a.createRoleUser(e.form);case 2:if(!(r=t.sent).success){t.next=9;break}return t.next=6,e.loadRoleUsers();case 6:e.showForm=!1,t.next=10;break;case 9:e.$message({type:"error",message:r.error});case 10:case"end":return t.stop()}},t,e)}))()},handleRemove:function(e){var t=this;this.$confirm("确认移出该用户?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then(n()(o.a.mark(function r(){var a;return o.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,c.a.removeRoleModel(e.pivot);case 2:if(!(a=r.sent).success){r.next=8;break}return r.next=6,t.loadRoleUsers();case 6:r.next=9;break;case 8:t.$message({type:"error",message:a.error});case 9:case"end":return r.stop()}},r,t)}))).catch(function(){})},loadRoleUsers:function(){var e=this;return n()(o.a.mark(function t(){var r;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,c.a.getRoleUsers({id:e.currentRole.id});case 2:r=t.sent,e.roleName=r.data.name,e.tableData=r.data.users;case 5:case"end":return t.stop()}},t,e)}))()}},mounted:function(){var e=this;return n()(o.a.mark(function t(){return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.loadRoleUsers();case 2:case"end":return t.stop()}},t,e)}))()}},f={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",[r("div",{staticClass:"top-buttons",staticStyle:{display:"flex","flex-flow":"row nowrap","justify-content":"space-between"}},[r("div",{staticStyle:{display:"flex","flex-flow":"row nowrap"}},[r("router-link",{attrs:{to:"/privileges/roles",tag:"div"}},[r("span",{staticClass:"iconfont"},[e._v("")]),e._v("返回")]),e._v(" "),r("el-divider",{attrs:{direction:"vertical"}}),e._v(" "),r("div",[e._v("所属「"+e._s(e.roleName)+"」用户列表")])],1),e._v(" "),r("div",[r("el-button",{attrs:{type:"primary"},on:{click:e.addNewUser}},[r("i",{staticClass:"iconfont"},[e._v("")]),e._v(" 添加")])],1)]),e._v(" "),r("el-table",{staticStyle:{width:"100%"},attrs:{border:"",data:e.tableData,"cell-class-name":"cell-class","header-cell-class-name":"cell-class"}},[r("el-table-column",{attrs:{prop:"name",label:"昵称"}}),e._v(" "),r("el-table-column",{attrs:{prop:"mobile",label:"手机号"}}),e._v(" "),r("el-table-column",{attrs:{prop:"id",label:"id",width:"120"}}),e._v(" "),r("el-table-column",{attrs:{fixed:"right",label:"操作"},scopedSlots:e._u([{key:"default",fn:function(t){return[r("el-button",{staticClass:"l-inline-btn",attrs:{type:"text",size:"small"},on:{click:function(r){return e.handleRemove(t.row)}}},[e._v("移出")])]}}])})],1),e._v(" "),r("div",{staticClass:"l-delimiter"}),e._v(" "),r("el-dialog",{attrs:{title:"添加用户",visible:e.showForm,"close-on-click-modal":!1},on:{"update:visible":function(t){e.showForm=t}}},[r("el-form",{attrs:{model:e.form,"label-width":"80px"}},[r("el-form-item",{attrs:{label:"手机号"}},[r("el-input",{staticClass:"l-w-200",attrs:{autocomplete:"off"},model:{value:e.form.mobile,callback:function(t){e.$set(e.form,"mobile",t)},expression:"form.mobile"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"密码"}},[r("el-input",{staticClass:"l-w-200",attrs:{autocomplete:"off"},model:{value:e.form.password,callback:function(t){e.$set(e.form,"password",t)},expression:"form.password"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"确认密码"}},[r("el-input",{staticClass:"l-w-200",attrs:{autocomplete:"off"},model:{value:e.form.confirm_password,callback:function(t){e.$set(e.form,"confirm_password",t)},expression:"form.confirm_password"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"昵称"}},[r("el-input",{staticClass:"l-w-200",attrs:{autocomplete:"off"},model:{value:e.form.name,callback:function(t){e.$set(e.form,"name",t)},expression:"form.name"}})],1)],1),e._v(" "),r("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[r("el-button",{on:{click:function(t){e.showForm=!1}}},[e._v("取 消")]),e._v(" "),r("el-button",{attrs:{type:"primary"},on:{click:e.doAddNewUser}},[e._v("确 定")])],1)],1)],1)},staticRenderFns:[]};var m=r("VU/8")(u,f,!1,function(e){r("YHij")},"data-v-48afee92",null);t.default=m.exports}});
//# sourceMappingURL=12.79ff9960e9eabe4d406d.js.map