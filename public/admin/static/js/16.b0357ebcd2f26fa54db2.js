webpackJsonp([16],{XRHL:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i={name:"ueditor",data:function(){return{ueditor:null,dynamicId:"ueditor_id_"+Math.floor(123456*Math.random())}},props:{defaultContent:{type:String},config:{type:Object}},mounted:function(){var t=this;this.$nextTick(function(){t.ueditor=window.UE.getEditor(t.dynamicId,t.config),t.ueditor.ready(function(){t.$emit("ready",t.ueditor,0),t.ueditor.setContent(t.defaultContent)})})},methods:{getUEContent:function(){return this.ueditor.getContent()}},destroyed:function(){this.ueditor.destroy()}},r={render:function(){var t=this.$createElement,e=this._self._c||t;return e("div",{attrs:{id:"ueditor-wrap"}},[e("script",{staticStyle:{width:"1024px",height:"500px"},attrs:{id:this.dynamicId,type:"text/plain"}})])},staticRenderFns:[]},o={data:function(){return{content:"这是我设置的默认文本...",config:{initialFrameWidth:1038,initialFrameHeight:350,ZeroClipboard:!1},ueArray:[]}},components:{ueditor:n("VU/8")(i,r,!1,null,null,null).exports},methods:{setUeditor:function(t,e){this.ueArray[e]=t},getContent:function(){alert(this.ueArray[0].getContent())}}},d={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("p",[t._v("welcome,dashboard.")]),t._v(" "),n("ueditor",{attrs:{config:t.config,"default-content":t.content},on:{ready:t.setUeditor}}),t._v(" "),n("el-button",{on:{click:t.getContent}},[t._v("获取内容")])],1)},staticRenderFns:[]},u=n("VU/8")(o,d,!1,null,null,null);e.default=u.exports}});
//# sourceMappingURL=16.b0357ebcd2f26fa54db2.js.map