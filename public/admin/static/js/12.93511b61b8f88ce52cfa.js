webpackJsonp([12],{"70YF":function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var l=a("mvHQ"),r=a.n(l),i=a("pFkg"),s=a.n(i),o={data:function(){return{uploadUrl:s.a.SITE_URL+"/api/admin/file/upload",headers:{Authorization:"Bearer "+localStorage.getItem("accessToken")},form:{name:"",start_time:"",end_time:"",type:3,detail:"",thumbnail:"",galleries:[],status:0,applicable:0},statusArr:[],thumbnailFileList:[],galleryFileList:[]}},computed:{types:function(){return this.$store.getters.activityTypes},activityApplicables:function(){return this.$store.getters.activityApplicables}},mounted:function(){this.loadStatusArr()},methods:{loadStatusArr:function(){var t=this;this.$http.get("/admin/activity/status").then(function(e){console.log(e),t.statusArr=e.data.statusArr})},preview:function(t){window.open(t.url)},thumbnailSuccess:function(t,e,a){this.form.thumbnail=t.data.file},thumbnailRemove:function(t,e){this.form.thumbnail=""},gallerySuccess:function(t,e,a){this.form.galleries.push(t.data.file)},galleryRemove:function(t,e){this.form.galleries=this.form.galleries.filter(function(e){return e!=t.response.data.file})},onSubmit:function(){alert(r()(this.form))}}},n={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("el-row",[a("el-col",{attrs:{span:18}},[a("el-form",{ref:"form",attrs:{model:t.form,"label-width":"120px"}},[a("el-form-item",{attrs:{label:"类型"}},[a("el-radio-group",{model:{value:t.form.type,callback:function(e){t.$set(t.form,"type",e)},expression:"form.type"}},t._l(t.types,function(e,l){return a("el-radio",{key:l,attrs:{label:e.id}},[t._v(t._s(e.name))])}),1)],1),t._v(" "),a("el-form-item",{attrs:{label:"适应于"}},[a("el-radio-group",{model:{value:t.form.applicable,callback:function(e){t.$set(t.form,"applicable",e)},expression:"form.applicable"}},t._l(t.activityApplicables,function(e,l){return a("el-radio",{key:l,attrs:{label:l}},[t._v(t._s(e))])}),1)],1),t._v(" "),a("el-form-item",{attrs:{label:"名称"}},[a("el-input",{model:{value:t.form.name,callback:function(e){t.$set(t.form,"name",e)},expression:"form.name"}})],1),t._v(" "),a("el-form-item",{attrs:{label:"缩略图"}},[a("el-upload",{staticClass:"avatar-uploader",attrs:{action:t.uploadUrl,"on-remove":t.thumbnailRemove,"on-success":t.thumbnailSuccess,"file-list":t.thumbnailFileList,"list-type":"picture-card","show-file-list":!1,name:"file",headers:t.headers}},[t.form.thumbnail?a("img",{staticClass:"avatar",attrs:{src:t.form.thumbnail}}):a("i",{staticClass:"el-icon-plus avatar-uploader-icon"})])],1),t._v(" "),a("el-form-item",{attrs:{label:"缩略图URL"}},[a("el-input",{model:{value:t.form.thumbnail,callback:function(e){t.$set(t.form,"thumbnail",e)},expression:"form.thumbnail"}})],1),t._v(" "),a("el-form-item",{attrs:{label:"开始"}},[a("el-col",{attrs:{span:11}},[a("el-date-picker",{staticStyle:{width:"100%"},attrs:{"value-format":"yyyy-MM-dd HH:mm:ss",type:"datetime",placeholder:"选择日期"},model:{value:t.form.start_time,callback:function(e){t.$set(t.form,"start_time",e)},expression:"form.start_time"}})],1)],1),t._v(" "),a("el-form-item",{attrs:{label:"结束"}},[a("el-col",{attrs:{span:11}},[a("el-date-picker",{staticStyle:{width:"100%"},attrs:{"value-format":"yyyy-MM-dd HH:mm:ss",type:"datetime",placeholder:"选择日期"},model:{value:t.form.end_time,callback:function(e){t.$set(t.form,"end_time",e)},expression:"form.end_time"}})],1)],1),t._v(" "),a("el-form-item",{attrs:{label:"描述"}},[a("el-input",{attrs:{type:"textarea"},model:{value:t.form.detail,callback:function(e){t.$set(t.form,"detail",e)},expression:"form.detail"}})],1),t._v(" "),a("el-form-item",{attrs:{label:"相册"}},[a("el-upload",{attrs:{"on-preview":t.preview,action:t.uploadUrl,"on-remove":t.galleryRemove,"on-success":t.gallerySuccess,"file-list":t.galleryFileList,"list-type":"picture-card",multiple:!0,name:"file",headers:t.headers}},[a("el-button",{attrs:{size:"small",type:"primary"}},[t._v("点击上传")]),t._v(" "),a("div",{staticClass:"el-upload__tip",attrs:{slot:"tip"},slot:"tip"})],1)],1),t._v(" "),a("el-form-item",{attrs:{label:"状态"}},[a("el-radio-group",{model:{value:t.form.status,callback:function(e){t.$set(t.form,"status",e)},expression:"form.status"}},t._l(t.statusArr,function(e,l){return a("el-radio",{key:l,attrs:{label:e.id}},[t._v(t._s(e.name))])}),1)],1),t._v(" "),a("el-form-item",[a("el-button",{attrs:{type:"primary"},on:{click:t.onSubmit}},[t._v("立即创建")]),t._v(" "),a("el-button",[t._v("取消")])],1)],1)],1)],1)},staticRenderFns:[]};var m=a("VU/8")(o,n,!1,function(t){a("t4iX")},"data-v-3f445700",null);e.default=m.exports},t4iX:function(t,e){}});
//# sourceMappingURL=12.93511b61b8f88ce52cfa.js.map