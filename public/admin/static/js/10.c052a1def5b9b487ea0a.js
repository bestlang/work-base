webpackJsonp([10],{HMrr:function(e,t){},idiY:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=a("woOf"),l=a.n(r),o=a("Xxa5"),i=a.n(o),n=a("mvHQ"),s=a.n(n),m=a("exGp"),c=a.n(m),d=(a("trTH"),a("FO7G")),f=a("jk0Z"),u=a("gyMJ"),v=a("YgNb"),p={data:function(){return{formTitle:"添加广告",w:"80px",positions:[],form:{id:"",name:"",position_id:"",enabled:1,start_time:null,end_time:null,time_range:[this.start_time,this.end_time],type:1,url:"",text:"",code:"",image:null,tiny_image:null,target:"_black"}}},components:{imageUpload:d.a,attachment:f.a},methods:{goback:function(){this.$router.push("/cms/operation/ads")},saveAd:function(){var e=this;return c()(i.a.mark(function t(){var a,r;return i.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return e.form.start_time=Object(v.a)(e.form.time_range[0]),e.form.end_time=Object(v.a)(e.form.time_range[1]),t.next=4,u.a.saveAd(e.form);case 4:(a=t.sent).success?(r="修改成功!",e.form.id||(r="添加成功!"),e.$message({type:"success",message:r}),e.goback()):alert(s()(a));case 6:case"end":return t.stop()}},t,e)}))()},getAdPositions:function(){var e=this;return c()(i.a.mark(function t(){var a;return i.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,u.a.getAdPositions();case 2:a=t.sent,e.positions=a.data;case 4:case"end":return t.stop()}},t,e)}))()},getAd:function(e){var t=this;return c()(i.a.mark(function a(){var r;return i.a.wrap(function(a){for(;;)switch(a.prev=a.next){case 0:if(!e){a.next=6;break}return a.next=3,u.a.getAd({id:e});case 3:r=a.sent,l()(t.form,r.data),t.form.time_range=[r.data.start_time,r.data.end_time];case 6:case"end":return a.stop()}},a,t)}))()}},mounted:function(){var e=this;return c()(i.a.mark(function t(){var a;return i.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return a=parseInt(e.$route.query.id)||0,t.next=3,e.getAd(a);case 3:return t.next=5,e.getAdPositions();case 5:case"end":return t.stop()}},t,e)}))()}},_={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"l-content-list"},[a("div",{directives:[{name:"title",rawName:"v-title",value:e.formTitle,expression:"formTitle"}]}),e._v(" "),a("div",{staticClass:"l-tree-content"},[a("div",{staticClass:"l-block"},[a("div",{staticClass:"l-block-header"},[a("div",[a("span",{staticClass:"l-go-back",on:{click:e.goback}},[a("span",{staticClass:"iconfont"},[e._v("")]),e._v("返回")]),e._v(" "),a("el-divider",{attrs:{direction:"vertical"}}),e._v(" "),a("span",[e._v(e._s(e.formTitle))])],1)]),e._v(" "),a("div",{staticClass:"l-block-body"},[a("el-form",{attrs:{"label-width":"100px"}},[a("el-form-item",{attrs:{label:"广告名称","label-width":e.w}},[a("el-input",{attrs:{name:"name"},model:{value:e.form.name,callback:function(t){e.$set(e.form,"name",t)},expression:"form.name"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"广告位","label-width":e.w}},[a("el-select",{attrs:{placeholder:"请选择"},model:{value:e.form.position_id,callback:function(t){e.$set(e.form,"position_id",t)},expression:"form.position_id"}},e._l(e.positions,function(e){return a("el-option",{key:e.id,attrs:{label:e.name,value:e.id}})}),1)],1),e._v(" "),a("el-form-item",{attrs:{label:"启用","label-width":e.w}},[a("el-radio-group",{model:{value:e.form.enabled,callback:function(t){e.$set(e.form,"enabled",t)},expression:"form.enabled"}},[a("el-radio",{attrs:{label:1}},[e._v("是")]),e._v(" "),a("el-radio",{attrs:{label:0}},[e._v("否")])],1)],1),e._v(" "),a("el-form-item",{attrs:{label:"起止时间","label-width":e.w}},[a("el-date-picker",{attrs:{type:"datetimerange","range-separator":"至","start-placeholder":"开始日期","end-placeholder":"结束日期"},model:{value:e.form.time_range,callback:function(t){e.$set(e.form,"time_range",t)},expression:"form.time_range"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"类型","label-width":e.w}},[a("el-radio-group",{model:{value:e.form.type,callback:function(t){e.$set(e.form,"type",t)},expression:"form.type"}},[a("el-radio",{attrs:{label:1}},[e._v("图片")]),e._v(" "),a("el-radio",{attrs:{label:2}},[e._v("文字")]),e._v(" "),a("el-radio",{attrs:{label:3}},[e._v("代码")])],1)],1),e._v(" "),1==e.form.type?[a("el-form-item",{attrs:{label:"图片","label-width":e.w}},[a("image-upload",{model:{value:e.form.image,callback:function(t){e.$set(e.form,"image",t)},expression:"form.image"}})],1),e._v(" "),a("el-form-item",{attrs:{label:"窄屏图片","label-width":e.w}},[a("image-upload",{model:{value:e.form.tiny_image,callback:function(t){e.$set(e.form,"tiny_image",t)},expression:"form.tiny_image"}})],1)]:e._e(),e._v(" "),3==e.form.type?a("el-form-item",{attrs:{label:"代码","label-width":e.w}},[a("el-input",{attrs:{type:"textarea"},model:{value:e.form.code,callback:function(t){e.$set(e.form,"code",t)},expression:"form.code"}})],1):e._e(),e._v(" "),2==e.form.type?a("el-form-item",{attrs:{label:"文字内容","label-width":e.w}},[a("el-input",{attrs:{name:"url"},model:{value:e.form.text,callback:function(t){e.$set(e.form,"text",t)},expression:"form.text"}})],1):e._e(),e._v(" "),3!=e.form.type?a("el-form-item",{attrs:{label:"URL","label-width":e.w}},[a("el-input",{attrs:{name:"url"},model:{value:e.form.url,callback:function(t){e.$set(e.form,"url",t)},expression:"form.url"}})],1):e._e(),e._v(" "),a("el-form-item",{attrs:{label:"跳转方式","label-width":e.w}},[a("el-radio-group",{model:{value:e.form.target,callback:function(t){e.$set(e.form,"target",t)},expression:"form.target"}},[a("el-radio",{attrs:{label:"_black"}},[e._v("新页面")]),e._v(" "),a("el-radio",{attrs:{label:"_self"}},[e._v("当前页")])],1)],1),e._v(" "),a("el-form-item",[a("el-button",{attrs:{type:"primary",size:"small"},on:{click:e.saveAd}},[e._v("提交")])],1)],2)],1)])])])},staticRenderFns:[]};var b=a("VU/8")(p,_,!1,function(e){a("HMrr")},"data-v-5656948e",null);t.default=b.exports}});
//# sourceMappingURL=10.c052a1def5b9b487ea0a.js.map