webpackJsonp([8],{"27ez":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=n("Xxa5"),s=n.n(a),r=n("exGp"),c=n.n(r),o=n("gyMJ"),i={data:function(){return{comments:[],total:0,per_page:3,page:1}},components:{pager:n("TvJ3").a},methods:{loadComments:function(){var t=this;return c()(s.a.mark(function e(){var n,a,r,c;return s.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return n=t.page,a=t.per_page,e.next=4,o.a.getComments({page:n,per_page:a});case 4:r=e.sent,c=r.data,t.comments=c.data,t.total=parseInt(c.total),t.per_page=parseInt(c.per_page);case 9:case"end":return e.stop()}},e,t)}))()},currentChange:function(t){var e=this;return c()(s.a.mark(function n(){return s.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:e.page=t,e.loadComments();case 2:case"end":return n.stop()}},n,e)}))()},viewContentComment:function(t){this.$router.push("/cms/comment/content?content_id="+t.content_id)}},created:function(){var t=this;return c()(s.a.mark(function e(){return s.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.loadComments();case 2:case"end":return e.stop()}},e,t)}))()}},l={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"l-comments"},[n("div",{directives:[{name:"title",rawName:"v-title",value:"评论管理",expression:"'评论管理'"}]}),t._v(" "),t._l(t.comments,function(e){return n("div",[n("div",{staticClass:"l-comment-item"},[n("div",{staticClass:"l-comment-head"},[n("a",{staticClass:"l-content-title",attrs:{target:"_blank",href:e.ref.link}},[t._v("\n                    ["+t._s(e.ref.channel.name)+"]"+t._s(e.ref.title)+"\n                ")]),t._v(" "),n("span",{staticClass:"l-view-content",on:{click:function(n){return t.viewContentComment(e)}}},[t._v("查看本文评论")])]),t._v(" "),n("div",{staticClass:"l-comment"},[n("span",{staticClass:"lighter"},[t._v("评论内容:")]),t._v(t._s(e.content))]),t._v(" "),n("div",{staticClass:"l-comment-foot"},[n("el-row",[n("el-col",{attrs:{span:3}},[n("span",{staticClass:"lighter"},[t._v("评论者:")]),t._v(" "+t._s(e.user.name))]),t._v(" "),n("el-col",{attrs:{span:6}},[n("span",{staticClass:"lighter"},[t._v("评论时间:")]),t._v(" "+t._s(e.created_at))]),t._v(" "),n("el-col",{attrs:{span:6}},[n("span",{staticClass:"lighter"},[t._v("评论IP:"+t._s(e.ip))])])],1)],1)])])}),t._v(" "),n("pager",{attrs:{total:t.total,"page-size":t.per_page},on:{"current-change":t.currentChange}})],2)},staticRenderFns:[]};var p=n("VU/8")(i,l,!1,function(t){n("FndC")},"data-v-c05ecf9a",null);e.default=p.exports},FndC:function(t,e){}});
//# sourceMappingURL=8.ebf7f30db9843f5fe8a3.js.map