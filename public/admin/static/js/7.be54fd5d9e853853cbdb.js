webpackJsonp([7],{DBCZ:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=n("gyMJ"),s=n("NYxO"),a=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var r in n)Object.prototype.hasOwnProperty.call(n,r)&&(e[r]=n[r])}return e};function i(e){return function(){var t=e.apply(this,arguments);return new Promise(function(e,n){return function r(s,a){try{var i=t[s](a),o=i.value}catch(e){return void n(e)}if(!i.done)return Promise.resolve(o).then(function(e){r("next",e)},function(e){r("throw",e)});e(o)}("next")})}}var o={data:function(){return{customProps:{children:"children",label:"name"},treeData:[]}},props:{title:{type:String,default:""},updated:{type:Number,default:0}},watch:{updated:function(){var e=this;return i(regeneratorRuntime.mark(function t(){return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.updateTree();case 2:case"end":return t.stop()}},t,e)}))()}},computed:a({},Object(s.b)([])),methods:{handleNodeClick:function(e){this.$emit("nodeClick",e)},updateTree:function(){var e=this;return i(regeneratorRuntime.mark(function t(){var n;return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,r.a.sniperDingGetDepartments();case 2:(n=t.sent).hasError||(e.treeData=[n.data],e.$emit("treeLoaded",e.treeData[0]));case 4:case"end":return t.stop()}},t,e)}))()}},mounted:function(){var e=this;return i(regeneratorRuntime.mark(function t(){return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.updateTree();case 2:case"end":return t.stop()}},t,e)}))()}},u={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"l-tree-containner"},[e.title?n("view",[e._v(e._s(e.title))]):e._e(),e._v(" "),n("el-tree",{ref:"tree",attrs:{"icon-class":"el-icon-caret-right","default-expand-all":!0,data:e.treeData,"node-key":"id",props:e.customProps,"highlight-current":!0,"expand-on-click-node":!1},on:{"node-click":e.handleNodeClick},scopedSlots:e._u([{key:"default",fn:function(t){var r=t.node,s=t.data;return n("span",{staticClass:"custom-tree-node"},[n("span",[s.children||s.children.length?e._e():n("span",{staticClass:"iconfont"},[e._v("")]),e._v(e._s(r.label))])])}}])})],1)},staticRenderFns:[]};var l,c=n("VU/8")(o,u,!1,function(e){n("scuN")},null,null).exports,d=n("zL8q");function f(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function p(e){return function(){var t=e.apply(this,arguments);return new Promise(function(e,n){return function r(s,a){try{var i=t[s](a),o=i.value}catch(e){return void n(e)}if(!i.done)return Promise.resolve(o).then(function(e){r("next",e)},function(e){r("throw",e)});e(o)}("next")})}}var v={components:{DingDepartmentTree:c},data:function(){return{months:["2020-05","2020-06","2020-07","2020-08","2020-09","2020-10"],month:"2020-10",eventCats:["所有","迟到","请假","缺卡","早退"],eventCat:"所有",updated:0,department:null,users:[],specUsers:[],lateUser:[],earlyUsers:[],holidayUsers:[],notSignedUsers:[]}},watch:(l={},f(l,"department.id",function(e){var t=this;return p(regeneratorRuntime.mark(function n(){return regeneratorRuntime.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:return n.next=2,t.getDepartmentUsers({id:e});case 2:case"end":return n.stop()}},n,t)}))()}),f(l,"month",function(e){var t=this;return p(regeneratorRuntime.mark(function e(){return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.getDepartmentUsers(t.department);case 2:return e.next=4,t.getDepartmentWeekAvgAttendance();case 4:case"end":return e.stop()}},e,t)}))()}),f(l,"eventCat",function(e){this.assignUsers(e)}),l),methods:{assignUsers:function(e){this.specUsers="迟到"==e?this.lateUsers:"早退"==e?this.earlyUsers:"请假"==e?this.holidayUsers:"缺卡"==e?this.notSignedUsers:this.users},viewMonth:function(e){this.month=e.target.innerText},viewCat:function(e){this.eventCat=e.target.innerText},resultHtml:function(e){var t=e.result,n="";return t.Late&&(n+='<span style="color: #dd7777">迟到'+t.Late+"次</span>"),t.Early&&(n+='<span style="color: orange">早退'+t.Early+"次</span>"),t.NotSigned&&(n+='<span style="color: gray">缺卡'+t.NotSigned+"次</span>"),e.leave&&e.leave.length&&(n+='<span title="'+e.leaveStr+'"><span  style="color: darkorange;font-weight: normal;"><span class="iconfont">&#xe60b;</span>请假'+e.leave.length+"次</span></span>"),n||(n='<span style="color: green">正常</span>'),n},viewDetail:function(e){e.userid;if(this.month)this.month;else{var t=new Date,n=(t.getFullYear(),t.getMonth()+1);n<10&&(n="0"+n),"-"+n}this.$router.push("/sniper/employee/employee/attendance/detail?userId="+e.userid)},handleNodeClick:function(e){this.department=e},performTreeLoaded:function(e){this.department=e},getDepartmentUsers:function(e){var t=this,n=e.id;return p(regeneratorRuntime.mark(function e(){var s,a,i;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return s=d.Loading.service({fullscreen:!0,text:"获取中...",background:"rgba(255,255,255,0.8)"}),e.next=3,r.a.sniperDingGetDepartmentUsers({id:n});case 3:return a=e.sent,i=a.data.map(function(e){return e.userid}),t.users=a.data,e.next=8,t.getUsersAttendance({userIds:i});case 8:s.close();case 9:case"end":return e.stop()}},e,t)}))()},getUsersAttendance:function(e){var t=this,n=e.userIds;return p(regeneratorRuntime.mark(function e(){var s,a,i,o,u,l,c,d,f,p,v;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return s=t.month,e.next=3,r.a.sniperDingGetUsersAttendance({userIds:n,month:s});case 3:for(u in a=e.sent,i=a.data,o={},i)for(l in i[u])for(c in o[u]||(o[u]={}),i[u][l])o[u][i[u][l][c].timeResult]||(o[u][i[u][l][c].timeResult]=0),i[u][l][c].approveId||i[u][l][c].procInstId||(o[u][i[u][l][c].timeResult]+=1);for(d in o)for(f in t.users)if(t.users[f].userid==d){for(v in t.$set(t.users[f],"result",o[d]),t.$set(t.users[f],"leave",i[d].leave),p="",i[d].leave)p+="["+i[d].leave[v].start_time+"~"+i[d].leave[v].end_time+"],";t.$set(t.users[f],"leaveStr",p.slice(0,-1))}t.lateUsers=t.users.filter(function(e){return e.result&&e.result.Late}).sort(function(e,t){return t.result.Late-e.result.Late}),t.earlyUsers=t.users.filter(function(e){return e.result&&e.result.Early}).sort(function(e,t){return t.result.Early-e.result.Early}),t.holidayUsers=t.users.filter(function(e){return e.leave&&e.leave.length}).sort(function(e,t){return t.leave.length-e.leave.length}),t.notSignedUsers=t.users.filter(function(e){return e.result&&e.result.NotSigned}).sort(function(e,t){return t.result.NotSigned-e.result.NotSigned}),t.assignUsers(t.eventCat);case 13:case"end":return e.stop()}},e,t)}))()}}},m={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"l-attendance-list"},[n("div",{directives:[{name:"title",rawName:"v-title",value:"考勤记录",expression:"'考勤记录'"}]}),e._v(" "),n("ding-department-tree",{staticClass:"l-tree",attrs:{updated:e.updated},on:{nodeClick:e.handleNodeClick,treeLoaded:e.performTreeLoaded}}),e._v(" "),n("div",{staticClass:"l-block"},[n("div",{staticClass:"l-block-header"},[e._v("\n            "+e._s(e.department?e.department.name:"")+"\n        ")]),e._v(" "),n("div",{staticClass:"l-block-body"},[n("div",{staticClass:"l-month-select"},[n("ul",{staticStyle:{width:"50%","border-bottom":"1px solid #f1f1f1","padding-bottom":"10px","margin-bottom":"10px"}},[n("li",{staticStyle:{border:"none",cursor:"default"}},[e._v("月份")]),e._v(" "),e._l(e.months,function(t){return n("li",{class:{active:e.month==t},on:{click:e.viewMonth}},[e._v(e._s(t))])})],2),e._v(" "),n("ul",{staticStyle:{width:"50%"}},[n("li",{staticStyle:{border:"none",cursor:"default"}},[e._v("分类")]),e._v(" "),e._l(e.eventCats,function(t){return n("li",{class:{active:e.eventCat==t},on:{click:e.viewCat}},[e._v(e._s(t))])})],2)]),e._v(" "),n("div",{staticClass:"l-user-wrap"},e._l(e.specUsers,function(t,r){return n("div",{key:r,staticClass:"l-user",on:{click:function(n){return e.viewDetail(t)}}},[n("div",{staticStyle:{"border-bottom":"1px solid #f1f1f1","padding-bottom":"10px"}},[n("div",[n("p",[e._v(e._s(t.name))]),n("small",{staticStyle:{color:"#fff",display:"none"}},[e._v(e._s(t.userid))])]),e._v(" "),n("div",[n("small",{staticStyle:{color:"#afafaf"}},[e._v(e._s(t.orgEmail?t.orgEmail:"-"))])])]),e._v(" "),n("div",[t.result?n("div",[n("small",[n("span",{staticStyle:{"font-weight":"lighter"},domProps:{innerHTML:e._s(e.resultHtml(t))}})])]):e._e()])])}),0)])])],1)},staticRenderFns:[]};var h=n("VU/8")(v,m,!1,function(e){n("p+5e")},"data-v-42ca2420",null);t.default=h.exports},"p+5e":function(e,t){},scuN:function(e,t){}});
//# sourceMappingURL=7.be54fd5d9e853853cbdb.js.map