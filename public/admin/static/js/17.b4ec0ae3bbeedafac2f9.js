webpackJsonp([17],{"1f4L":function(e,t){},MPvX:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=a("Xxa5"),n=a.n(r),l=a("exGp"),s=a.n(l),i=a("gyMJ"),o={data:function(){return{loading:!1,total:0,page:1,page_size:10,orders:[]}},components:{pager:a("TvJ3").a},methods:{getOrders:function(){var e=this;return s()(n.a.mark(function t(){var a,r,l,s,o,c;return n.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return a=e.page,r=e.page_size,t.next=4,i.a.getOrders({page:a,page_size:r});case 4:l=t.sent,s=l.data,o=s.total,c=s.orders,e.loading=!1,e.orders=c,e.total=o;case 9:case"end":return t.stop()}},t,e)}))()},currentChange:function(e){var t=this;return s()(n.a.mark(function a(){return n.a.wrap(function(a){for(;;)switch(a.prev=a.next){case 0:t.page=e,t.getOrders();case 2:case"end":return a.stop()}},a,t)}))()}},created:function(){this.getOrders()}},c={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("div",{directives:[{name:"title",rawName:"v-title",value:"订单管理",expression:"'订单管理'"}]}),e._v(" "),a("div",{staticClass:"l-block"},[e._m(0),e._v(" "),a("div",{staticClass:"l-block-body"},[a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],staticStyle:{width:"100%"},attrs:{data:e.orders}},[a("el-table-column",{attrs:{prop:"id",label:"ID",width:"100"}}),e._v(" "),a("el-table-column",{attrs:{prop:"user.name",label:"用户",width:"100"}}),e._v(" "),a("el-table-column",{attrs:{prop:"name",label:"商品名"}}),e._v(" "),a("el-table-column",{attrs:{prop:"order_no",label:"订单号",width:"200"}}),e._v(" "),a("el-table-column",{attrs:{prop:"money",label:"订单金额",width:"80"}}),e._v(" "),a("el-table-column",{attrs:{prop:"status_text",label:"状态",width:"80"}}),e._v(" "),a("el-table-column",{attrs:{prop:"gateway_text",label:"付款方式",width:"80"}}),e._v(" "),a("el-table-column",{attrs:{prop:"created_at",label:"创建时间",width:"180"}})],1)],1)]),e._v(" "),a("pager",{attrs:{total:e.total,"page-size":e.page_size},on:{"current-change":e.currentChange}})],1)},staticRenderFns:[function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"l-block-header"},[t("div",[this._v("\n                    订单管理\n                    ")]),this._v(" "),t("div")])}]};var d=a("VU/8")(o,c,!1,function(e){a("1f4L")},"data-v-3975eb4f",null);t.default=d.exports}});
//# sourceMappingURL=17.b4ec0ae3bbeedafac2f9.js.map