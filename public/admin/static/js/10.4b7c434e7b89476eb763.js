webpackJsonp([10],{m4Ix:function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=r("BO1k"),a=r.n(n),s=r("gRE1"),i=r.n(s),o=r("bOdI"),c=r.n(o),l=r("Xxa5"),u=r.n(l),m=r("exGp"),f=r.n(m),p=r("gyMJ"),d=r("0XjM"),v=r.n(d),h=(r("DmJO"),{components:{TreeSelect:v.a},data:function(){return{value:null,form:{id:0,name:"",parent_id:null,manager:""},departments:[]}},watch:c()({},"form.id",function(e){var t=this;return f()(u.a.mark(function r(){return u.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,t.getDepartmentDetail(e);case 2:case"end":return r.stop()}},r,t)}))()}),methods:{getDepartmentDetail:function(e){var t=this;return f()(u.a.mark(function r(){var n,a;return u.a.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,p.a.sniperGetDepartmentDetail({id:e});case 2:n=r.sent,a=n.data,t.form.id=a.id,t.form.name=a.name,t.form.parent_id=a.parent_id,t.form.manager=a.manager;case 8:case"end":return r.stop()}},r,t)}))()},normalizer:function(e){return{id:e.id,label:e.name,children:e.children}},viewDepartments:function(){this.$router.push("/basic/department")},save:function(){var e=this;return f()(u.a.mark(function t(){var r;return u.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.saveDepartment();case 2:(r=t.sent).hasError?e.showMessage(r.error):(e.showMessage("添加成功！","success"),e.$router.push("/basic/department"));case 4:case"end":return t.stop()}},t,e)}))()},getDepartments:function(){var e=this;return f()(u.a.mark(function t(){var r,n;return u.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,p.a.sniperGetDepartmentsTreeSelect();case 2:r=t.sent,n=i()(r.data)[0],function e(t){if(t.children.length){var r=!0,n=!1,s=void 0;try{for(var i,o=a()(t.children);!(r=(i=o.next()).done);r=!0){e(i.value)}}catch(e){n=!0,s=e}finally{try{!r&&o.return&&o.return()}finally{if(n)throw s}}}else t.children=void 0}(n),e.departments=[n];case 7:case"end":return t.stop()}},t,e)}))()},saveDepartment:function(){var e=this;return f()(u.a.mark(function t(){var r;return u.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,p.a.sniperSaveDepartment(e.form);case 2:return r=t.sent,t.abrupt("return",r);case 4:case"end":return t.stop()}},t,e)}))()}},mounted:function(){var e=this;return f()(u.a.mark(function t(){var r;return u.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:e.getDepartments(),e.form.id=parseInt(e.$route.query.id)||0,(r=parseInt(e.$route.query.parent_id)||0)&&(e.form.parent_id=r);case 4:case"end":return t.stop()}},t,e)}))()}}),w={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",[r("div",{directives:[{name:"title",rawName:"v-title",value:"新增部门",expression:"'新增部门'"}]}),e._v(" "),r("div",{staticClass:"l-block"},[r("div",{staticClass:"l-block-header"},[r("div",{staticClass:"l-flex"},[r("span",[e._v("员工系统 / "),r("span",{staticStyle:{cursor:"pointer"},on:{click:e.viewDepartments}},[e._v("部门管理")]),e._v(" / 新增部门")]),e._v(" "),r("el-button",{attrs:{type:"primary"},on:{click:e.save}},[e._v("保存")])],1)]),e._v(" "),r("div",{staticClass:"l-block-body"},[r("el-form",{ref:"form",staticStyle:{width:"50%","overflow-y":"visible"},attrs:{model:e.form,"label-width":"80px"}},[r("el-form-item",{attrs:{label:"部门名称"}},[r("el-input",{model:{value:e.form.name,callback:function(t){e.$set(e.form,"name",t)},expression:"form.name"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"上级部门"}},[r("tree-select",{attrs:{multiple:!1,options:e.departments,"default-expand-level":10,normalizer:e.normalizer},model:{value:e.form.parent_id,callback:function(t){e.$set(e.form,"parent_id",t)},expression:"form.parent_id"}})],1),e._v(" "),r("el-form-item",{attrs:{label:"经    理"}},[r("el-input",{model:{value:e.form.manager,callback:function(t){e.$set(e.form,"manager",t)},expression:"form.manager"}})],1)],1)],1)])])},staticRenderFns:[]};var x=r("VU/8")(h,w,!1,function(e){r("n8iv")},"data-v-95cf38e0",null);t.default=x.exports},n8iv:function(e,t){}});
//# sourceMappingURL=10.4b7c434e7b89476eb763.js.map