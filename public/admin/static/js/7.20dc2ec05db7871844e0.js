webpackJsonp([7],{DBCZ:function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=r("gyMJ"),a=r("NYxO"),s=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var n in r)Object.prototype.hasOwnProperty.call(r,n)&&(e[n]=r[n])}return e};function i(e){return function(){var t=e.apply(this,arguments);return new Promise(function(e,r){return function n(a,s){try{var i=t[a](s),o=i.value}catch(e){return void r(e)}if(!i.done)return Promise.resolve(o).then(function(e){n("next",e)},function(e){n("throw",e)});e(o)}("next")})}}var o={data:function(){return{customProps:{children:"children",label:"name"},treeData:[]}},props:{title:{type:String,default:""},updated:{type:Number,default:0}},watch:{updated:function(){var e=this;return i(regeneratorRuntime.mark(function t(){return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.updateTree();case 2:case"end":return t.stop()}},t,e)}))()}},computed:s({},Object(a.b)([])),methods:{handleNodeClick:function(e){this.$emit("nodeClick",e)},updateTree:function(){var e=this;return i(regeneratorRuntime.mark(function t(){var r;return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,n.a.sniperDingGetDepartments();case 2:(r=t.sent).hasError||(e.treeData=[r.data],e.$emit("treeLoaded",e.treeData[0]));case 4:case"end":return t.stop()}},t,e)}))()}},mounted:function(){var e=this;return i(regeneratorRuntime.mark(function t(){return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.updateTree();case 2:case"end":return t.stop()}},t,e)}))()}},u={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"l-tree-containner"},[e.title?r("view",[e._v(e._s(e.title))]):e._e(),e._v(" "),r("el-tree",{ref:"tree",attrs:{"icon-class":"el-icon-caret-right","default-expand-all":!0,data:e.treeData,"node-key":"id",props:e.customProps,"highlight-current":!0,"expand-on-click-node":!1},on:{"node-click":e.handleNodeClick},scopedSlots:e._u([{key:"default",fn:function(t){var n=t.node,a=t.data;return r("span",{staticClass:"custom-tree-node"},[r("span",[a.children||a.children.length?e._e():r("span",{staticClass:"iconfont"},[e._v("")]),e._v(e._s(n.label))])])}}])})],1)},staticRenderFns:[]};function c(e){return function(){var t=e.apply(this,arguments);return new Promise(function(e,r){return function n(a,s){try{var i=t[a](s),o=i.value}catch(e){return void r(e)}if(!i.done)return Promise.resolve(o).then(function(e){n("next",e)},function(e){n("throw",e)});e(o)}("next")})}}var l,d,p,f={components:{DingDepartmentTree:r("VU/8")(o,u,!1,function(e){r("scuN")},null,null).exports},data:function(){return{updated:0,department:null,users:[]}},watch:(l={},d="department.id",p=function(e){var t=this;return c(regeneratorRuntime.mark(function r(){return regeneratorRuntime.wrap(function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,t.getDepartmentUsers({id:e});case 2:case"end":return r.stop()}},r,t)}))()},d in l?Object.defineProperty(l,d,{value:p,enumerable:!0,configurable:!0,writable:!0}):l[d]=p,l),methods:{resultHtml:function(e){var t="";return e.Late&&(t+='<span style="color: #dd7777">迟到'+e.Late+"次</span>"),e.Early&&(t+='<span style="color: orange">早退'+e.Early+"次</span>"),e.NotSigned&&(t+='<span style="color: gray">未打卡'+e.NotSigned+"次</span>"),t||(t='<span style="color: green">正常</span>'),t},viewDetail:function(e){e.userid;var t=new Date,r=t.getFullYear(),n=t.getMonth()+1;n<10&&(n="0"+n),r+="-"+n,this.$router.push("/sniper/employee/employee/attendance/detail?userId="+e.userid+"&month="+r)},handleNodeClick:function(e){this.department=e,console.log("node click:"+JSON.stringify(e))},performTreeLoaded:function(e){console.log("performTreeLoaded:"+JSON.stringify(e)),this.department=e},getDepartmentUsers:function(e){var t=this,r=e.id;return c(regeneratorRuntime.mark(function e(){var a,s;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,n.a.sniperDingGetDepartmentUsers({id:r});case 2:return a=e.sent,s=a.data.map(function(e){return e.userid}),t.users=a.data,e.next=7,t.getUsersAttendance({userIds:s});case 7:case"end":return e.stop()}},e,t)}))()},getUsersAttendance:function(e){var t=this,r=e.userIds;return c(regeneratorRuntime.mark(function e(){var a,s,i,o,u,c,l,d,p,f;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,n.a.sniperDingGetUsersAttendance({userIds:r});case 2:for(o in a=e.sent,s=a.data,i={},s)for(u in s[o])for(c in i[o]||(i[o]={}),s[o][u])i[o][s[o][u][c].timeResult]||(i[o][s[o][u][c].timeResult]=0),s[o][u][c].approveId||s[o][u][c].procInstId||(i[o][s[o][u][c].timeResult]+=1);for(l in i)for(d in t.users)if(t.users[d].userid==l){for(f in t.$set(t.users[d],"result",i[l]),t.$set(t.users[d],"leave",s[l].leave),p="",s[l].leave)p+="["+s[l].leave[f].start_time+"~"+s[l].leave[f].end_time+"],";t.$set(t.users[d],"leaveStr",p.slice(0,-1))}console.log("lastArr:"+JSON.stringify(i));case 8:case"end":return e.stop()}},e,t)}))()}}},v={render:function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"l-attendance-list"},[r("div",{directives:[{name:"title",rawName:"v-title",value:"考勤记录",expression:"'考勤记录'"}]}),e._v(" "),r("ding-department-tree",{staticClass:"l-tree",attrs:{updated:e.updated},on:{nodeClick:e.handleNodeClick,treeLoaded:e.performTreeLoaded}}),e._v(" "),r("div",{staticClass:"l-block"},[r("div",{staticClass:"l-block-header"},[e._v("\n            "+e._s(e.department?e.department.name:"")+"\n        ")]),e._v(" "),r("div",{staticClass:"l-block-body"},[r("div",{staticClass:"l-user-wrap"},e._l(e.users,function(t,n){return r("div",{key:n,staticClass:"l-user",on:{click:function(r){return e.viewDetail(t)}}},[r("div",{staticStyle:{"border-bottom":"1px solid #f1f1f1","padding-bottom":"10px"}},[r("div",[r("p",[e._v(e._s(t.name))]),r("small",{staticStyle:{color:"#fff",display:"none"}},[e._v(e._s(t.userid))])]),e._v(" "),r("div",[r("small",{staticStyle:{color:"#afafaf"}},[e._v(e._s(t.orgEmail?t.orgEmail:"-"))])])]),e._v(" "),r("div",[t.result?r("div",[r("small",[e._v("本月：\n                                        "),r("span",{staticStyle:{"font-weight":"lighter"},domProps:{innerHTML:e._s(e.resultHtml(t.result))}}),e._v(" "),t.leave&&t.leave.length?r("span",{attrs:{title:t.leaveStr}},[r("small",{staticStyle:{color:"darkorange","font-weight":"normal"}},[r("span",{staticClass:"iconfont"},[e._v("")]),e._v("请假"+e._s(t.leave.length)+"次")])]):e._e()])]):e._e()]),e._v(" "),r("div")])}),0)])])],1)},staticRenderFns:[]};var m=r("VU/8")(f,v,!1,function(e){r("Y5Ba")},"data-v-078d4d56",null);t.default=m.exports},Y5Ba:function(e,t){},scuN:function(e,t){}});
//# sourceMappingURL=7.20dc2ec05db7871844e0.js.map