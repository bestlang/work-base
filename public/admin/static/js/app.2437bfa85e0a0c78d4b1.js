webpackJsonp([36],{"0+aQ":function(e,n){},GHlf:function(e,n){},HNM5:function(e,n,t){"use strict";t.d(n,"a",function(){return d});var o=t("woOf"),i=t.n(o),a=t("//Fk"),s=t.n(a),r=t("mtWM"),c=t.n(r),l=t("zL8q"),u=(t.n(l),t("NHnr")),m=t("YgNb");c.a.defaults.timeout=5e4,c.a.interceptors.request.use(function(e){var n=localStorage.getItem("accessToken");return e.baseURL=u.default.SITE_URL+"/"+Object(m.b)()+"/",e.withCredentials=!0,e.timeout=6e3,n&&"api"==Object(m.b)()&&(e.headers={Authorization:"Bearer "+n,"Content-Type":"application/json",Accept:"application/json"}),e.headers["X-Requested-With"]="XMLHttpRequest",e},function(e){s.a.reject(e)}),c.a.interceptors.response.use(function(e){var n=e.data;switch(parseInt(n.code)){case 200:case 301:case 304:break;case 401:if(n.data.length){u.default.showMessage(n.data);break}u.default.showMessage("请重新登录!"),localStorage.setItem("accessToken",""),u.default.$router.push("/login");case 0:if("api"==Object(m.b)())localStorage.getItem("accessToken")||(u.default.showMessage("请重新登录!"),localStorage.setItem("accessToken",""),u.default.$router.push("/login"));else location.href="/login";break;case 402:default:u.default.showMessage(n.code+n.error)}return e.data},function(e){"api"==Object(m.b)()?u.default.$router.push("/login"):location.href="/login",401===e.response.status&&(u.default.showMessage("请重新登录"),u.default.$router.replace("/login")),s.a.reject(e)});var d=function(e){var n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},t=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"get",o=arguments.length>3&&void 0!==arguments[3]?arguments[3]:null,a={url:e,method:t};return"get"===t?i()(a,{params:n}):i()(a,{data:n}),o&&i()(a,{headers:o}),c()(a)}},KwPz:function(e,n){},NHnr:function(e,n,t){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var o={};t.d(o,"ACCESS_TOKEN",function(){return $}),t.d(o,"ACTIVITY_TYPES",function(){return V}),t.d(o,"ACTIVITY_APPLICABLES",function(){return Y}),t.d(o,"PRIVILEGES",function(){return G}),t.d(o,"PRIVILEGE_CURRENT_ROLE",function(){return F}),t.d(o,"USER",function(){return B}),t.d(o,"CSRF",function(){return Q}),t.d(o,"LOADING",function(){return q}),t.d(o,"CMS_MODELS",function(){return z}),t.d(o,"CMS_CHANNELS",function(){return K}),t.d(o,"CMS_CHANNEL_CHILDREN",function(){return J}),t.d(o,"CMS_PARENT_CHANNEL",function(){return W}),t.d(o,"CMS_CURRENT_CHANNEL",function(){return X}),t.d(o,"CMS_CURRENT_MODEL",function(){return Z}),t.d(o,"CMS_CONTENTS",function(){return ee}),t.d(o,"CMS_CURRENT_CHANNEL_POSITION",function(){return ne}),t.d(o,"CMS_CURRENT_POSITION",function(){return te});var i=t("7+uW"),a=t("zL8q"),s=t.n(a),r=(t("aEO6"),t("UBeP"),t("/ocq")),c=t("Xxa5"),l=t.n(c),u=t("exGp"),m=t.n(u),d=t("gyMJ"),p=t("YgNb"),f={computed:{user:function(){return this.$store.getters[this.$types.USER]}},methods:{toggleCollapse:function(){this.$store.dispatch("toggleState")},logout:function(){var e=this;return m()(l.a.mark(function n(){var t;return l.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,d.a.logout();case 2:t=n.sent,"api"==Object(p.b)()?(localStorage.removeItem(e.$types.USER),localStorage.removeItem("privileges"),e.$store.commit(e.$types.ACCESS_TOKEN,null),e.$router.push("/login")):200!=t.code&&401!=t.code||(location.href="/login");case 4:case"end":return n.stop()}},n,e)}))()}}},h={render:function(){var e=this,n=e.$createElement,t=e._self._c||n;return t("div",{staticClass:"ls-top-wrap"},[t("div",{staticClass:"ls-top-left"},[t("div",{staticClass:"ls-icon-collapse",on:{click:e.toggleCollapse}},[t("i",{staticClass:"iconfont l-color"},[e._v("")])])]),e._v(" "),t("div",{staticClass:"ls-top-right"},[t("el-dropdown",[t("div",{staticClass:"logout"},[t("i",{staticClass:"iconfont"},[e._v(" ")]),e._v(e._s(e.user.name))]),e._v(" "),t("el-dropdown-menu",{attrs:{slot:"dropdown"},slot:"dropdown"},[t("el-dropdown-item",[t("div",{on:{click:e.logout}},[t("i",{staticClass:"iconfont"},[e._v(" ")]),e._v("登出")])]),e._v(" "),t("el-dropdown-item",[t("i",{staticClass:"iconfont"},[e._v(" ")]),e._v("修改密码")])],1)],1)],1)])},staticRenderFns:[]};var g=t("VU/8")(f,h,!1,function(e){t("0+aQ")},"data-v-0753cdd9",null).exports,b=t("Dd8w"),v=t.n(b),C={name:"cell",props:{item:{type:Object,default:{}},type:{type:String}},methods:{handleMouseEnter:function(e){e.target.stopPropagation()}}},O={render:function(){var e=this,n=e.$createElement,t=e._self._c||n;return e.item.meta.show?t(e.type,{tag:"div",staticClass:"unselectable",attrs:{index:e.item.path}},["el-submenu"===e.type?[t("template",{slot:"title"},[t("i",{staticClass:"iconfont",domProps:{innerHTML:e._s(e.item.meta.font)}}),e._v(" "),t("span",{attrs:{slot:"title"},slot:"title"},[e._v(e._s(e.item.meta.name))])]),e._v(" "),e._l(e.item.children,function(n){return[t("cell",{attrs:{item:n,type:n.children&&n.children.filter(function(e){return e.meta.show}).length?"el-submenu":"el-menu-item"},on:{mouseenter:e.handleMouseEnter}})]})]:e._e(),e._v(" "),"el-menu-item"===e.type?[t("i",{staticClass:"iconfont",domProps:{innerHTML:e._s(e.item.meta.font)}}),e._v(" "),t("span",{attrs:{slot:"title"},slot:"title"},[e._v(e._s(e.item.meta.name))])]:e._e()],2):e._e()},staticRenderFns:[]};var _=t("VU/8")(C,O,!1,function(e){t("GHlf")},null,null).exports,w=t("NYxO"),S=t("rBKV"),j=t.n(S),P={components:{cell:_},data:function(){return{defaultActive:"",router:L}},computed:v()({appName:function(){return j.a.APP_NAME},appShortName:function(){return j.a.APP_SHORT_NAME}},Object(w.b)(["isCollapse","privileges"])),watch:{privileges:function(e){if(e.length){var n=this.router.options.routes;this.resetVisible(n,e)}}},methods:{handleOpen:function(e,n){},handleClose:function(e,n){},resetVisible:function(e,n){var t=this;e.map(function(e,o){e.hasOwnProperty("children")&&(e.children.map(function(t,o){-1===n.indexOf(e.children[o].meta.can)&&(e.children[o].meta.show=!1)}),t.resetVisible(e.children,n))})}},created:function(){var e=this;return m()(l.a.mark(function n(){var t,o,i;return l.a.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:if(e.defaultActive=e.$route.path,e.privileges.length){n.next=14;break}return n.next=4,d.a.getUserPermissions();case 4:return t=n.sent,n.next=7,d.a.getUserInfo();case 7:return o=n.sent,n.next=10,d.a.csrf();case 10:i=n.sent,t&&t.data&&e.$store.commit(e.$types.PRIVILEGES,t.data),o&&o.data&&e.$store.commit(e.$types.USER,o.data),i&&i.data&&e.$store.commit(e.$types.CSRF,i.data);case 14:case"end":return n.stop()}},n,e)}))()}},N={render:function(){var e=this,n=e.$createElement,t=e._self._c||n;return t("div",{staticClass:"l-menu-wrap"},[t("div",{directives:[{name:"show",rawName:"v-show",value:!e.isCollapse,expression:"!isCollapse"}],staticClass:"ls-top-logo"},[e._v(e._s(e.appName)+"内部系统")]),e._v(" "),t("div",{directives:[{name:"show",rawName:"v-show",value:e.isCollapse,expression:"isCollapse"}],staticClass:"ls-top-logo-narrow"},[e._v(e._s(e.appShortName))]),e._v(" "),t("el-menu",{ref:"sidemenu",staticClass:"el-menu-vertical",attrs:{"unique-opened":!0,router:"","default-active":e.defaultActive,collapse:e.isCollapse},on:{open:e.handleOpen,close:e.handleClose}},[e._l(e.router.options.routes,function(n,o){return[n.children&&n.children.filter(function(e){return e.meta.show}).length?[e._l(n.children,function(e){return[t("cell",{attrs:{item:e,type:e.children&&n.children.filter(function(e){return e.meta.show}).length?"el-submenu":"el-menu-item"}})]})]:e._e()]})],2)],1)},staticRenderFns:[]};var R={components:{"backend-top":g,"backend-menu":t("VU/8")(P,N,!1,function(e){t("gBYc"),t("Ym6d")},"data-v-23687b58",null).exports},computed:{isCollapse:function(){return this.$store.state.system.isCollapse}},mounted:function(){}},E={render:function(){var e=this.$createElement,n=this._self._c||e;return n("el-container",{staticClass:"ls-container"},[n("div",{staticClass:"ls-aside"},[n("div",{staticClass:"ls-left"},[n("backend-menu")],1)]),this._v(" "),n("div",{staticClass:"ls-content"},[n("div",{staticClass:"ls-top"},[n("backend-top")],1),this._v(" "),n("div",{staticClass:"ls-main"},[n("div",{staticStyle:{"box-sizing":"border-box",background:"#fff",padding:"20px","min-height":"100%"}},[n("router-view")],1)])])])},staticRenderFns:[]};var M=t("VU/8")(R,E,!1,function(e){t("KwPz")},"data-v-1a2b3115",null).exports;i.default.use(r.a);var x,T,y,I,A,L=new r.a({mode:"hash",base:"/",saveScrollPosition:"true",routes:[{path:"/",component:M,meta:{can:"",show:!1,name:"根菜单"},children:[{path:"/dashboard",component:function(){return t.e(27).then(t.bind(null,"XRHL"))},meta:{can:"dashboard",show:!0,name:"面板",font:"&#xe764;"}},{path:"/sniper/employee",component:function(){return t.e(1).then(t.bind(null,"RRQr"))},meta:{can:"cms",show:!0,name:"人力资源",font:"&#xe612;"},children:[{path:"/basic/department",component:function(){return Promise.all([t.e(0),t.e(17)]).then(t.bind(null,"zq/K"))},meta:{can:"cms",show:!0,name:"部门管理",font:"&#xe69a;"}},{path:"/basic/department/edit",component:function(){return Promise.all([t.e(0),t.e(10)]).then(t.bind(null,"m4Ix"))},meta:{can:"cms",show:!1,name:"新增部门",font:"&#xe612;"}},{path:"/basic/department/detail",component:function(){return Promise.all([t.e(0),t.e(26)]).then(t.bind(null,"9Pj2"))},meta:{can:"cms",show:!1,name:"部门详情",font:"&#xe612;"}},{path:"/basic/position",component:function(){return Promise.all([t.e(0),t.e(6)]).then(t.bind(null,"idzw"))},meta:{can:"cms",show:!0,name:"职位管理",font:"&#xe611;"}},{path:"/basic/position/edit",component:function(){return Promise.all([t.e(0),t.e(14)]).then(t.bind(null,"PHtR"))},meta:{can:"cms",show:!1,name:"添加管理",font:"&#xe612;"}},{path:"/basic/employee/list",component:function(){return Promise.all([t.e(0),t.e(21)]).then(t.bind(null,"+dJ+"))},meta:{can:"cms",show:!0,name:"员工列表",font:"&#xe614;"}},{path:"/basic/employee/edit",component:function(){return Promise.all([t.e(0),t.e(25)]).then(t.bind(null,"wQ3f"))},meta:{can:"cms",show:!1,name:"新增员工",font:"&#xe614;"}},{path:"/graph",component:function(){return t.e(5).then(t.bind(null,"cNCB"))},meta:{can:"cms",show:!0,name:"组织架构",font:"&#xe629;"}}]},{path:"/privileges",component:function(){return t.e(1).then(t.bind(null,"RRQr"))},meta:{can:"privileges",show:!0,name:"权限系统",font:"&#xe70b;"},children:[{path:"/privileges/roles",component:function(){return t.e(24).then(t.bind(null,"gYjH"))},meta:{can:"privileges list roles",show:!0,name:"角色管理",font:"&#xe612;"}},{path:"/privileges/permissions",component:function(){return t.e(31).then(t.bind(null,"YMpQ"))},meta:{can:"privileges list permissions",show:!0,name:"权限管理",font:"&#xe70b;"}},{path:"/privileges/users",component:function(){return Promise.all([t.e(0),t.e(15)]).then(t.bind(null,"j1K9"))},meta:{can:"privileges list permissions",show:!0,name:"用户管理",font:"&#xe70b;"}},{path:"/privileges/roles/users",component:function(){return t.e(28).then(t.bind(null,"glAp"))},meta:{can:"privileges list role users",show:!1,name:"角色用户",font:""}},{path:"/privileges/roles/permissions",component:function(){return t.e(9).then(t.bind(null,"js6L"))},meta:{can:"privileges role permissions",show:!1,name:"角色权限",font:""}}]},{path:"/cms",component:function(){return t.e(1).then(t.bind(null,"RRQr"))},meta:{can:"cms",show:!0,name:"内容管理",font:"&#xe764;"},children:[{path:"/cms/content",component:function(){return Promise.all([t.e(0),t.e(7)]).then(t.bind(null,"rh17"))},meta:{can:"cms list contents",show:!0,name:"内容管理",font:"&#xe764;"}},{path:"/cms/content/add",component:function(){return Promise.all([t.e(0),t.e(3)]).then(t.bind(null,"wvRB"))},meta:{can:"cms list contents",show:!1,name:"添加内容",font:"&#xe764;"}},{path:"/cms/content/edit",component:function(){return Promise.all([t.e(0),t.e(4)]).then(t.bind(null,"uSH3"))},meta:{can:"cms list contents",show:!1,name:"编辑内容",font:"&#xe764;"}},{path:"/cms/channel",component:function(){return Promise.all([t.e(0),t.e(18)]).then(t.bind(null,"J4LN"))},meta:{can:"cms list channels",show:!0,name:"栏目管理",font:"&#xe764;"}},{path:"/cms/position",component:function(){return t.e(1).then(t.bind(null,"RRQr"))},meta:{can:"cms list contents",show:!0,name:"推荐管理",font:"&#xe764;"},children:[{path:"/cms/position/position",component:function(){return t.e(33).then(t.bind(null,"hCJu"))},meta:{can:"dashboard",show:!0,name:"推荐位",font:"&#xe764;"}},{path:"/cms/position/content",component:function(){return t.e(34).then(t.bind(null,"zV5m"))},meta:{can:"dashboard",show:!1,name:"内容管理",font:"&#xe764;"}},{path:"/cms/position/subs",component:function(){return t.e(32).then(t.bind(null,"n+mU"))},meta:{can:"dashboard",show:!1,name:"内容推荐位",font:"&#xe764;"}}]},{path:"/cms/comment",component:function(){return Promise.all([t.e(0),t.e(8)]).then(t.bind(null,"27ez"))},meta:{can:"cms list contents",show:!0,name:"评论管理",font:"&#xe764;"}},{path:"/cms/comment/content",component:function(){return Promise.all([t.e(0),t.e(16)]).then(t.bind(null,"RD01"))},meta:{can:"cms list contents",show:!1,name:"文章评论",font:"&#xe764;"}},{path:"/cms/setting",component:function(){return t.e(1).then(t.bind(null,"RRQr"))},meta:{can:"cms list contents",show:!0,name:"设置",font:"&#xe764;"},children:[{path:"/cms/setting/siteSetting",component:function(){return t.e(12).then(t.bind(null,"MCNe"))},meta:{can:"dashboard",show:!0,name:"站点设置",font:"&#xe764;"}},{path:"/cms/setting/model",component:function(){return t.e(30).then(t.bind(null,"PaIR"))},meta:{can:"dashboard",show:!0,name:"模型管理",font:"&#xe764;"}},{path:"/cms/setting/model/add",component:function(){return t.e(2).then(t.bind(null,"HOqM"))},meta:{can:"dashboard",show:!1,name:"添加模型",font:"&#xe764;"}},{path:"/cms/setting/model/edit",component:function(){return t.e(2).then(t.bind(null,"HOqM"))},meta:{can:"dashboard",show:!1,name:"编辑模型",font:"&#xe764;"}},{path:"/cms/setting/field/types",component:function(){return t.e(19).then(t.bind(null,"6dud"))},meta:{can:"dashboard",show:!0,name:"字段类型",font:"&#xe764;"}}]},{path:"/cms/operation",component:function(){return t.e(1).then(t.bind(null,"RRQr"))},meta:{can:"cms operations",show:!0,name:"运营管理",font:"&#xe764;"},children:[{path:"/cms/operation/orders",component:function(){return Promise.all([t.e(0),t.e(20)]).then(t.bind(null,"MPvX"))},meta:{can:"cms operations",show:!0,name:"订单管理",font:"&#xe764;"}},{path:"/cms/operation/ads",component:function(){return t.e(13).then(t.bind(null,"gSSL"))},meta:{can:"cms ad operations",show:!0,name:"广告管理",font:"&#xe764;"}},{path:"/cms/operation/ad/positions",component:function(){return t.e(11).then(t.bind(null,"HA4w"))},meta:{can:"cms ad operations",show:!0,name:"广告位",font:"&#xe764;"}},{path:"/cms/operation/edit/ad",component:function(){return Promise.all([t.e(0),t.e(22)]).then(t.bind(null,"idiY"))},meta:{can:"cms ad operations",show:!1,name:"广告位",font:"&#xe764;"}}]}]}]},{path:"/login",component:function(){return t.e(29).then(t.bind(null,"Luci"))},meta:{name:"登录"}},{path:"/test",component:function(){return t.e(23).then(t.bind(null,"Y7I0"))},meta:{name:"test"}}]}),U=t("bOdI"),H=t.n(U),D=t("mvHQ"),k=t.n(D),$="ACCESS_TOKEN",V="ACTIVITY_TYPES",Y="ACTIVITY_APPLICABLES",G="PRIVILEGES",F="PRIVILEGE_CURRENT_ROLE",B="USER",Q="CSRF",q="LOADING",z="CMS_MODELS",K="CMS_CHANNELS",J="CMS_CHANNEL_CHILDREN",W="CMS_PARENT_CHANNEL",X="CMS_CURRENT_CHANNEL",Z="CMS_CURRENT_MODEL",ee="CMS_CONTENTS",ne="CMS_CURRENT_CHANNEL_POSITION",te="CMS_CURRENT_POSITION",oe={state:{appName:"LARACMS",appShortName:"LC",user:null,isCollapse:!1,csrf:null},getters:(x={appName:function(e){return e.appName},appShortName:function(e){return e.appShortName},isCollapse:function(e){return e.isCollapse}},H()(x,B,function(e){if(e.user)return e.user;var n=localStorage.getItem(B);return JSON.parse(n)}),H()(x,Q,function(e){return localStorage.getItem(Q)}),x),mutations:(T={toggleState:function(e){e.isCollapse=!e.isCollapse}},H()(T,B,function(e,n){e.user=n,localStorage.setItem(B,k()(n))}),H()(T,Q,function(e,n){e.csrf=n,localStorage.setItem(Q,n)}),T),actions:H()({toggleState:function(e){(0,e.commit)("toggleState")},collapse:function(e){e.state.isCollapse=!0}},B,function(e,n){(0,e.commit)(B,n)})},ie=t("fZjL"),ae=t.n(ie),se={state:{loading:!1,models:[],channels:[],parentChannel:null,channelChildren:[],currentChannel:null,currentModel:null,currentChannelPosition:null,currentPosition:null},getters:{loading:function(e){return e.loading},models:function(e){return e.models},channels:function(e){return e.channels},channelChildren:function(e){return e.channelChildren},parentChannel:function(e){return e.parentChannel},currentChannel:function(e){return e.currentChannel},currentModel:function(e){return e.currentModel},currentChannelPosition:function(e){return e.currentChannelPosition},currentPosition:function(e){return e.currentPosition}},mutations:(y={},H()(y,q,function(e,n){e.loading=n}),H()(y,z,function(e,n){e.models=n}),H()(y,K,function(e,n){e.channels=n}),H()(y,J,function(e,n){e.channelChildren=n}),H()(y,W,function(e,n){e.parentChannel=n}),H()(y,X,function(e,n){e.currentChannel=n}),H()(y,Z,function(e,n){e.currentModel=n}),H()(y,ne,function(e,n){e.currentChannelPosition=n}),H()(y,te,function(e,n){e.currentPosition=n}),y),actions:(I={},H()(I,z,function(e){var n=this,t=e.commit;return m()(l.a.mark(function e(){var o;return l.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t(q,!0),e.next=3,d.a.getCmsModels();case 3:o=e.sent,t(z,o.data),t(q,!1);case 6:case"end":return e.stop()}},e,n)}))()}),H()(I,K,function(e){var n=this,t=e.commit,o=e.dispatch,i=arguments.length>1&&void 0!==arguments[1]?arguments[1]:[null,0];return m()(l.a.mark(function e(){var a,s;return l.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t(q,!0),e.next=3,d.a.getCmsChannelTree({disabled:!0,has_contents:i[1]});case 3:a=e.sent,ae()(a.data).length>0&&(s=a.data[ae()(a.data)[0]],t(K,[s]),o(J,s)),i[0]&&(o(W,i[0]),o(J,i[0])),t(q,!1);case 7:case"end":return e.stop()}},e,n)}))()}),H()(I,J,function(e,n){var t=this,o=e.commit;return m()(l.a.mark(function e(){var i;return l.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return o(q,!0),e.next=3,d.a.getCmsChannelChildren({parent_id:n.id});case 3:i=e.sent,o(J,i.data),o(q,!1);case 6:case"end":return e.stop()}},e,t)}))()}),H()(I,W,function(e,n){(0,e.commit)(W,n)}),H()(I,X,function(e,n){(0,e.commit)(X,n)}),H()(I,Z,function(e,n){(0,e.commit)(Z,n)}),I)},re={state:{loading:!1,currentRole:null,privileges:[]},getters:{currentRole:function(e){return e.currentRole},privileges:function(e){return e.privileges}},mutations:(A={},H()(A,F,function(e,n){e.currentRole=n}),H()(A,G,function(e,n){e.privileges=n,localStorage.setItem("privileges",k()(n))}),A),actions:H()({},F,function(e,n){(0,e.commit)(F,n)})};i.default.use(w.a);var ce=new w.a.Store({state:{accessToken:""},mutations:H()({},$,function(e,n){e.accessToken=n,localStorage.setItem("accessToken",n)}),getters:{accessToken:function(e){return localStorage.getItem("accessToken")}},modules:{system:oe,cms:se,privilege:re}}),le={render:function(){var e=this.$createElement;return(this._self._c||e)("router-view")},staticRenderFns:[]},ue=t("VU/8")({},le,!1,null,null,null).exports,me=t("HNM5");window.$=t("7t+N"),i.default.config.productionTip=!1,i.default.use(s.a),i.default.prototype.fetch=me.a,i.default.prototype.$types=o,i.default.prototype.SITE_URL="http://127.0.0.1:8000",i.default.prototype.ADMIN_URL="/admin",i.default.prototype.showMessage=function(e){var n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"error";return s.a.Message.closeAll(),s.a.Message({showClose:!0,message:e,type:n,duration:3500})},i.default.directive("title",{inserted:function(e,n){document.title=n.value,e.remove()}});n.default=new i.default({el:"#app",router:L,store:ce,components:{App:ue},template:"<App/>"})},UBeP:function(e,n){},YgNb:function(e,n,t){"use strict";t.d(n,"b",function(){return o}),t.d(n,"a",function(){return i});var o=function(){return location.origin.indexOf("8000")>0?"ajax":"api"},i=function(e){var n;try{n=new Date(e)}catch(e){n=new Date}var t=n.getMonth()+1,o=n.getDate();t>=1&&t<=9&&(t="0"+t),o>=0&&o<=9&&(o="0"+o);var i=n.getHours(),a=n.getMinutes(),s=n.getSeconds();return i>=1&&i<=9&&(i="0"+i),a>=1&&a<=9&&(a="0"+a),s>=1&&s<=9&&(s="0"+s),n.getFullYear()+"-"+t+"-"+o+" "+i+":"+a+":"+s}},Ym6d:function(e,n){},aEO6:function(e,n){},gBYc:function(e,n){},gyMJ:function(e,n,t){"use strict";var o=t("HNM5");n.a={login:function(e){return Object(o.a)("auth/login",e,"post")},logout:function(e){return Object(o.a)("auth/logout",e,"post")},getCmsModels:function(e){return Object(o.a)("/admin/cms/model",e)},getCmsChannelTree:function(e){return Object(o.a)("/admin/cms/channel/tree",e)},getCmsChannelChildren:function(e){return Object(o.a)("/admin/cms/channel/children",e)},createUser:function(e){return Object(o.a)("/admin/user/create",e)},updateUser:function(e){return Object(o.a)("/admin/user/update",e)},getUserInfo:function(e){return Object(o.a)("/admin/user/info",e)},csrf:function(e){return Object(o.a)("/csrf")},getUserPermissions:function(e){return Object(o.a)("/admin/privileges/user/permissions",e)},saveModelFieldType:function(e){return Object(o.a)("/admin/cms/model/field/type/save",e,"post")},getModelFieldTypes:function(e){return Object(o.a)("/admin/cms/model/field/types",e)},deleteCmsChannel:function(e){return Object(o.a)("/admin/cms/channel/delete",e,"post")},saveCmsChannel:function(e){return Object(o.a)("/admin/cms/channel/save",e,"post")},getCmsChannelWhole:function(e){return Object(o.a)("/admin/cms/channel/whole",e)},getCmsPositions:function(e){return Object(o.a)("/admin/cms/positions",e)},createRoleUser:function(e){return Object(o.a)("/admin/user/create/role/user",e,"post")},removeRoleModel:function(e){return Object(o.a)("/admin/privileges/remove/role/model",e,"post")},saveRole:function(e){return Object(o.a)("/admin/privileges/save/role",e,"post")},getRoles:function(e){return Object(o.a)("/admin/privileges/roles",e)},getUsers:function(e){return Object(o.a)("/admin/privileges/users",e)},getPosition:function(e){return Object(o.a)("/admin/cms/get/position",e)},getSubPositions:function(e){return Object(o.a)("/admin/cms/position/subs",e,"post")},savePosition:function(e){return Object(o.a)("/admin/cms/position/save",e,"post")},givePermissionsTo:function(e){return Object(o.a)("/admin/privileges/give/permissions/to",e,"post")},getPermissionsTree:function(e){return Object(o.a)("/admin/privileges/permissions/tree",e)},getRolePermissions:function(e){return Object(o.a)("/admin/privileges/role/permissions",e)},addPermission:function(e){return Object(o.a)("/admin/privileges/add/permission",e,"post")},editPermission:function(e){return Object(o.a)("/admin/privileges/edit/permission",e,"post")},deletePermission:function(e){return Object(o.a)("/admin/privileges/delete/permission",e,"post")},deleteContent:function(e){return Object(o.a)("/admin/cms/content/delete",e,"post")},saveContent:function(e){return Object(o.a)("/admin/cms/content/save",e,"post")},getModel:function(e){return Object(o.a)("/admin/cms/model/get",e)},getChannelContents:function(e){return Object(o.a)("/admin/cms/contents",e)},getWholeContent:function(e){return Object(o.a)("/admin/cms/content/whole",e)},getContentPositions:function(e){return Object(o.a)("/admin/cms/content/positions",e)},deleteModel:function(e){return Object(o.a)("/admin/cms/model/delete",e,"post")},addFieldType:function(e){return Object(o.a)("/admin/cms/model/field/type/add",e,"post")},getModels:function(e){return Object(o.a)("/admin/cms/model",e)},saveModelFieldOrder:function(e){return Object(o.a)("/admin/cms/model/save/field/order",e,"post")},deleteModelField:function(e){return Object(o.a)("/admin/cms/model/delete/field",e,"post")},saveModel:function(e){return Object(o.a)("/admin/cms/model/save",e,"post")},modelSaveField:function(e){return Object(o.a)("/admin/cms/model/save/field",e,"post")},getPositionContents:function(e){return Object(o.a)("/admin/cms/position/contents",e)},getRoleUsers:function(e){return Object(o.a)("/admin/privileges/role/users",e)},deleteRole:function(e){return Object(o.a)("/admin/privileges/delete/role",e,"post")},getComments:function(e){return Object(o.a)("/admin/cms/get/comments",e)},getContentComments:function(e){return Object(o.a)("/admin/cms/get/content/comments",e)},saveAdPosition:function(e){return Object(o.a)("/admin/cms/save/ad/position",e,"post")},getAdPositions:function(e){return Object(o.a)("/admin/cms/get/ad/positions",e)},getAds:function(e){return Object(o.a)("/admin/cms/get/ads",e)},getAd:function(e){return Object(o.a)("/admin/cms/get/ad",e)},deleteAdPosition:function(e){return Object(o.a)("/admin/cms/delete/ad/position",e)},deleteAd:function(e){return Object(o.a)("/admin/cms/delete/ad",e)},saveAd:function(e){return Object(o.a)("/admin/cms/save/ad",e,"post")},getOptionalTemplatePrefix:function(e){return Object(o.a)("/admin/cms/get/optional/template/prefix",e)},getOptionalTemplatePath:function(e){return Object(o.a)("/admin/cms/get/optional/template/path",e)},getOptionalThemes:function(e){return Object(o.a)("/admin/cms/get/optional/themes",e)},getOrders:function(e){return Object(o.a)("/admin/cms/orders",e)},saveSiteSetting:function(e){return Object(o.a)("/admin/cms/save/site/setting",e,"post")},getSiteSetting:function(e){return Object(o.a)("/admin/cms/get/site/setting",e)},sniperGetDepartmentLevel1:function(e){return Object(o.a)("/admin/sniper/employee/departments/level1",e)},sniperGetDepartmentsTreeSelect:function(e){return Object(o.a)("/admin/sniper/employee/departments/tree/select",e)},sniperSaveDepartment:function(e){return Object(o.a)("/admin/sniper/employee/save/department",e,"post")},sniperGetDepartmentDetail:function(e){return Object(o.a)("/admin/sniper/employee/get/department/detail",e)},sniperGetDepartmentDescendants:function(e){return Object(o.a)("/admin/sniper/employee/get/department/descendants",e)},sniperGetPositionsTreeSelect:function(e){return Object(o.a)("/admin/sniper/employee/positions/tree/select",e)},sniperSavePosition:function(e){return Object(o.a)("/admin/sniper/employee/save/position",e,"post")},sniperGetPositionDetail:function(e){return Object(o.a)("/admin/sniper/employee/get/position/detail",e)},sniperGetPositionDescendants:function(e){return Object(o.a)("/admin/sniper/employee/get/position/descendants",e)},sniperDeletePosition:function(e){return Object(o.a)("/admin/sniper/employee/delete/position",e,"post")},sniperSaveEmployee:function(e){return Object(o.a)("/admin/sniper/employee/save/employee",e,"post")},sniperGetDepartmentEmployee:function(e){return Object(o.a)("/admin/sniper/employee/department/employee",e)},sniperDeleteDepartment:function(e){return Object(o.a)("/admin/sniper/employee/delete/department",e,"post")}}},rBKV:function(e,n,t){"use strict";e.exports={APP_NAME:"思纳福",APP_SHORT_NAME:"SN",NODE_ENV:'"production"',SITE_URL:'"http://127.0.0.1:8000"',ADMIN_URL:'"/admin"'}}},["NHnr"]);
//# sourceMappingURL=app.2437bfa85e0a0c78d4b1.js.map