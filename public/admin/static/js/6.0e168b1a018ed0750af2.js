webpackJsonp([6],{Eiyj:function(t,e){},RD01:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=n("mvHQ"),s=n.n(a),c=n("Xxa5"),r=n.n(c),o=n("exGp"),i=n.n(o),l=n("gyMJ"),v={data:function(){return{content:{},total:0,per_page:4,page:1,content_id:0}},components:{pager:n("TvJ3").a},watch:{content_id:function(t){var e=this;return i()(r.a.mark(function n(){return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:if(!t){n.next=4;break}return e.page=1,n.next=4,e.getComments();case 4:case"end":return n.stop()}},n,e)}))()}},methods:{goback:function(){this.$router.push("/cms/comment")},getComments:function(){var t=this;return i()(r.a.mark(function e(){var n,a,c,o,i;return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return n=t.page,a=t.per_page,c=t.content_id,e.next=5,l.a.getContentComments({page:n,per_page:a,content_id:c});case 5:o=e.sent,i=o.data,console.log("特定文章",s()(i)),t.content=i;case 9:case"end":return e.stop()}},e,t)}))()},currentChange:function(t){var e=this;return i()(r.a.mark(function n(){return r.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:e.page=t,e.getComments();case 2:case"end":return n.stop()}},n,e)}))()}},created:function(){var t=this;return i()(r.a.mark(function e(){return r.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:t.content_id=parseInt(t.$route.query.content_id||0);case 1:case"end":return e.stop()}},e,t)}))()}},u={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"l-comments l-block"},[n("div",{directives:[{name:"title",rawName:"v-title",value:"文章评论",expression:"'文章评论'"}]}),t._v(" "),n("div",{staticClass:"l-block-header"},[n("div",[n("span",{staticClass:"l-go-back",on:{click:t.goback}},[n("span",{staticClass:"iconfont"},[t._v("")]),t._v("返回")]),t._v(" "),n("el-divider",{attrs:{direction:"vertical"}}),t._v(" "),n("span",[t._v("文章下的评论")])],1)]),t._v(" "),n("div",{staticClass:"l-comment-item l-block-body l-mt-15"},[n("div",{staticClass:"l-comment-head"},[t.content.channel?n("a",{staticClass:"l-content-title",attrs:{target:"_blank",href:t.content.link}},[t._v("\n                    ["+t._s(t.content.channel.name)+"]"+t._s(t.content.title)+"\n                ")]):t._e()]),t._v(" "),t._l(t.content.comments,function(e){return[n("div",{staticClass:"l-comment-block"},[n("div",{staticClass:"l-comment"},[n("span",{staticClass:"lighter"},[t._v("评论内容:")]),t._v(t._s(e.content))]),t._v(" "),n("div",{staticClass:"l-comment-foot"},[n("el-row",[n("el-col",{attrs:{span:3}},[n("span",{staticClass:"lighter"},[t._v("评论者:")]),t._v(" "+t._s(e.user.name))]),t._v(" "),n("el-col",{attrs:{span:6}},[n("span",{staticClass:"lighter"},[t._v("评论时间:")]),t._v(" "+t._s(e.created_at))]),t._v(" "),n("el-col",{attrs:{span:6}},[n("span",{staticClass:"lighter"},[t._v("评论IP:"+t._s(e.ip))])])],1)],1)])]})],2)])},staticRenderFns:[]};var p=n("VU/8")(v,u,!1,function(t){n("Eiyj")},"data-v-862e9550",null);e.default=p.exports}});
//# sourceMappingURL=6.0e168b1a018ed0750af2.js.map