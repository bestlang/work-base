webpackJsonp([38],{"5reh":function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),n.d(t,"privileges",function(){return r}),n.d(t,"logout",function(){return o}),n.d(t,"logined",function(){return i}),n.d(t,"user",function(){return a}),n.d(t,"csrf",function(){return s}),n.d(t,"PRIVILEGE_CURRENT_ROLE",function(){return c}),n.d(t,"LOADING",function(){return u}),n.d(t,"CMS_MODELS",function(){return l}),n.d(t,"CMS_CHANNELS",function(){return m}),n.d(t,"CMS_CHANNEL_CHILDREN",function(){return p}),n.d(t,"CMS_PARENT_CHANNEL",function(){return d}),n.d(t,"CMS_CURRENT_CHANNEL",function(){return f}),n.d(t,"CMS_CURRENT_MODEL",function(){return h}),n.d(t,"CMS_CONTENTS",function(){return g}),n.d(t,"CMS_CURRENT_CHANNEL_POSITION",function(){return v}),n.d(t,"CMS_CURRENT_POSITION",function(){return C});var r="privileges",o="logout",i="logined",a="user",s="csrf",c="PRIVILEGE_CURRENT_ROLE",u="LOADING",l="CMS_MODELS",m="CMS_CHANNELS",p="CMS_CHANNEL_CHILDREN",d="CMS_PARENT_CHANNEL",f="CMS_CURRENT_CHANNEL",h="CMS_CURRENT_MODEL",g="CMS_CONTENTS",v="CMS_CURRENT_CHANNEL_POSITION",C="CMS_CURRENT_POSITION";t.default={privileges:r,user:a,logout:o,logined:i,PRIVILEGE_CURRENT_ROLE:c,csrf:s,LOADING:u,CMS_MODELS:l,CMS_CHANNELS:m,CMS_CHANNEL_CHILDREN:p,CMS_PARENT_CHANNEL:d,CMS_CURRENT_CHANNEL:f,CMS_CURRENT_MODEL:h,CMS_CONTENTS:g,CMS_CURRENT_CHANNEL_POSITION:v,CMS_CURRENT_POSITION:C}},C8ss:function(e,t){},Cfie:function(e,t){},HNM5:function(e,t,n){"use strict";n.d(t,"a",function(){return m});var r=n("mtWM"),o=n.n(r),i=n("zL8q"),a=(n.n(i),n("NHnr")),s=n("YgNb"),c=n("lbHh"),u=n.n(c),l=n("5reh");o.a.interceptors.request.use(function(e){var t=localStorage.getItem("accessToken");return e.baseURL=a.default.SITE_URL+"/"+Object(s.b)()+"/",e.withCredentials=!0,e.timeout=1e4,t&&"api"==Object(s.b)()&&(e.headers={Authorization:"Bearer "+t,"Content-Type":"application/json",Accept:"application/json"}),e.headers["X-Requested-With"]="XMLHttpRequest",e},function(e){Promise.reject(e)}),o.a.interceptors.response.use(function(e){var t=e.data;switch(parseInt(t.code)){case 0:"api"==Object(s.b)()?(a.default.showMessage("请重新登录!"),localStorage.removeItem("accessToken"),u.a.remove(l.default.logined),a.default.$router.push("/login")):location.href="/login";break;case 200:case 301:case 304:break;case 401:if(t.data.length){a.default.showMessage(t.data);break}a.default.showMessage("请重新登录!"),localStorage.removeItem("accessToken"),a.default.$router.push("/login");case 402:default:a.default.showMessage(t.code+t.error)}return e.data},function(e){"api"==Object(s.b)()?a.default.$router.push("/login"):location.href="/login",e.response&&401===e.response.status&&(a.default.showMessage("请重新登录"),a.default.$router.replace("/login")),Promise.reject(e)});var m=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"get",r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:null,i={url:e,method:n};return"get"===n?Object.assign(i,{params:t}):Object.assign(i,{data:t}),r&&Object.assign(i,{headers:r}),o()(i)}},NHnr:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});n("j1ja");var r=n("7+uW"),o=n("zL8q"),i=n.n(o),a=(n("tvR6"),n("UBeP"),n("/ocq")),s=n("gyMJ"),c=n("YgNb"),u=n("NYxO"),l=n("lbHh"),m=n.n(l);function p(e){return function(){var t=e.apply(this,arguments);return new Promise(function(e,n){return function r(o,i){try{var a=t[o](i),s=a.value}catch(e){return void n(e)}if(!a.done)return Promise.resolve(s).then(function(e){r("next",e)},function(e){r("throw",e)});e(s)}("next")})}}var d={computed:(Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var r in n)Object.prototype.hasOwnProperty.call(n,r)&&(e[r]=n[r])}return e})({},Object(u.b)(["user","privileges","accessToken","csrf"])),watch:{accessToken:{handler:function(e){e||("api"==Object(c.b)()?this.$router.push("/login"):location.href="/login")}}},methods:{toggleCollapse:function(){this.$store.dispatch("toggleState")},logout:function(){var e=this;return p(regeneratorRuntime.mark(function t(){return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.$store.dispatch("logout");case 2:case"end":return t.stop()}},t,e)}))()}},created:function(){var e=this;return p(regeneratorRuntime.mark(function t(){return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if("ajax"!=Object(c.b)()){t.next=11;break}if(e.user&&e.user.length){t.next=4;break}return t.next=4,e.$store.dispatch(e.$types.user);case 4:if(e.privileges&&e.privileges.length){t.next=7;break}return t.next=7,e.$store.dispatch(e.$types.privileges);case 7:if(e.csrf){t.next=10;break}return t.next=10,e.$store.dispatch(e.$types.csrf);case 10:m.a.get(e.$types.logined)||m.a.set(e.$types.logined,!0,new Date((new Date).getTime()+6e5));case 11:case"end":return t.stop()}},t,e)}))()}},f={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"ls-top-wrap"},[n("div",{staticClass:"ls-top-left"},[n("div",{staticClass:"ls-icon-collapse",on:{click:e.toggleCollapse}},[n("i",{staticClass:"iconfont l-color"},[e._v("")])]),e._v(" "),e._t("top-items")],2),e._v(" "),n("div",{staticClass:"ls-top-right"},[n("el-dropdown",[n("div",{staticClass:"logout"},[n("i",{staticClass:"iconfont"},[e._v(" ")]),e._v(e._s(e.user.name))]),e._v(" "),n("el-dropdown-menu",{attrs:{slot:"dropdown"},slot:"dropdown"},[n("el-dropdown-item",[n("div",{on:{click:e.logout}},[n("i",{staticClass:"iconfont"},[e._v(" ")]),e._v("登出")])]),e._v(" "),n("el-dropdown-item",[n("i",{staticClass:"iconfont"},[e._v(" ")]),e._v("修改密码")])],1)],1)],1)])},staticRenderFns:[]};var h=n("VU/8")(d,f,!1,function(e){n("C8ss")},"data-v-fed6fd94",null).exports,g={name:"cell",props:{item:{type:Object,default:{}},type:{type:String}},methods:{calType:function(e){return e.children&&e.children.filter(function(e){return e.meta.show}).length?"el-submenu":"el-menu-item"},handleMouseEnter:function(e){e.target.stopPropagation()}}},v={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return e.item.meta.show?n(e.type,{tag:"div",staticClass:"unselectable",attrs:{index:e.item.path}},[e._t("default"),e._v(" "),"el-submenu"===e.type?[n("template",{slot:"title"},[n("i",{staticClass:"iconfont",domProps:{innerHTML:e._s(e.item.meta.font)}}),e._v(" "),n("span",{attrs:{slot:"title"},slot:"title"},[e._v(e._s(e.item.meta.name))])]),e._v(" "),e._l(e.item.children,function(t){return[n("cell",{attrs:{item:t,type:e.calType(t)},on:{mouseenter:e.handleMouseEnter}})]})]:e._e(),e._v(" "),"el-menu-item"===e.type?[n("i",{staticClass:"iconfont",domProps:{innerHTML:e._s(e.item.meta.font)}}),e._v(" "),n("span",{attrs:{slot:"title"},slot:"title"},[e._v(e._s(e.item.meta.name))])]:e._e()],2):e._e()},staticRenderFns:[]};var C=n("VU/8")(g,v,!1,function(e){n("icBJ")},null,null).exports,b=n("rBKV"),O=n.n(b);var _={components:{cell:C},data:function(){return{defaultActive:"",router:x}},computed:(Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var r in n)Object.prototype.hasOwnProperty.call(n,r)&&(e[r]=n[r])}return e})({appName:function(){return O.a.APP_NAME},appShortName:function(){return O.a.APP_SHORT_NAME}},Object(u.b)(["isCollapse","privileges","csrf"])),watch:{privileges:{handler:function(e){if(e&&e.length){var t=this.router.options.routes;this.resetVisible(t,e)}},immediate:!0,deep:!0}},methods:{calType:function(e){return e.children&&e.children.filter(function(e){return e.meta.show}).length?"el-submenu":"el-menu-item"},showOrNot:function(e){return!e.children||e.children&&e.children.filter(function(e){return e.meta.show}).length},handleOpen:function(e,t){},handleClose:function(e,t){},resetVisible:function(e,t){var n=this;e.map(function(e,r){e.hasOwnProperty("children")&&(e.children.map(function(n,r){-1===t.indexOf(e.children[r].meta.can)&&(e.children[r].meta.show=!1)}),n.resetVisible(e.children,t))})}},created:function(){var e,t=this;return(e=regeneratorRuntime.mark(function e(){var n;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:t.defaultActive=t.$route.path,t.privileges&&t.privileges.length&&(n=t.router.options.routes,t.resetVisible(n,t.privileges));case 2:case"end":return e.stop()}},e,t)}),function(){var t=e.apply(this,arguments);return new Promise(function(e,n){return function r(o,i){try{var a=t[o](i),s=a.value}catch(e){return void n(e)}if(!a.done)return Promise.resolve(s).then(function(e){r("next",e)},function(e){r("throw",e)});e(s)}("next")})})()}},N={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"l-menu-wrap"},[n("div",{directives:[{name:"show",rawName:"v-show",value:!e.isCollapse,expression:"!isCollapse"}],staticClass:"ls-top-logo"},[n("p",[e._v(e._s(e.appName)+"管理面板")])]),e._v(" "),n("div",{directives:[{name:"show",rawName:"v-show",value:e.isCollapse,expression:"isCollapse"}],staticClass:"ls-top-logo-narrow"},[e._v(e._s(e.appShortName))]),e._v(" "),n("el-menu",{ref:"sidemenu",staticClass:"el-menu-vertical",attrs:{"unique-opened":!0,router:"","default-active":e.defaultActive,collapse:e.isCollapse},on:{open:e.handleOpen,close:e.handleClose}},[e._l(e.router.options.routes,function(t,r){return[e.showOrNot(t)?[e._l(t.children,function(t){return[e.showOrNot(t)?n("cell",{attrs:{item:t,type:e.calType(t)}}):e._e()]})]:e._e()]})],2)],1)},staticRenderFns:[]};var R={components:{"backend-top":h,"backend-menu":n("VU/8")(_,N,!1,function(e){n("O3nn")},"data-v-48baad5a",null).exports},computed:{isCollapse:function(){return this.$store.state.system.isCollapse}},mounted:function(){}},w={render:function(){var e=this.$createElement,t=this._self._c||e;return t("el-container",{staticClass:"ls-container"},[t("div",{staticClass:"ls-aside"},[t("div",{staticClass:"ls-left"},[t("backend-menu")],1)]),this._v(" "),t("div",{staticClass:"ls-content"},[t("div",{staticClass:"ls-top"},[t("backend-top",[t("template",{slot:"top-items"})],2)],1),this._v(" "),t("div",{staticClass:"ls-main"},[t("div",{staticClass:"ls-main-inner"},[t("router-view")],1)])])])},staticRenderFns:[]};var S=n("VU/8")(R,w,!1,function(e){n("Cfie"),n("wu2F")},"data-v-d41dec72",null).exports,E={render:function(){var e=this.$createElement;return(this._self._c||e)("router-view")},staticRenderFns:[]},j=n("VU/8")(null,E,!1,null,null,null).exports;r.default.use(a.a);var M,P,y,x=new a.a({mode:"hash",base:"/",saveScrollPosition:"true",routes:[{path:"/",component:S,meta:{can:"",show:!1,name:"根菜单"},children:[{path:"",component:function(){return Promise.all([n.e(0),n.e(1)]).then(n.bind(null,"XRHL"))},meta:{can:"dashboard",show:!1,name:"面板",font:"&#xe764;"}},{path:"/dashboard",component:function(){return Promise.all([n.e(0),n.e(1)]).then(n.bind(null,"XRHL"))},meta:{can:"dashboard",show:!0,name:"面板",font:"&#xe764;"}},{path:"/sniper/employee",component:j,meta:{can:"hr",show:!0,name:"人力资源",font:"&#xe612;"},children:[{path:"/sniper/employee/department",component:function(){return Promise.all([n.e(0),n.e(28)]).then(n.bind(null,"zq/K"))},meta:{can:"hr list departments",show:!0,name:"部门管理",font:"&#xe69a;"}},{path:"/sniper/employee/department/edit",component:function(){return Promise.all([n.e(0),n.e(13)]).then(n.bind(null,"m4Ix"))},meta:{can:"hr add departments",show:!1,name:"新增部门",font:"&#xe612;"}},{path:"/sniper/employee/department/detail",component:function(){return Promise.all([n.e(0),n.e(12)]).then(n.bind(null,"9Pj2"))},meta:{can:"hr list departments",show:!1,name:"部门详情",font:"&#xe612;"}},{path:"/sniper/employee/position",component:function(){return n.e(6).then(n.bind(null,"idzw"))},meta:{can:"hr positions",show:!0,name:"职位管理",font:"&#xe611;"}},{path:"/sniper/employee/position/edit",component:function(){return Promise.all([n.e(0),n.e(19)]).then(n.bind(null,"PHtR"))},meta:{can:"hr positions",show:!1,name:"编辑职位",font:"&#xe612;"}},{path:"/sniper/employee/employee/list",component:function(){return Promise.all([n.e(0),n.e(30)]).then(n.bind(null,"+dJ+"))},meta:{can:"hr employee",show:!0,name:"员工列表",font:"&#xe614;"}},{path:"/sniper/employee/employee/edit",component:function(){return Promise.all([n.e(0),n.e(29)]).then(n.bind(null,"wQ3f"))},meta:{can:"hr employee",show:!1,name:"新增/编辑员工",font:"&#xe614;"}},{path:"/sniper/employee/employee/attendance",component:function(){return n.e(7).then(n.bind(null,"DBCZ"))},meta:{can:"hr attendance",show:!0,name:"考勤记录",font:"&#xe629;"}},{path:"/sniper/employee/employee/attendance/detail",component:function(){return Promise.all([n.e(0),n.e(3)]).then(n.bind(null,"Kx+j"))},meta:{can:"hr attendance",show:!1,name:"考勤详情",font:"&#xe629;"}}]},{path:"/privileges",component:j,meta:{can:"privileges",show:!0,name:"权限系统",font:"&#xe70b;"},children:[{path:"/privileges/roles",component:function(){return n.e(10).then(n.bind(null,"gYjH"))},meta:{can:"privileges list roles",show:!0,name:"角色管理",font:"&#xe612;"}},{path:"/privileges/permissions",component:function(){return n.e(14).then(n.bind(null,"YMpQ"))},meta:{can:"privileges list permissions",show:!0,name:"权限管理",font:"&#xe70b;"}},{path:"/privileges/users",component:function(){return Promise.all([n.e(0),n.e(17)]).then(n.bind(null,"j1K9"))},meta:{can:"privileges list permissions",show:!0,name:"用户管理",font:"&#xe70b;"}},{path:"/privileges/roles/users",component:function(){return n.e(18).then(n.bind(null,"glAp"))},meta:{can:"privileges list role users",show:!1,name:"角色用户",font:""}},{path:"/privileges/roles/permissions",component:function(){return n.e(24).then(n.bind(null,"js6L"))},meta:{can:"privileges role permissions",show:!1,name:"角色权限",font:""}}]},{path:"/cms",component:j,meta:{can:"cms",show:!0,name:"内容管理",font:"&#xe764;"},children:[{path:"/cms/content",component:function(){return Promise.all([n.e(0),n.e(31)]).then(n.bind(null,"rh17"))},meta:{can:"cms list contents",show:!0,name:"内容管理",font:"&#xe764;"}},{path:"/cms/content/add",component:function(){return Promise.all([n.e(0),n.e(4)]).then(n.bind(null,"wvRB"))},meta:{can:"cms list contents",show:!1,name:"添加内容",font:"&#xe764;"}},{path:"/cms/content/edit",component:function(){return Promise.all([n.e(0),n.e(5)]).then(n.bind(null,"uSH3"))},meta:{can:"cms list contents",show:!1,name:"编辑内容",font:"&#xe764;"}},{path:"/cms/channel",component:function(){return Promise.all([n.e(0),n.e(8)]).then(n.bind(null,"J4LN"))},meta:{can:"cms list channels",show:!0,name:"栏目管理",font:"&#xe764;"}},{path:"/cms/position",component:j,meta:{can:"cms list contents",show:!0,name:"推荐管理",font:"&#xe764;"},children:[{path:"/cms/position/position",component:function(){return n.e(35).then(n.bind(null,"hCJu"))},meta:{can:"dashboard",show:!0,name:"推荐位",font:"&#xe764;"}},{path:"/cms/position/content",component:function(){return n.e(36).then(n.bind(null,"zV5m"))},meta:{can:"dashboard",show:!1,name:"内容管理",font:"&#xe764;"}},{path:"/cms/position/subs",component:function(){return n.e(34).then(n.bind(null,"n+mU"))},meta:{can:"dashboard",show:!1,name:"内容推荐位",font:"&#xe764;"}}]},{path:"/cms/comment",component:function(){return Promise.all([n.e(0),n.e(23)]).then(n.bind(null,"27ez"))},meta:{can:"cms list contents",show:!0,name:"评论管理",font:"&#xe764;"}},{path:"/cms/comment/content",component:function(){return Promise.all([n.e(0),n.e(15)]).then(n.bind(null,"RD01"))},meta:{can:"cms list contents",show:!1,name:"文章评论",font:"&#xe764;"}},{path:"/cms/setting",component:j,meta:{can:"cms setting",show:!0,name:"设置",font:"&#xe764;"},children:[{path:"/cms/setting/siteSetting",component:function(){return n.e(11).then(n.bind(null,"MCNe"))},meta:{can:"cms setting site",show:!0,name:"站点设置",font:"&#xe764;"}},{path:"/cms/setting/model",component:function(){return n.e(16).then(n.bind(null,"PaIR"))},meta:{can:"cms setting model",show:!0,name:"模型管理",font:"&#xe764;"}},{path:"/cms/setting/model/add",component:function(){return n.e(2).then(n.bind(null,"HOqM"))},meta:{can:"cms setting model",show:!1,name:"添加模型",font:"&#xe764;"}},{path:"/cms/setting/model/edit",component:function(){return n.e(2).then(n.bind(null,"HOqM"))},meta:{can:"cms setting model",show:!1,name:"编辑模型",font:"&#xe764;"}},{path:"/cms/setting/field/types",component:function(){return n.e(25).then(n.bind(null,"6dud"))},meta:{can:"cms setting fields",show:!0,name:"字段类型",font:"&#xe764;"}}]},{path:"/cms/operation",component:j,meta:{can:"cms operations",show:!0,name:"运营管理",font:"&#xe764;"},children:[{path:"/cms/operation/orders",component:function(){return Promise.all([n.e(0),n.e(20)]).then(n.bind(null,"MPvX"))},meta:{can:"cms operations",show:!0,name:"订单管理",font:"&#xe764;"}},{path:"/cms/operation/ads",component:function(){return n.e(27).then(n.bind(null,"gSSL"))},meta:{can:"cms ad operations",show:!0,name:"广告管理",font:"&#xe764;"}},{path:"/cms/operation/ad/positions",component:function(){return n.e(22).then(n.bind(null,"HA4w"))},meta:{can:"cms ad operations",show:!0,name:"广告位",font:"&#xe764;"}},{path:"/cms/operation/edit/ad",component:function(){return Promise.all([n.e(0),n.e(21)]).then(n.bind(null,"idiY"))},meta:{can:"cms ad operations",show:!1,name:"广告位",font:"&#xe764;"}}]}]}]},{path:"/login",component:function(){return n.e(9).then(n.bind(null,"Luci"))},meta:{name:"登录",show:!1}},{path:"/test",component:function(){return n.e(26).then(n.bind(null,"Y7I0"))},meta:{name:"test",show:!1}},{path:"/noPerm",component:function(){return n.e(33).then(n.bind(null,"Yevc"))},meta:{can:"",name:"test",show:!1}},{path:"*",component:function(){return n.e(32).then(n.bind(null,"FOIf"))}}]}),L=n("5reh");function T(e){return function(){var t=e.apply(this,arguments);return new Promise(function(e,n){return function r(o,i){try{var a=t[o](i),s=a.value}catch(e){return void n(e)}if(!a.done)return Promise.resolve(s).then(function(e){r("next",e)},function(e){r("throw",e)});e(s)}("next")})}}function A(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}var I,D,H={state:{appName:"LARACMS",appShortName:"LC",user:{},isCollapse:!1,csrf:null,accessToken:""},getters:(M={appName:function(e){return e.appName},appShortName:function(e){return e.appShortName},isCollapse:function(e){return e.isCollapse}},A(M,L.default.user,function(e){var t=Object.keys(e.user).length?e.user:JSON.parse(localStorage.getItem(L.default.user));return t||(t={}),t}),A(M,L.default.csrf,function(e){return localStorage.getItem(L.default.csrf)}),A(M,"accessToken",function(e){return e.accessToken||localStorage.getItem("accessToken")}),M),mutations:(P={toggleState:function(e){e.isCollapse=!e.isCollapse}},A(P,L.default.user,function(e,t){e.user=t,localStorage.setItem("user",JSON.stringify(t))}),A(P,L.default.csrf,function(e,t){e.csrf=t,localStorage.setItem(L.default.csrf,t)}),A(P,"accessToken",function(e,t){e.accessToken=t,t?localStorage.setItem("accessToken",t):localStorage.removeItem("accessToken")}),P),actions:(y={toggleState:function(e){(0,e.commit)("toggleState")},collapse:function(e){e.state.isCollapse=!0}},A(y,L.default.user,function(e,t){var n=this,r=e.commit;return T(regeneratorRuntime.mark(function e(){var o;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(!t){e.next=4;break}r(L.default.user,t),e.next=9;break;case 4:return r(L.default.user,{}),e.next=7,s.a.getUserInfo();case 7:(o=e.sent)&&o.data&&r(L.default.user,o.data);case 9:case"end":return e.stop()}},e,n)}))()}),A(y,L.default.csrf,function(e){var t=this,n=e.commit;return T(regeneratorRuntime.mark(function e(){var r;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,s.a.csrf();case 2:(r=e.sent)&&r.data&&n(L.default.csrf,r.data);case 4:case"end":return e.stop()}},e,t)}))()}),A(y,L.default.logout,function(e){var t=this,n=e.commit;return T(regeneratorRuntime.mark(function e(){return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return n(L.default.user,{}),localStorage.removeItem(L.default.csrf),localStorage.removeItem(L.default.user),localStorage.removeItem(L.default.privileges),m.a.remove(L.default.logined),e.next=7,s.a.logout();case 7:e.sent,"api"==Object(c.b)()?n("accessToken",null):(alert("登出成功！"),location.href="/login");case 9:case"end":return e.stop()}},e,t)}))()}),y)};function U(e){return function(){var t=e.apply(this,arguments);return new Promise(function(e,n){return function r(o,i){try{var a=t[o](i),s=a.value}catch(e){return void n(e)}if(!a.done)return Promise.resolve(s).then(function(e){r("next",e)},function(e){r("throw",e)});e(s)}("next")})}}function k(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}var G,$,V={state:{loading:!1,models:[],channels:[],parentChannel:null,channelChildren:[],currentChannel:null,currentModel:null,currentChannelPosition:null,currentPosition:null},getters:{loading:function(e){return e.loading},models:function(e){return e.models},channels:function(e){return e.channels},channelChildren:function(e){return e.channelChildren},parentChannel:function(e){return e.parentChannel},currentChannel:function(e){return e.currentChannel},currentModel:function(e){return e.currentModel},currentChannelPosition:function(e){return e.currentChannelPosition},currentPosition:function(e){return e.currentPosition}},mutations:(I={},k(I,L.LOADING,function(e,t){e.loading=t}),k(I,L.CMS_MODELS,function(e,t){e.models=t}),k(I,L.CMS_CHANNELS,function(e,t){e.channels=t}),k(I,L.CMS_CHANNEL_CHILDREN,function(e,t){e.channelChildren=t}),k(I,L.CMS_PARENT_CHANNEL,function(e,t){e.parentChannel=t}),k(I,L.CMS_CURRENT_CHANNEL,function(e,t){e.currentChannel=t}),k(I,L.CMS_CURRENT_MODEL,function(e,t){e.currentModel=t}),k(I,L.CMS_CURRENT_CHANNEL_POSITION,function(e,t){e.currentChannelPosition=t}),k(I,L.CMS_CURRENT_POSITION,function(e,t){e.currentPosition=t}),I),actions:(D={},k(D,L.CMS_MODELS,function(e){var t=this,n=e.commit;return U(regeneratorRuntime.mark(function e(){var r;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return n(L.LOADING,!0),e.next=3,s.a.getCmsModels();case 3:r=e.sent,n(L.CMS_MODELS,r.data),n(L.LOADING,!1);case 6:case"end":return e.stop()}},e,t)}))()}),k(D,L.CMS_CHANNELS,function(e){var t=this,n=e.commit,r=e.dispatch,o=arguments.length>1&&void 0!==arguments[1]?arguments[1]:[null,0];return U(regeneratorRuntime.mark(function e(){var i,a;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return n(L.LOADING,!0),e.next=3,s.a.getCmsChannelTree({disabled:!0,has_contents:o[1]});case 3:i=e.sent,Object.keys(i.data).length>0&&(a=i.data[Object.keys(i.data)[0]],n(L.CMS_CHANNELS,[a]),r(L.CMS_CHANNEL_CHILDREN,a)),o[0]&&(r(L.CMS_PARENT_CHANNEL,o[0]),r(L.CMS_CHANNEL_CHILDREN,o[0])),n(L.LOADING,!1);case 7:case"end":return e.stop()}},e,t)}))()}),k(D,L.CMS_CHANNEL_CHILDREN,function(e,t){var n=this,r=e.commit;return U(regeneratorRuntime.mark(function e(){var o;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return r(L.LOADING,!0),e.next=3,s.a.getCmsChannelChildren({parent_id:t.id});case 3:o=e.sent,r(L.CMS_CHANNEL_CHILDREN,o.data),r(L.LOADING,!1);case 6:case"end":return e.stop()}},e,n)}))()}),k(D,L.CMS_PARENT_CHANNEL,function(e,t){(0,e.commit)(L.CMS_PARENT_CHANNEL,t)}),k(D,L.CMS_CURRENT_CHANNEL,function(e,t){(0,e.commit)(L.CMS_CURRENT_CHANNEL,t)}),k(D,L.CMS_CURRENT_MODEL,function(e,t){(0,e.commit)(L.CMS_CURRENT_MODEL,t)}),D)};function F(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}var J={state:{loading:!1,currentRole:null,privileges:[]},getters:F({currentRole:function(e){return e.currentRole}},L.default.privileges,function(e){var t=e.privileges&&e.privileges.length?e.privileges:localStorage.getItem(L.default.privileges);return t||(t=[]),t}),mutations:(G={},F(G,L.default.PRIVILEGE_CURRENT_ROLE,function(e,t){e.currentRole=t}),F(G,L.default.privileges,function(e,t){e.privileges=t,t&&t.length?localStorage.setItem(L.default.privileges,JSON.stringify(t)):localStorage.removeItem(L.default.privileges)}),G),actions:($={},F($,L.default.PRIVILEGE_CURRENT_ROLE,function(e,t){(0,e.commit)(L.default.PRIVILEGE_CURRENT_ROLE,t)}),F($,L.default.privileges,function(e){var t,n=this,r=e.commit;return(t=regeneratorRuntime.mark(function e(){var t;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return r(L.default.privileges,[]),e.next=3,s.a.getUserPermissions();case 3:(t=e.sent)&&t.data&&r(L.default.privileges,t.data);case 5:case"end":return e.stop()}},e,n)}),function(){var e=t.apply(this,arguments);return new Promise(function(t,n){return function r(o,i){try{var a=e[o](i),s=a.value}catch(e){return void n(e)}if(!a.done)return Promise.resolve(s).then(function(e){r("next",e)},function(e){r("throw",e)});t(s)}("next")})})()}),$)};r.default.use(u.a);var q=new u.a.Store({modules:{system:H,cms:V,privileges:J}}),B={render:function(){var e=this.$createElement;return(this._self._c||e)("router-view")},staticRenderFns:[]},Y=n("VU/8")({},B,!1,null,null,null).exports,z=n("HNM5");x.beforeEach(function(e,t,n){if("ajax"==Object(c.b)()&&"/"==e.path)n();else if(m.a.get(L.default.logined)||"/login"==e.path)if("/login"==e.path)localStorage.removeItem("accessToken"),n();else{var r=e.meta.can,o=localStorage.getItem(L.default.privileges);o&&o.length||n("/login"),-1===o.indexOf(r)&&n({path:"/noPerm"}),n()}else n("/login")}),r.default.directive("permission",{inserted:function(e,t){var n=t.value;-1===localStorage.getItem(L.default.privileges).indexOf(n)&&e.parentNode.removeChild(e)}}),window.$=n("7t+N"),r.default.config.productionTip=!1,r.default.use(i.a),r.default.prototype.fetch=z.a,r.default.prototype.$types=L,r.default.prototype.SITE_URL="http://39.99.224.136",r.default.prototype.ADMIN_URL="/admin",r.default.prototype.showMessage=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"error";return i.a.Message.closeAll(),i.a.Message({showClose:!0,message:e,type:t,duration:3500})},r.default.directive("title",{inserted:function(e,t){document.title=t.value;try{e.remove()}catch(t){e.removeNode(!0)}}});t.default=new r.default({el:"#app",router:x,store:q,components:{App:Y},template:"<App/>"})},O3nn:function(e,t){},UBeP:function(e,t){},YgNb:function(e,t,n){"use strict";n.d(t,"b",function(){return o}),n.d(t,"a",function(){return i});var r=n("rBKV"),o=function(){return-1!==location.origin.indexOf(r.SITE_URL.slice(1,-1))?"ajax":-1!==location.origin.indexOf("8000")?"ajax":"api"},i=function(e){var t;try{t=new Date(e)}catch(e){t=new Date}var n=t.getMonth()+1,r=t.getDate();n>=1&&n<=9&&(n="0"+n),r>=0&&r<=9&&(r="0"+r);var o=t.getHours(),i=t.getMinutes(),a=t.getSeconds();return o>=1&&o<=9&&(o="0"+o),i>=1&&i<=9&&(i="0"+i),a>=1&&a<=9&&(a="0"+a),t.getFullYear()+"-"+n+"-"+r+" "+o+":"+i+":"+a}},gyMJ:function(e,t,n){"use strict";var r=n("HNM5");t.a={login:function(e){return Object(r.a)("auth/login",e,"post")},logout:function(e){return Object(r.a)("auth/logout",e,"post")},getCmsModels:function(e){return Object(r.a)("/admin/cms/model",e)},getCmsChannelTree:function(e){return Object(r.a)("/admin/cms/channel/tree",e)},getCmsChannelChildren:function(e){return Object(r.a)("/admin/cms/channel/children",e)},createUser:function(e){return Object(r.a)("/admin/user/create",e)},updateUser:function(e){return Object(r.a)("/admin/user/update",e)},getUserInfo:function(e){return Object(r.a)("/admin/user/info",e)},csrf:function(e){return Object(r.a)("/csrf")},getUserPermissions:function(e){return Object(r.a)("/admin/privileges/user/permissions",e)},saveModelFieldType:function(e){return Object(r.a)("/admin/cms/model/field/type/save",e,"post")},getModelFieldTypes:function(e){return Object(r.a)("/admin/cms/model/field/types",e)},deleteCmsChannel:function(e){return Object(r.a)("/admin/cms/channel/delete",e,"post")},saveCmsChannel:function(e){return Object(r.a)("/admin/cms/channel/save",e,"post")},getCmsChannelWhole:function(e){return Object(r.a)("/admin/cms/channel/whole",e)},getCmsPositions:function(e){return Object(r.a)("/admin/cms/positions",e)},createRoleUser:function(e){return Object(r.a)("/admin/user/create/role/user",e,"post")},removeRoleModel:function(e){return Object(r.a)("/admin/privileges/remove/role/model",e,"post")},saveRole:function(e){return Object(r.a)("/admin/privileges/save/role",e,"post")},getRole:function(e){return Object(r.a)("/admin/privileges/role",e)},getRoles:function(e){return Object(r.a)("/admin/privileges/roles",e)},getUsers:function(e){return Object(r.a)("/admin/privileges/users",e)},getPosition:function(e){return Object(r.a)("/admin/cms/get/position",e)},getSubPositions:function(e){return Object(r.a)("/admin/cms/position/subs",e,"post")},savePosition:function(e){return Object(r.a)("/admin/cms/position/save",e,"post")},givePermissionsTo:function(e){return Object(r.a)("/admin/privileges/give/permissions/to",e,"post")},getPermissionsTree:function(e){return Object(r.a)("/admin/privileges/permissions/tree",e)},getRolePermissions:function(e){return Object(r.a)("/admin/privileges/role/permissions",e)},addPermission:function(e){return Object(r.a)("/admin/privileges/add/permission",e,"post")},editPermission:function(e){return Object(r.a)("/admin/privileges/edit/permission",e,"post")},deletePermission:function(e){return Object(r.a)("/admin/privileges/delete/permission",e,"post")},deleteContent:function(e){return Object(r.a)("/admin/cms/content/delete",e,"post")},saveContent:function(e){return Object(r.a)("/admin/cms/content/save",e,"post")},getModel:function(e){return Object(r.a)("/admin/cms/model/get",e)},getChannelContents:function(e){return Object(r.a)("/admin/cms/contents",e)},getWholeContent:function(e){return Object(r.a)("/admin/cms/content/whole",e)},getContentPositions:function(e){return Object(r.a)("/admin/cms/content/positions",e)},deleteModel:function(e){return Object(r.a)("/admin/cms/model/delete",e,"post")},addFieldType:function(e){return Object(r.a)("/admin/cms/model/field/type/add",e,"post")},getModels:function(e){return Object(r.a)("/admin/cms/model",e)},saveModelFieldOrder:function(e){return Object(r.a)("/admin/cms/model/save/field/order",e,"post")},deleteModelField:function(e){return Object(r.a)("/admin/cms/model/delete/field",e,"post")},saveModel:function(e){return Object(r.a)("/admin/cms/model/save",e,"post")},modelSaveField:function(e){return Object(r.a)("/admin/cms/model/save/field",e,"post")},getPositionContents:function(e){return Object(r.a)("/admin/cms/position/contents",e)},getRoleUsers:function(e){return Object(r.a)("/admin/privileges/role/users",e)},deleteRole:function(e){return Object(r.a)("/admin/privileges/delete/role",e,"post")},getComments:function(e){return Object(r.a)("/admin/cms/get/comments",e)},getContentComments:function(e){return Object(r.a)("/admin/cms/get/content/comments",e)},saveAdPosition:function(e){return Object(r.a)("/admin/cms/save/ad/position",e,"post")},getAdPositions:function(e){return Object(r.a)("/admin/cms/get/ad/positions",e)},getAds:function(e){return Object(r.a)("/admin/cms/get/ads",e)},getAd:function(e){return Object(r.a)("/admin/cms/get/ad",e)},deleteAdPosition:function(e){return Object(r.a)("/admin/cms/delete/ad/position",e)},deleteAd:function(e){return Object(r.a)("/admin/cms/delete/ad",e)},saveAd:function(e){return Object(r.a)("/admin/cms/save/ad",e,"post")},getOptionalTemplatePrefix:function(e){return Object(r.a)("/admin/cms/get/optional/template/prefix",e)},getOptionalTemplatePath:function(e){return Object(r.a)("/admin/cms/get/optional/template/path",e)},getOptionalThemes:function(e){return Object(r.a)("/admin/cms/get/optional/themes",e)},getOrders:function(e){return Object(r.a)("/admin/cms/orders",e)},saveSiteSetting:function(e){return Object(r.a)("/admin/cms/save/site/setting",e,"post")},getSiteSetting:function(e){return Object(r.a)("/admin/cms/get/site/setting",e)},sniperGetDepartmentLevel1:function(e){return Object(r.a)("/admin/sniper/employee/departments/level1",e)},sniperGetDepartmentsTreeSelect:function(e){return Object(r.a)("/admin/sniper/employee/departments/tree/select",e)},sniperSaveDepartment:function(e){return Object(r.a)("/admin/sniper/employee/save/department",e,"post")},sniperGetDepartmentDetail:function(e){return Object(r.a)("/admin/sniper/employee/get/department/detail",e)},sniperGetDepartmentDescendants:function(e){return Object(r.a)("/admin/sniper/employee/get/department/descendants",e)},sniperGetPositionsTreeSelect:function(e){return Object(r.a)("/admin/sniper/employee/positions/tree/select",e)},sniperSavePosition:function(e){return Object(r.a)("/admin/sniper/employee/save/position",e,"post")},sniperGetPositionDetail:function(e){return Object(r.a)("/admin/sniper/employee/get/position/detail",e)},sniperGetPositionDescendants:function(e){return Object(r.a)("/admin/sniper/employee/get/position/descendants",e)},sniperDeletePosition:function(e){return Object(r.a)("/admin/sniper/employee/delete/position",e,"post")},sniperSaveEmployee:function(e){return Object(r.a)("/admin/sniper/employee/save/employee",e,"post")},sniperGetDepartmentEmployee:function(e){return Object(r.a)("/admin/sniper/employee/department/employee",e)},sniperDeleteDepartment:function(e){return Object(r.a)("/admin/sniper/employee/delete/department",e,"post")},sniperGetEmployeeDetail:function(e){return Object(r.a)("/admin/sniper/employee/get/employee/detail",e)},sniperDeleteEmployeeEducation:function(e){return Object(r.a)("/admin/sniper/employee/delete/employee/education",e,"post")},sniperDeleteEmployeeJob:function(e){return Object(r.a)("/admin/sniper/employee/delete/employee/job",e,"post")},sniperDingGetDepartments:function(e){return Object(r.a)("/admin/sniper/employee/ding/get/departments",e)},sniperDingGetDepartmentUsers:function(e){return Object(r.a)("/admin/sniper/employee/ding/get/department/users",e)},sniperDingGetUsersAttendance:function(e){return Object(r.a)("/admin/sniper/employee/ding/get/users/attendance",e)},sniperDingGetWeekAvgAttendance:function(e){return Object(r.a)("/admin/sniper/employee/ding/get/user/week/attendance/avg",e)},sniperDingGetUser:function(e){return Object(r.a)("/admin/sniper/employee/ding/get/user",e)}}},icBJ:function(e,t){},rBKV:function(e,t,n){"use strict";e.exports={NODE_ENV:'"production"',SITE_URL:'"http://39.99.224.136"',ADMIN_URL:'"/admin"',APP_NAME:"思纳福",APP_SHORT_NAME:"SN"}},tvR6:function(e,t){},wu2F:function(e,t){}},["NHnr"]);
//# sourceMappingURL=app.c13f58a7ecda07150eeb.js.map