webpackJsonp([26],{"9Pj2":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=n("Xxa5"),i=n.n(a),r=n("exGp"),s=n.n(r),d=n("4gwz"),c=n("gyMJ"),o=n("0XjM"),l=n.n(o),u=(n("DmJO"),{components:{TreeSelect:l.a,DepartmentTree:d.a},data:function(){return{id:0,sub_id:0,value:null,department:{},departments:[]}},watch:{id:function(t){this.getDepartmentDetail(t)},sub_id:function(t){this.getDepartmentDetail(t)}},methods:{editDepartment:function(t){var e=t.id;this.$router.push("/basic/department/edit?id="+e)},handleNodeClick:function(t){this.sub_id=t[0].id},getDepartmentDetail:function(t){var e=this;return s()(i.a.mark(function n(){var a;return i.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,c.a.sniperGetDepartmentDetail({id:t});case 2:a=n.sent,e.department=a.data;case 4:case"end":return n.stop()}},n,e)}))()},viewDepartment:function(){this.$router.push("/basic/department")}},mounted:function(){var t=this;return s()(i.a.mark(function e(){return i.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:t.id=parseInt(t.$route.query.id||0);case 1:case"end":return e.stop()}},e,t)}))()}}),p={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",{directives:[{name:"title",rawName:"v-title",value:"部门详情",expression:"'部门详情'"}]}),t._v(" "),n("div",{staticClass:"l-block"},[n("div",{staticClass:"l-block-header"},[n("div",{staticClass:"l-flex"},[n("span",[t._v("员工系统 / "),n("span",{staticStyle:{cursor:"pointer"},on:{click:t.viewDepartment}},[t._v("部门管理")]),t._v(" / 部门详情")])])]),t._v(" "),n("div",{staticClass:"l-block-body l-content-list"},[n("department-tree",{attrs:{selectedKey:2,parent_id:t.id},on:{nodeClick:t.handleNodeClick}}),t._v(" "),n("div",{staticClass:"l-tree-content"},[n("div",{staticClass:"l-display"},[n("div",[n("b",[t._v("部门名称：")]),t._v(t._s(t.department.name))]),t._v(" "),n("div",[n("b",[t._v("部门经理：")]),t._v(t._s(t.department.manager))]),t._v(" "),t.department.parent?n("div",[n("b",[t._v("上级部门：")]),t._v(t._s(t.department.parent.name))]):t._e(),t._v(" "),n("div",[n("el-button",{attrs:{type:"primary"},on:{click:function(e){return t.editDepartment(t.department)}}},[t._v("修改")])],1)])])],1)])])},staticRenderFns:[]};var v=n("VU/8")(u,p,!1,function(t){n("TiS+")},"data-v-1ef4ff3d",null);e.default=v.exports},"TiS+":function(t,e){}});
//# sourceMappingURL=26.fb31f47cad0bb0e67dec.js.map