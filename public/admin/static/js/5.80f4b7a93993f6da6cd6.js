webpackJsonp([5],{LRjb:function(t,e){},idzw:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=n("Xxa5"),a=n.n(i),o=n("exGp"),s=n.n(o),r=n("gRE1"),l=n.n(r),c=n("Dd8w"),d=n.n(c),u=n("gyMJ"),p=n("NYxO"),f={data:function(){return{customProps:{children:"children",label:"name"},treeData:[]}},props:{title:{type:String,default:""},selectedKey:{type:Number,default:0}},watch:{},computed:d()({},Object(p.b)([])),methods:{handleNodeClick:function(t){this.$emit("nodeClick",t)}},mounted:function(){var t=this;return s()(a.a.mark(function e(){var n;return a.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,u.a.sniperGetPositionDescendants();case 2:n=e.sent,t.treeData=[l()(n.data)[0]],t.$emit("treeLoaded",t.treeData[0]);case 5:case"end":return e.stop()}},e,t)}))()}},v={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"l-tree-container"},[t.title?n("view",[t._v(t._s(t.title))]):t._e(),t._v(" "),n("el-tree",{ref:"tree",attrs:{"icon-class":"el-icon-caret-right","default-expand-all":!0,data:t.treeData,"node-key":"id",props:t.customProps,"highlight-current":!0,"expand-on-click-node":!1},on:{"node-click":t.handleNodeClick},scopedSlots:t._u([{key:"default",fn:function(e){var i=e.node,a=e.data;return n("span",{staticClass:"custom-tree-node"},[n("span",[a.children.length?t._e():n("span",{staticClass:"iconfont"},[t._v("")]),t._v(t._s(i.label))])])}}])})],1)},staticRenderFns:[]};var h={components:{PositionTree:n("VU/8")(f,v,!1,function(t){n("LRjb")},null,null).exports},data:function(){return{id:0,position:{},loading:!1}},methods:{performTreeLoaded:function(t){this.position=t},handleNodeClick:function(t){var e=t;this.position=e},edit:function(){this.$router.push("/sniper/employee/position/edit?id="+this.position.id)},add:function(){var t=this.position.id;this.$router.push("/sniper/employee/position/edit?parent_id="+t)},editPosition:function(t){var e=t.id;this.$router.push("/sniper/employee/position/edit?id="+e)},addPosition:function(t){var e=t.id;this.$router.push("/sniper/employee/position/edit?parent_id="+e)},deletePosition:function(t){var e=this,n=t.id;return s()(a.a.mark(function t(){return a.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:e.$confirm("确定删除职位?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then(s()(a.a.mark(function t(){return a.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,u.a.sniperDeletePosition({id:n});case 2:t.sent.hasError||(e.showMessage("删除成功！","success"),e.position.children=e.position.children.filter(function(t){return t.id!=n}));case 4:case"end":return t.stop()}},t,e)})));case 1:case"end":return t.stop()}},t,e)}))()}},mounted:function(){var t=this;return s()(a.a.mark(function e(){return a.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:t.id=parseInt(t.$route.query.id)||0;case 1:case"end":return e.stop()}},e,t)}))()}},m={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"l-position-list"},[n("div",{directives:[{name:"title",rawName:"v-title",value:"职位管理",expression:"'职位管理'"}]}),t._v(" "),n("position-tree",{attrs:{selectedKey:2},on:{nodeClick:t.handleNodeClick,treeLoaded:t.performTreeLoaded}}),t._v(" "),n("div",{staticClass:"l-tree-content"},[n("div",{staticClass:"l-block"},[n("div",{staticClass:"l-block-header",staticStyle:{"padding-right":"20px"}},[n("div",{staticClass:"l-flex"},[n("span",[n("i",{staticClass:"iconfont"},[t._v("")]),t._v(" "+t._s(t.position.hasOwnProperty("name")?t.position.name:""))]),t._v(" "),n("el-button-group",[n("el-button",{attrs:{type:"primary",size:"small"},on:{click:t.edit}},[n("i",{staticClass:"iconfont"},[t._v("")]),t._v("编辑")]),t._v(" "),n("el-button",{attrs:{type:"success",size:"small"},on:{click:t.add}},[n("i",{staticClass:"iconfont"},[t._v("")]),t._v("新增")])],1)],1)]),t._v(" "),n("div",{staticClass:"l-block-body"},[n("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticStyle:{width:"100%"},attrs:{data:t.position.children}},[n("el-table-column",{attrs:{prop:"id",label:"ID",width:"80"}}),t._v(" "),n("el-table-column",{attrs:{prop:"name",label:"职位名"}}),t._v(" "),n("el-table-column",{attrs:{prop:"parent.name",label:"上级职位名"}}),t._v(" "),n("el-table-column",{attrs:{prop:"department.name",label:"所属部门"}}),t._v(" "),n("el-table-column",{attrs:{prop:"desiring",label:"所需员工"}}),t._v(" "),n("el-table-column",{attrs:{label:"操作"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("el-button",{attrs:{type:"text"},on:{click:function(n){return t.editPosition(e.row)}}},[t._v("编辑")]),t._v(" "),n("el-button",{attrs:{type:"text"},on:{click:function(n){return t.deletePosition(e.row)}}},[t._v("删除")])]}}])})],1)],1)])])],1)},staticRenderFns:[]};var _=n("VU/8")(h,m,!1,function(t){n("sOsg")},"data-v-7b83cffa",null);e.default=_.exports},sOsg:function(t,e){}});
//# sourceMappingURL=5.80f4b7a93993f6da6cd6.js.map