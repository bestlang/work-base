webpackJsonp([23],{"5l2l":function(t,n){},ImSf:function(t,n){},NHnr:function(t,n,e){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var o={};e.d(o,"ACCESS_TOKEN",function(){return N}),e.d(o,"ACTIVITY_TYPES",function(){return R}),e.d(o,"ACTIVITY_APPLICABLES",function(){return w}),e.d(o,"PRIVILEGES",function(){return T}),e.d(o,"PRIVILEGE_CURRENT_ROLE",function(){return I}),e.d(o,"USER",function(){return A}),e.d(o,"LOADING",function(){return L}),e.d(o,"CMS_MODELS",function(){return P}),e.d(o,"CMS_CHANNELS",function(){return M}),e.d(o,"CMS_CHANNEL_CHILDREN",function(){return x}),e.d(o,"CMS_PARENT_CHANNEL",function(){return O}),e.d(o,"CMS_CURRENT_CHANNEL",function(){return $}),e.d(o,"CMS_CURRENT_MODEL",function(){return U}),e.d(o,"CMS_CONTENTS",function(){return V}),e.d(o,"CMS_CURRENT_CHANNEL_POSITION",function(){return H}),e.d(o,"CMS_CURRENT_POSITION",function(){return k});var i=e("7+uW"),a=e("zL8q"),s=e.n(a),c=(e("aEO6"),e("UBeP"),e("NYxO")),r=e("/ocq"),l={computed:{user:function(){return this.$store.getters[this.$types.USER]}},methods:{toggleCollapse:function(){this.$store.dispatch("toggleState")},logout:function(){var t=this;this.$http.post("auth/logout").then(function(n){200==n.code?(localStorage.removeItem(t.$types.USER),t.$store.commit(t.$types.ACCESS_TOKEN,null),t.$router.push("/login")):401==n.code&&t.$router.push("/login")})}}},u={render:function(){var t=this,n=t.$createElement,e=t._self._c||n;return e("div",{staticClass:"ls-top-wrap"},[e("div",{staticClass:"ls-top-left"},[e("div",{staticClass:"ls-icon-collapse",on:{click:t.toggleCollapse}},[e("i",{staticClass:"iconfont l-color"},[t._v("")])])]),t._v(" "),e("div",{staticClass:"ls-top-right"},[e("el-dropdown",[e("div",{staticClass:"logout"},[e("i",{staticClass:"iconfont"},[t._v(" ")]),t._v(t._s(t.user.name))]),t._v(" "),e("el-dropdown-menu",{attrs:{slot:"dropdown"},slot:"dropdown"},[e("el-dropdown-item",[e("div",{on:{click:t.logout}},[e("i",{staticClass:"iconfont"},[t._v(" ")]),t._v("登出")])]),t._v(" "),e("el-dropdown-item",[e("i",{staticClass:"iconfont"},[t._v(" ")]),t._v("修改密码")])],1)],1)],1)])},staticRenderFns:[]};var p=e("VU/8")(l,u,!1,function(t){e("VvJP")},"data-v-ffdfeaae",null).exports,h={name:"cell",props:{item:{type:Object,default:{}},type:{type:String}},methods:{handleMouseEnter:function(t){t.target.stopPropagation()}}},m={render:function(){var t=this,n=t.$createElement,e=t._self._c||n;return t.item.meta.show?e(t.type,{tag:"div",staticClass:"unselectable",attrs:{index:t.item.path}},["el-submenu"===t.type?[e("template",{slot:"title"},[e("i",{staticClass:"iconfont",domProps:{innerHTML:t._s(t.item.meta.font)}}),t._v(" "),e("span",{attrs:{slot:"title"},slot:"title"},[t._v(t._s(t.item.meta.name))])]),t._v(" "),t._l(t.item.children,function(n){return[e("cell",{attrs:{item:n,type:n.children&&n.children.filter(function(t){return t.meta.show}).length?"el-submenu":"el-menu-item"},on:{mouseenter:t.handleMouseEnter}})]})]:t._e(),t._v(" "),"el-menu-item"===t.type?[e("i",{staticClass:"iconfont",domProps:{innerHTML:t._s(t.item.meta.font)}}),t._v(" "),e("span",{attrs:{slot:"title"},slot:"title"},[t._v(t._s(t.item.meta.name))])]:t._e()],2):t._e()},staticRenderFns:[]},d={components:{cell:e("VU/8")(h,m,!1,null,null,null).exports},data:function(){return{defaultActive:"",router:_,privileges:[]}},computed:{appName:function(){return this.$store.getters.appName},appShortName:function(){return this.$store.getters.appShortName},isCollapse:function(){return this.$store.state.system.isCollapse}},methods:{handleOpen:function(t,n){console.log(t,n)},handleClose:function(t,n){console.log(t,n)},resetVisible:function(t,n){var e=this;t.map(function(t,o){t.hasOwnProperty("children")&&(t.children.map(function(e,o){-1===n.indexOf(t.children[o].meta.can)&&(t.children[o].meta.show=!1)}),e.resetVisible(t.children,n))})},loadUserPermissions:function(){var t=this;this.$http.get("/admin/privileges/user/permissions").then(function(n){t.privileges=n.data,t.$store.commit(t.$types.PRIVILEGES,n.data);var e=t.router.options.routes;t.resetVisible(e,t.privileges)})}},created:function(){this.defaultActive=this.$route.path,this.loadUserPermissions()}},f={render:function(){var t=this,n=t.$createElement,e=t._self._c||n;return e("div",[e("div",{directives:[{name:"show",rawName:"v-show",value:!t.isCollapse,expression:"!isCollapse"}],staticClass:"ls-top-logo"},[t._v(t._s(t.appName))]),t._v(" "),e("div",{directives:[{name:"show",rawName:"v-show",value:t.isCollapse,expression:"isCollapse"}],staticClass:"ls-top-logo-narrow"},[t._v(t._s(t.appShortName))]),t._v(" "),e("el-menu",{ref:"sidemenu",staticClass:"el-menu-vertical",attrs:{"unique-opened":!0,router:"","default-active":t.defaultActive,collapse:t.isCollapse},on:{open:t.handleOpen,close:t.handleClose}},[t._l(t.router.options.routes,function(n,o){return[n.children&&n.children.filter(function(t){return t.meta.show}).length?[t._l(n.children,function(t){return[e("cell",{attrs:{item:t,type:t.children&&n.children.filter(function(t){return t.meta.show}).length?"el-submenu":"el-menu-item"}})]})]:t._e()]})],2)],1)},staticRenderFns:[]};var v={components:{"backend-top":p,"backend-menu":e("VU/8")(d,f,!1,function(t){e("ImSf"),e("suUV")},"data-v-6fc83bb8",null).exports},computed:{isCollapse:function(){return this.$store.state.system.isCollapse}},mounted:function(){this.$store.dispatch(this.$types.ACTIVITY_TYPES),this.$store.dispatch(this.$types.ACTIVITY_APPLICABLES)}},C={render:function(){var t=this.$createElement,n=this._self._c||t;return n("el-container",{staticClass:"ls-container"},[n("div",{staticClass:"ls-aside"},[n("div",{staticClass:"ls-left"},[n("backend-menu")],1)]),this._v(" "),n("div",{staticClass:"ls-content"},[n("div",{staticClass:"ls-top"},[n("backend-top")],1),this._v(" "),n("div",{staticClass:"ls-main"},[n("div",{staticStyle:{"box-sizing":"border-box",background:"#fff",padding:"20px","min-height":"100%"}},[n("router-view")],1)])])])},staticRenderFns:[]};var g=e("VU/8")(v,C,!1,function(t){e("5l2l")},"data-v-327659db",null).exports;i.default.use(r.a);var _=new r.a({mode:"hash",base:"/",saveScrollPosition:"true",routes:[{path:"/",component:g,meta:{can:"",show:!1,name:"根菜单"},children:[{path:"/dashboard",component:function(t){return Promise.all([e.e(1),e.e(10)]).then(function(){var n=[e("XRHL")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"dashboard",show:!0,name:"面板",font:"&#xe764;"}},{path:"/cms",component:function(t){return e.e(0).then(function(){var n=[e("RRQr")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"cms",show:!0,name:"内容管理",font:"&#xe764;"},children:[{path:"/cms/content",component:function(t){return Promise.all([e.e(1),e.e(3)]).then(function(){var n=[e("rh17")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"cms list contents",show:!0,name:"内容管理",font:"&#xe764;"}},{path:"/cms/channel",component:function(t){return Promise.all([e.e(1),e.e(12)]).then(function(){var n=[e("J4LN")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"cms list channels",show:!0,name:"栏目管理",font:"&#xe764;"}},{path:"/cms/position",component:function(t){return e.e(0).then(function(){var n=[e("RRQr")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"cms list contents",show:!0,name:"推荐管理",font:"&#xe764;"},children:[{path:"/cms/position/position",component:function(t){return e.e(19).then(function(){var n=[e("hCJu")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"dashboard",show:!0,name:"推荐位",font:"&#xe764;"}},{path:"/cms/position/content",component:function(t){return e.e(20).then(function(){var n=[e("zV5m")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"dashboard",show:!1,name:"内容管理",font:"&#xe764;"}},{path:"/cms/position/subs",component:function(t){return e.e(18).then(function(){var n=[e("n+mU")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"dashboard",show:!1,name:"内容推荐位",font:"&#xe764;"}}]},{path:"/cms/comment",component:function(t){return e.e(21).then(function(){var n=[e("dwZX")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"cms list contents",show:!0,name:"评论管理",font:"&#xe764;"}},{path:"/cms/setting",component:function(t){return e.e(0).then(function(){var n=[e("RRQr")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"cms list contents",show:!0,name:"设置",font:"&#xe764;"},children:[{path:"/cms/setting/model",component:function(t){return e.e(17).then(function(){var n=[e("PaIR")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"dashboard",show:!0,name:"模型管理",font:"&#xe764;"}},{path:"/cms/setting/model/add",component:function(t){return e.e(2).then(function(){var n=[e("HOqM")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"dashboard",show:!1,name:"添加模型",font:"&#xe764;"}},{path:"/cms/setting/model/edit",component:function(t){return e.e(2).then(function(){var n=[e("HOqM")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"dashboard",show:!1,name:"编辑模型",font:"&#xe764;"}},{path:"/cms/setting/field/types",component:function(t){return e.e(4).then(function(){var n=[e("6dud")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"dashboard",show:!0,name:"字段类型",font:"&#xe764;"}}]}]},{path:"/activity",component:function(t){return e.e(0).then(function(){var n=[e("RRQr")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"activity",show:!0,name:"活动管理",font:"&#xe6c5;"},children:[{path:"/activity/list",component:function(t){return e.e(5).then(function(){var n=[e("Pvz1")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"activity list",show:!0,name:"活动列表",font:"&#xe6a3;"}},{path:"/activity/add",component:function(t){return e.e(13).then(function(){var n=[e("70YF")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"add activity",show:!0,name:"添加活动",font:"&#xe663;"}},{path:"/activity/edit",component:function(t){return e.e(9).then(function(){var n=[e("A7xX")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"edit activity",show:!1,name:"编辑活动",font:""}}]},{path:"/pdd",component:function(t){return e.e(0).then(function(){var n=[e("RRQr")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"pdd",name:"拼多多",font:"&#xe711;",show:!0},children:[{path:"/pdd/cat",component:function(t){return e.e(16).then(function(){var n=[e("XwZp")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"pdd cat goods",show:!0,name:"分类商品",font:"&#xe711;"}},{path:"/pdd/orders",component:function(t){return e.e(11).then(function(){var n=[e("M7eE")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"pdd orders",show:!0,name:"订单",font:"&#xe62f;"}}]},{path:"/privileges",component:function(t){return e.e(0).then(function(){var n=[e("RRQr")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"privileges",show:!0,name:"权限系统",font:"&#xe70b;"},children:[{path:"/privileges/roles",component:function(t){return e.e(8).then(function(){var n=[e("gYjH")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"privileges list roles",show:!0,name:"角色管理",font:"&#xe612;"}},{path:"/privileges/permissions",component:function(t){return e.e(15).then(function(){var n=[e("YMpQ")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"privileges list permissions",show:!0,name:"权限管理",font:"&#xe70b;"}},{path:"/privileges/roles/users",component:function(t){return e.e(7).then(function(){var n=[e("glAp")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"privileges list role users",show:!1,name:"角色用户",font:""}},{path:"/privileges/roles/permissions",component:function(t){return e.e(14).then(function(){var n=[e("js6L")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{can:"privileges role permissions",show:!1,name:"角色权限",font:""}}]}]},{path:"/login",component:function(t){return e.e(6).then(function(){var n=[e("Luci")];t.apply(null,n)}.bind(this)).catch(e.oe)},meta:{name:"登录"}}]}),y=e("bOdI"),S=e.n(y),b=e("mvHQ"),E=e.n(b),N="ACCESS_TOKEN",R="ACTIVITY_TYPES",w="ACTIVITY_APPLICABLES",T="PRIVILEGES",I="PRIVILEGE_CURRENT_ROLE",A="USER",L="LOADING",P="CMS_MODELS",M="CMS_CHANNELS",x="CMS_CHANNEL_CHILDREN",O="CMS_PARENT_CHANNEL",$="CMS_CURRENT_CHANNEL",U="CMS_CURRENT_MODEL",V="CMS_CONTENTS",H="CMS_CURRENT_CHANNEL_POSITION",k="CMS_CURRENT_POSITION",Y={state:{appName:"LARACMS",appShortName:"LA",user:null,isCollapse:!1},getters:S()({appName:function(t){return t.appName},appShortName:function(t){return t.appShortName},isCollapse:function(t){return t.isCollapse}},A,function(t){if(t.user)return t.user;var n=localStorage.getItem(A);return JSON.parse(n)}),mutations:S()({toggleState:function(t){t.isCollapse=!t.isCollapse}},A,function(t,n){t.user=n,localStorage.setItem(A,E()(n))}),actions:S()({toggleState:function(t){(0,t.commit)("toggleState")},collapse:function(t){t.state.isCollapse=!0}},A,function(t,n){(0,t.commit)(A,n)})},D=e("//Fk"),j=e.n(D),Q=e("mtWM"),F=e.n(Q);function G(t){return Object(a.Message)({showClose:!0,message:t,type:"error",duration:3500})}F.a.interceptors.request.use(function(t){t.baseURL=st.SITE_URL+"/api/",t.withCredentials=!0,t.timeout=6e3;var n=localStorage.getItem("accessToken");return n&&(t.headers={Authorization:"Bearer "+n,"Content-Type":"application/json",Accept:"application/json"}),t},function(t){j.a.reject(t)}),F.a.interceptors.response.use(function(t){var n=t.data;switch(parseInt(n.code)){case 200:case 301:case 304:break;case 401:G(n.code+n.error),st.$router.push("/login"),localStorage.setItem("accessToken","");break;case 402:default:G(n.code+n.error)}return t.data},function(t){alert(st.$router.path)});var q,B,J,z,X,K=F.a,Z={state:{activityTypes:[],activityApplicables:[]},getters:{activityTypes:function(t){return t.activityTypes},activityApplicables:function(t){return t.activityApplicables}},mutations:(q={},S()(q,R,function(t,n){t.activityTypes=n}),S()(q,w,function(t,n){t.activityApplicables=n}),q),actions:(B={},S()(B,R,function(t){var n=t.commit;K.get("/admin/activity/types").then(function(t){console.log("types:",t),n(R,t.data.types)}).catch(function(t){console.log(t)})}),S()(B,w,function(t){var n=t.commit;K.get("/admin/activity/applicables").then(function(t){console.log("types:",t),n(w,t.data.applicables)}).catch(function(t){console.log(t)})}),B)},W=e("fZjL"),tt=e.n(W),nt={state:{loading:!1,models:[],channels:[],parentChannel:null,channelChildren:[],currentChannel:null,currentModel:null,currentChannelPosition:null,currentPosition:null},getters:{loading:function(t){return t.loading},models:function(t){return t.models},channels:function(t){return t.channels},channelChildren:function(t){return t.channelChildren},parentChannel:function(t){return t.parentChannel},currentChannel:function(t){return t.currentChannel},currentModel:function(t){return t.currentModel},currentChannelPosition:function(t){return t.currentChannelPosition},currentPosition:function(t){return t.currentPosition}},mutations:(J={},S()(J,L,function(t,n){t.loading=n}),S()(J,P,function(t,n){t.models=n}),S()(J,M,function(t,n){t.channels=n}),S()(J,x,function(t,n){t.channelChildren=n}),S()(J,O,function(t,n){t.parentChannel=n}),S()(J,$,function(t,n){t.currentChannel=n}),S()(J,U,function(t,n){t.currentModel=n}),S()(J,H,function(t,n){t.currentChannelPosition=n}),S()(J,k,function(t,n){t.currentPosition=n}),J),actions:(z={},S()(z,P,function(t){var n=t.commit;n(L,!0),K.get("/admin/cms/model").then(function(t){n(P,t.data),n(L,!1)})}),S()(z,M,function(t,n){var e=t.commit,o=t.dispatch;e(L,!0),K.get("/admin/cms/channel/tree",{params:{disabled:!0}}).then(function(t){if(tt()(t.data).length>0){var i=t.data[tt()(t.data)[0]];e(M,[i]),o(x,i),o(O,i),n||o($,i)}n&&(o(O,n),o(x,n)),e(L,!1)})}),S()(z,x,function(t,n){var e=t.commit;e(L,!0),K.post("/admin/cms/channel/children",{parent_id:n.id}).then(function(t){e(x,t.data),e(L,!1)})}),S()(z,O,function(t,n){(0,t.commit)(O,n)}),S()(z,$,function(t,n){(0,t.commit)($,n)}),S()(z,U,function(t,n){(0,t.commit)(U,n)}),z)},et={state:{loading:!1,currentRole:null,privileges:[]},getters:{currentRole:function(t){return t.currentRole},privileges:function(t){return t.privileges}},mutations:(X={},S()(X,I,function(t,n){t.currentRole=n}),S()(X,T,function(t,n){t.privileges=n,localStorage.setItem("privileges",E()(n))}),X),actions:S()({},I,function(t,n){(0,t.commit)(I,n)})};i.default.use(c.a);var ot=new c.a.Store({state:{accessToken:""},mutations:S()({},N,function(t,n){t.accessToken=n,localStorage.setItem("accessToken",n)}),getters:{accessToken:function(t){return localStorage.getItem("accessToken")}},modules:{system:Y,activity:Z,cms:nt,privilege:et}}),it={render:function(){var t=this.$createElement;return(this._self._c||t)("router-view")},staticRenderFns:[]};var at=e("VU/8")({},it,!1,function(t){e("wSDH")},null,null).exports;window.$=e("7t+N"),i.default.config.productionTip=!1,i.default.use(s.a),i.default.use(c.a),i.default.prototype.$http=K,i.default.prototype.$types=o,i.default.prototype.SITE_URL="",i.default.prototype.ADMIN_URL="/admin",i.default.directive("title",{inserted:function(t,n){document.title=n.value,t.remove()}});var st=n.default=new i.default({el:"#app",router:_,store:ot,components:{App:at},template:"<App/>"})},UBeP:function(t,n){},VvJP:function(t,n){},aEO6:function(t,n){},suUV:function(t,n){},wSDH:function(t,n){}},["NHnr"]);
//# sourceMappingURL=app.d25e50775f7f58c17a8c.js.map