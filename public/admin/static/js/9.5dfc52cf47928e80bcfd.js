webpackJsonp([9],{TGAd:function(e,t){},js6L:function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=r("mvHQ"),s=r.n(n),a=r("fZjL"),i=r.n(a),o=r("Xxa5"),c=r.n(o),l=r("exGp"),u=r.n(l),d=r("gyMJ"),f={data:function(){return{emptyText:"loading...",role_id:null,role_name:null,defaultCheckedKeys:[],total:0,tableData:[],customProps:{children:"children",label:"show_name"},treeData:[],current:null,dialogFormVisible:!1,title:"添加子权限",form:{id:"",parent_id:"",name:"",show_name:""}}},computed:{types:function(){return this.$store.getters.activityTypes},currentRole:function(){return this.$store.getters.currentRole}},watch:{role_id:function(e){this.loadRolePermissions(e)}},methods:{saveRolePermissions:function(){var e=this;return u()(c.a.mark(function t(){var r,n,s;return c.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return r=e.$refs["role-permission-tree"].getCheckedNodes(),n=r.filter(function(e){return 0==e.children.length}).map(function(e){return e.id}),s=e.currentRole.id,t.next=5,d.a.givePermissionsTo({permissions:n,role_id:s});case 5:t.sent,e.$message({type:"success",message:"设置成功!"});case 7:case"end":return t.stop()}},t,e)}))()},loadPermissionsTree:function(){var e=this;return u()(c.a.mark(function t(){var r;return c.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,d.a.getPermissionsTree();case 2:r=t.sent,e.treeData=[r.data[i()(r.data)[0]]];case 4:case"end":return t.stop()}},t,e)}))()},loadRolePermissions:function(e){var t=this;return u()(c.a.mark(function r(){var n;return c.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,d.a.getRolePermissions({role_id:e});case 2:n=r.sent,t.defaultCheckedKeys=n.data;case 4:case"end":return r.stop()}},r,t)}))()},loadUserPermissions:function(){var e=this;return u()(c.a.mark(function t(){var r;return c.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,d.a.getUserPermissions();case 2:r=e.sent,localStorage.setItem("privileges",s()(r));case 4:case"end":return e.stop()}},t,e)}))()}},mounted:function(){var e=this;return u()(c.a.mark(function t(){return c.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return e.role_id=parseInt(e.$route.query.role_id||0),t.next=3,e.loadPermissionsTree();case 3:case"end":return t.stop()}},t,e)}))()}},p={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",[r("div",{staticClass:"top-buttons",staticStyle:{display:"flex","flex-flow":"row nowrap"}},[r("router-link",{attrs:{to:"/privileges/roles",tag:"div"}},[r("span",{staticClass:"iconfont"},[e._v("")]),e._v("返回")]),e._v(" "),r("el-divider",{attrs:{direction:"vertical"}}),e._v(" "),r("div",[e._v(e._s(e.role_name)+"权限")])],1),e._v(" "),r("div",[r("div",{staticStyle:{width:"60%"}},[r("el-tree",{ref:"role-permission-tree",attrs:{"empty-text":e.emptyText,data:e.treeData,"default-expand-all":"","show-checkbox":"","node-key":"id",props:e.customProps,"default-checked-keys":e.defaultCheckedKeys,"expand-on-click-node":!0,"check-on-click-node":!1},scopedSlots:e._u([{key:"default",fn:function(t){var n=t.node;return t.data,r("span",{staticClass:"custom-tree-node"},[r("span",[e._v(e._s(n.label))])])}}])})],1),e._v(" "),r("div",{staticClass:"l-delimiter"}),e._v(" "),r("el-button",{on:{click:e.saveRolePermissions}},[e._v("保存")])],1)])},staticRenderFns:[]};var v=r("VU/8")(f,p,!1,function(e){r("TGAd")},"data-v-b83b0f40",null);t.default=v.exports}});
//# sourceMappingURL=9.5dfc52cf47928e80bcfd.js.map