webpackJsonp([23],{"6dud":function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var o=a("Xxa5"),r=a.n(o),n=a("exGp"),l=a.n(n),i=a("mvHQ"),s=a.n(i),c=a("woOf"),u=a.n(c),m=a("gyMJ"),d={data:function(){return{w:"80px",loading:!0,tableData:[],formVisible:!1,form:{id:"",type:"",name:"",extra:{options:!1}}}},methods:{handleEdit:function(e){this.formVisible=!0,u()(this.form,e)},handleDelete:function(e){alert(s()(e))},add:function(){this.formVisible=!0,u()(this.form,{name:"",type:""})},submit:function(){var e=this;return l()(r.a.mark(function t(){var a,o;return r.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,m.a.saveModelFieldType(e.form);case 2:(a=t.sent).success?(e.loading=!0,e.loadTypes(),e.formVisible=!1,o="添加成功!",e.form.id&&(o="编辑成功!"),e.$message({message:o,type:"success"})):e.$message({message:a.error,type:"warning"});case 4:case"end":return t.stop()}},t,e)}))()},loadTypes:function(){var e=this;return l()(r.a.mark(function t(){var a;return r.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,m.a.getModelFieldTypes();case 2:a=t.sent,e.loading=!1,e.tableData=a.data;case 5:case"end":return t.stop()}},t,e)}))()}},created:function(){var e=this;return l()(r.a.mark(function t(){return r.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.loadTypes();case 2:case"end":return t.stop()}},t,e)}))()}},f={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("div",{directives:[{name:"title",rawName:"v-title",value:"字段类型",expression:"'字段类型'"}]}),e._v(" "),a("div",{staticClass:"l-top-menu"},[a("div",[a("el-button",{attrs:{type:"primary",size:"small"},on:{click:e.add}},[e._v("新增")])],1),e._v(" "),a("div")]),e._v(" "),a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],staticStyle:{width:"100%"},attrs:{data:e.tableData}},[a("el-table-column",{attrs:{prop:"id",label:"ID",width:"100"}}),e._v(" "),a("el-table-column",{attrs:{prop:"type",label:"字段"}}),e._v(" "),a("el-table-column",{attrs:{prop:"name",label:"名称"}}),e._v(" "),a("el-table-column",{attrs:{label:"操作"},scopedSlots:e._u([{key:"default",fn:function(t){return[a("el-button",{attrs:{type:"text",size:"small"},on:{click:function(a){return e.handleEdit(t.row)}}},[e._v("编辑")]),e._v(" "),a("el-button",{attrs:{type:"text",size:"small"},on:{click:function(a){return e.handleDelete(t.row)}}},[e._v("删除")])]}}])})],1),e._v(" "),a("el-dialog",{attrs:{title:"添加类型",visible:e.formVisible,"close-on-click-modal":!1},on:{"update:visible":function(t){e.formVisible=t}}},[a("el-form",{attrs:{model:e.form}},[a("el-form-item",{attrs:{label:"名称","label-width":e.w}},[a("el-input",{attrs:{autocomplete:"off"},model:{value:e.form.name,callback:function(t){e.$set(e.form,"name",t)},expression:"form.name"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"字段","label-width":e.w}},[a("el-input",{attrs:{autocomplete:"off"},model:{value:e.form.type,callback:function(t){e.$set(e.form,"type",t)},expression:"form.type"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"带选项","label-width":e.w}},[a("el-radio",{attrs:{label:!1},model:{value:e.form.extra.options,callback:function(t){e.$set(e.form.extra,"options",t)},expression:"form.extra.options"}},[e._v("否")]),e._v(" "),a("el-radio",{attrs:{label:!0},model:{value:e.form.extra.options,callback:function(t){e.$set(e.form.extra,"options",t)},expression:"form.extra.options"}},[e._v("是")])],1)],1),e._v(" "),a("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(t){e.formVisible=!1}}},[e._v("取 消")]),e._v(" "),a("el-button",{attrs:{type:"primary"},on:{click:e.submit}},[e._v("确 定")])],1)],1)],1)},staticRenderFns:[]};var p=a("VU/8")(d,f,!1,function(e){a("7PZd")},"data-v-3e2ecb23",null);t.default=p.exports},"7PZd":function(e,t){}});
//# sourceMappingURL=23.91f8338c744535568f5c.js.map