webpackJsonp([8],{"4COB":function(e,t){},"zq/K":function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=r("BO1k"),a=r.n(n),s=r("gRE1"),i=r.n(s),o=r("Xxa5"),l=r.n(o),c=r("exGp"),d=r.n(c),m=r("4gwz"),p=r("0XjM"),u=r.n(p),f=r("gyMJ"),v=(r("DmJO"),{components:{DepartmentTree:m.a,TreeSelect:u.a},data:function(){return{updated:0,department:{},departments:[],departmentsTree:[],form:{id:"",name:"",parent_id:null,manager:""}}},computed:{showForm:function(){return!0;//!(this.department.children && this.department.children.length)
}},methods:{saveDepartment:function(){var e=this;return d()(l.a.mark(function t(){var r;return l.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,f.a.sniperSaveDepartment(e.form);case 2:return r=t.sent,t.abrupt("return",r);case 4:case"end":return t.stop()}},t,e)}))()},remove:function(){var e=this,t=this.department.id;this.$confirm("确定删除部门?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then(d()(l.a.mark(function r(){return l.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,f.a.sniperDeleteDepartment({id:t});case 2:r.sent.hasError||(e.showMessage("删除成功！","success"),e.updated=Math.random());case 4:case"end":return r.stop()}},r,e)})))},edit:function(){this.assignForm(this.department)},save:function(){var e=this;return d()(l.a.mark(function t(){var r;return l.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.saveDepartment();case 2:(r=t.sent).hasError?e.showMessage(r.error):(e.showMessage("更新成功！","success"),e.updated=Math.random());case 4:case"end":return t.stop()}},t,e)}))()},assignForm:function(e){this.form.id=e.id,this.form.name=e.name,this.form.parent_id=e.parent_id,this.form.manager=e.manager},normalizer:function(e){return{id:e.id,label:e.name,children:e.children}},handleNodeClick:function(e){this.department=e,this.assignForm(e),console.log(e)},performTreeLoaded:function(e){this.department=e,this.assignForm(e)},departmentDetail:function(e){this.department=e,this.assignForm(e)},add:function(){var e=this.department.id;this.$router.push("/sniper/employee/department/edit?parent_id="+e)},getDepartmentsTree:function(){var e=this;return d()(l.a.mark(function t(){var r,n;return l.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return e.departments=[],t.next=3,f.a.sniperGetDepartmentsTreeSelect();case 3:r=t.sent,n=i()(r.data)[0],function e(t){if(t.children.length){var r=!0,n=!1,s=void 0;try{for(var i,o=a()(t.children);!(r=(i=o.next()).done);r=!0){e(i.value)}}catch(e){n=!0,s=e}finally{try{!r&&o.return&&o.return()}finally{if(n)throw s}}}else t.children=void 0}(n),e.departments=[n];case 8:case"end":return t.stop()}},t,e)}))()}},mounted:function(){var e=this;return d()(l.a.mark(function t(){return l.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.getDepartmentsTree();case 2:case"end":return t.stop()}},t,e)}))()}}),h={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"l-position-list"},[r("div",{directives:[{name:"title",rawName:"v-title",value:"部门管理",expression:"'部门管理'"}]}),e._v(" "),r("department-tree",{attrs:{updated:e.updated},on:{nodeClick:e.handleNodeClick,treeLoaded:e.performTreeLoaded}}),e._v(" "),r("div",{staticClass:"l-block"},[r("div",{staticClass:"l-block-header"},[r("div",{staticClass:"l-flex"},[r("span",[r("i",{staticClass:"iconfont"},[e._v("")]),e._v(" "+e._s(e.department.hasOwnProperty("name")?e.department.name:""))]),e._v(" "),r("el-button-group",[e.showForm?r("el-button",{attrs:{type:"primary",size:"small"},on:{click:e.save}},[e._v("保存")]):e._e(),e._v(" "),e.showForm?e._e():r("el-button",{attrs:{type:"primary",size:"small"},on:{click:e.edit}},[e._v("编辑")]),e._v(" "),r("el-button",{attrs:{type:"danger",size:"small"},on:{click:e.remove}},[e._v("删除")]),e._v(" "),r("el-button",{attrs:{type:"success",size:"small"},on:{click:e.add}},[r("i",{staticClass:"iconfont"},[e._v("")]),e._v("新增")])],1)],1)]),e._v(" "),r("div",{staticClass:"l-block-body"},[e.showForm?r("div",[r("el-form",{ref:"form",staticStyle:{width:"50%","overflow-y":"visible"},attrs:{model:e.form,"label-width":"80px"}},[r("el-form-item",{attrs:{label:"部门名称"}},[r("el-input",{model:{value:e.form.name,callback:function(t){e.$set(e.form,"name",t)},expression:"form.name"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"上级部门"}},[r("tree-select",{attrs:{multiple:!1,options:e.departments,"default-expand-level":10,normalizer:e.normalizer},model:{value:e.form.parent_id,callback:function(t){e.$set(e.form,"parent_id",t)},expression:"form.parent_id"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"经    理"}},[r("el-input",{model:{value:e.form.manager,callback:function(t){e.$set(e.form,"manager",t)},expression:"form.manager"}})],1)],1)],1):e._e(),e._v(" "),e.department.children&&e.department.children.length?r("div",{staticStyle:{"margin-top":"20px"}},[r("el-divider",{attrs:{"content-position":"left"}},[e._v("直属部门")]),e._v(" "),r("div",{staticClass:"l-department-wrap"},e._l(e.department.children,function(t,n){return r("div",{key:n,staticClass:"l-department",on:{click:function(r){return e.departmentDetail(t)}}},[r("h1",{staticClass:"l-title"},[e._v(e._s(t.name))]),e._v(" "),r("article",{staticClass:"l-employee-count"})])}),0)],1):e._e()])])],1)},staticRenderFns:[]};var _=r("VU/8")(v,h,!1,function(e){r("4COB")},"data-v-e21e8a28",null);t.default=_.exports}});
//# sourceMappingURL=8.ff12aa35bdc96b386a64.js.map