webpackJsonp([13],{"56Pv":function(e,s){},Luci:function(e,s,t){"use strict";Object.defineProperty(s,"__esModule",{value:!0});var a=t("Xxa5"),r=t.n(a),o=t("exGp"),n=t.n(o),i=t("gyMJ"),l=t("rBKV"),c=t.n(l),p={data:function(){return{loading:!1,loginFont:"登录",params:{mobile:"13222988085",password:"11111111"},rules:{}}},computed:{appName:function(){return c.a.APP_NAME},accessToken:function(){return this.$store.getters.accessToken}},watch:{accessToken:function(e){console.log("access token from store:",e)}},methods:{requireMobile:function(){""==this.params.mobile?$("#mobile").addClass("error").text("input mobile"):$("#mobile").removeClass("error").text(" ")},requirePassword:function(){""==this.params.password?$("#password").addClass("error").text("input password"):$("#password").removeClass("error").text(" ")},changePassword:function(){$("#password").removeClass("error").text("")},login:function(){var e=this;return n()(r.a.mark(function s(){var t,a;return r.a.wrap(function(s){for(;;)switch(s.prev=s.next){case 0:if(e.params.mobile&&e.params.password){s.next=5;break}e.requireMobile(),e.requirePassword(),s.next=22;break;case 5:return e.loading=!0,e.loginFont="logining...",s.next=9,i.a.login(e.params);case 9:if(200!=(t=s.sent).code){s.next=20;break}return t.data.access_token&&e.$store.commit(e.$types.ACCESS_TOKEN,t.data.access_token),t.data.user&&e.$store.commit(e.$types.USER,t.data.user),s.next=15,i.a.getUserPermissions();case 15:(a=s.sent)&&a.data&&e.$store.commit(e.$types.PRIVILEGES,a.data),e.$router.push("/dashboard"),s.next=21;break;case 20:4011==t.code&&e.reset();case 21:e.reset();case 22:case"end":return s.stop()}},s,e)}))()},reset:function(){this.loading=!1,this.loginFont="Login",this.params.password=""}}},m={render:function(){var e=this,s=e.$createElement,t=e._self._c||s;return t("el-card",{staticClass:"box-card"},[t("div",{staticClass:"clearfix",attrs:{slot:"header"},slot:"header"},[t("h3",[e._v(e._s(e.appName)+"管理系统")])]),e._v(" "),t("el-form",{ref:"ruleForm",staticClass:"demo-ruleForm",attrs:{model:e.params,"status-icon":"",rules:e.rules,"label-width":"0"}},[t("el-form-item",{attrs:{prop:"mobile"}},[t("label",[e._v("用户名")]),e._v(" "),t("el-input",{attrs:{type:"text",autocomplete:"off"},model:{value:e.params.mobile,callback:function(s){e.$set(e.params,"mobile",s)},expression:"params.mobile"}})],1),e._v(" "),t("el-form-item",{attrs:{prop:"password"}},[t("label",[e._v("密码")]),e._v(" "),t("el-input",{attrs:{type:"password",autocomplete:"off"},model:{value:e.params.password,callback:function(s){e.$set(e.params,"password",s)},expression:"params.password"}})],1),e._v(" "),t("el-form-item",[t("el-button",{staticStyle:{width:"100%","margin-top":"20px"},attrs:{size:"medium",loading:e.loading,type:"primary"},on:{click:e.login}},[e._v(e._s(e.loginFont))])],1)],1)],1)},staticRenderFns:[]};var d=t("VU/8")(p,m,!1,function(e){t("56Pv")},"data-v-7e8c45d6",null);s.default=d.exports}});
//# sourceMappingURL=13.bea122ac55b756af329c.js.map