webpackJsonp([9],{"1ltO":function(t,e){},M7eE:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var l={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("el-table",{staticStyle:{width:"100%"},attrs:{data:t.tableData,border:"","cell-class-name":"cell-class","header-cell-class-name":"cell-class"}},[a("el-table-column",{attrs:{label:"图片",width:"100"},scopedSlots:t._u([{key:"default",fn:function(t){return[a("img",{staticClass:"table-img",attrs:{src:t.row.goods_thumbnail_url,alt:""}})]}}])}),t._v(" "),a("el-table-column",{attrs:{prop:"goods_name",label:"名称"}}),t._v(" "),a("el-table-column",{attrs:{prop:"goods_quantity",label:"购买数量",width:"80"}}),t._v(" "),a("el-table-column",{attrs:{label:"实付金额",width:"80"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n                "+t._s(e.row.order_amount/100)+"\n            ")]}}])}),t._v(" "),a("el-table-column",{attrs:{label:"订单状态",width:"80"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n                "+t._s(e.row.order_status_desc)+"\n            ")]}}])}),t._v(" "),a("el-table-column",{attrs:{prop:"order_sn",label:"订单编号",width:"160"}}),t._v(" "),a("el-table-column",{attrs:{prop:"custom_parameters",label:"自定参数",width:"80"}})],1),t._v(" "),a("div",[a("el-pagination",{attrs:{layout:"prev, pager, next",total:200}})],1)],1)},staticRenderFns:[]};var r=a("VU/8")({data:function(){return{params:{page:1,page_size:20},tableData:[]}},methods:{loadOrders:function(){var t=this;this.$http.get("/pdd/order/list/range/get",{params:this.params}).then(function(e){t.tableData=e.data})}},mounted:function(){this.loadOrders()}},l,!1,function(t){a("1ltO")},"data-v-46ec435b",null);e.default=r.exports}});
//# sourceMappingURL=9.0c27badc921e283e0235.js.map