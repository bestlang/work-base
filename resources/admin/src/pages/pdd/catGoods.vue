<template>
    <div class="flex-wrap">
        <div class="left-tree" :class="{ active: isActive }">
            <div class="search-wrap">
                <el-input placeholder="请输入内容" v-model="params.keyword" @keyup.native.enter="searchClick" :autofoucs="true">
                </el-input>
                <div class="search-btn" @click="searchClick"><i class="el-icon-search"></i></div>
            </div>
            <el-tree
                    :props="defaultProps"
                    :lazy="true"
                    :load="loadNode"
                    @node-click="handleNodeClick"
            ></el-tree>
        </div>
        <div class="right-content" :class="{ active: isActive }">
            <div @click="toggleActive" class="toggle-active"><i class="el-icon-search"></i></div>
            <div class="goods-list">
                <div class="goods-item" v-for="(t,i) in tableData">
                    <div class="img-wrap">
                        <img :src="t.goods_thumbnail_url"  class="table-img">
                        <div class="hover-title">{{t.goods_name}}</div>
                        <div class="hover-btn">
                            <div><button class="btn" @click="sendTo(t.goods_id, 1)">首页推荐</button></div>
                            <div><button class="btn" @click="sendTo(t.goods_id, 3)">拼团0元购推荐</button></div>
                            <div><button class="btn" @click="sendTo(t.goods_id, 5)">0元购推荐</button></div>
                        </div>
                    </div>
                    <!--<div>{{t.goods_name}}</div>-->
                    <div>券后价: <span class="price">¥{{(t.min_group_price - t.coupon_discount) / 100}}</span> 券: <span class="price">¥{{t.coupon_discount / 100}}</span> </div>
                    <div>佣金比例: <span class="price">{{t.promotion_rate / 10}}%(¥{{((t.min_group_price - t.coupon_discount)*t.promotion_rate / (100*1000)).toFixed(2)}}元)</span></div>
                    <div class="little-flex">
                        <div>销量:{{t.sales_tip}}</div>
                    </div>

                </div>
            </div>
            <div class="l-delimiter"></div>
            <el-pagination
                    background
                    @current-change="handleCurrentChange"
                    :current-page.sync="params.page"
                    :page-size="params.page_size"
                    layout="total, prev, pager, next"
                    :total="total"
                    v-if="tableData.length"
            ></el-pagination>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isActive: true,
                tableData: [],
                params: {
                    page:1,
                    page_size: 50, // 10-100
                    keyword: ''
                },
                total: 99999,
                defaultProps: {
                    children: 'children',
                    label: 'cat_name',
                    isLeaf: 'leaf'
                }
            };
        },
        mounted(){
          let flag = this.$store.getters.isCollapse;
          if(!flag){
              this.$store.dispatch('toggleState');
          }
        },
        methods:{
            sendTo(goods_id, type){
                let that = this;
                this.$http
                    .post("/admin/attach/goods", {goods_id: goods_id, plantform: 1, type: type})
                    .then(res => {
                        console.log(JSON.stringify(res))
                        if(res.data.success == "1"){
                            that.successMessage(`操作成功`);
                        }else{
                            that.errorMessage(res.data.message);
                        }
                    });
            },
            toggleActive(){
                this.isActive = !this.isActive
            },
            searchClick(){
                this.params.page = 1;
                this.handleNodeClick();
            },
            loadNode(node, resolve){
                let that = this;
                let parent_cat_id = 0;
                if(node.data){
                    parent_cat_id = node.data.cat_id;
                }
                this.$http
                    .get("/pdd/goods/cats/get", {params: {parent_cat_id: parent_cat_id}})
                    .then(res => {
                        if(res.code == 200){
                            resolve(res.data);
                        }else{
                            that.errorMessage("出错了");
                        }
                    });
            },
            handleCurrentChange(val) {
                // this.successMessage(`当前页: ${val}`);
                this.params.page = val;
                this.handleNodeClick();
            },
            handleNodeClick(data, node){
                if(data && node && node.level >= 3){
                    this.params.page = 1;
                    this.params.keyword = node.data.cat_name;
                }
                this.$http
                    .get("/pdd/goods/search", {params: this.params})
                    .then(res => {
                        console.log(JSON.stringify(res))
                        if(res.code == 200){
                            this.tableData = res.data
                        }else{
                            this.errorMessage("出错了");
                        }
                    });
            }
        }
    }
</script>

<style scoped lang="less">
    @redColor:#f83e06;
    .goods-list {
        column-count: 5;
        column-width:20%;
        column-gap: 0;
        box-sizing: border-box;
        .goods-item {
            font-size: 14px;
            break-inside: avoid;
            padding: 10px;
            .img-wrap{
                position: relative;
                .hover-btn{display: none;}
                .hover-title{display: none;}
                &:hover{
                    .hover-title{
                        display: block;
                        font-size: 16px;
                        padding: 20px 20px;
                        background: rgba(255,255,255,.9);
                        margin-bottom: 20px;
                        position: absolute;
                        top:0;
                        left:0;
                    }
                    .hover-btn{
                        position: absolute;
                        bottom: 5px;
                        left: 0;
                        display: block;
                        width:100%;
                        .btn{
                            font-size: 16px;
                            padding: 4px 10px;
                            border:none;
                            background: @redColor;
                            color: #fff;
                            cursor: pointer;
                            margin-top: 5px;
                            width: 100%;
                        }
                    }
                 }
            }
            .little-flex{
                display: flex;
                flex-flow: row wrap;
                justify-content: space-between;
            }
        }

    }
    .flex-wrap{
        position: relative;
        .left-tree{
            &.active{
                 width: 240px;
                 display: block;
             }
            display:none;
            overflow:hidden;
            border-right: solid 1px #e6e6e6;
            overflow-y: scroll;
            position: absolute;
            top:0;
            left:0;
            bottom: 0;
            min-height: calc(100vh - 69px);
            .search-btn{
                z-index:9999;
                margin-left:-32px;
                cursor:pointer;
                height: 32px;
                width: 32px;
                color:darkblue;
                text-align: center;
                box-sizing: content-box;
            }
            .search-wrap{
                margin-bottom: 10px;
                margin-right: 10px;
                display: flex;
                line-height: 32px;
            }
        }
        .right-content{
            &.active{
                 margin-left: 240px;
             }
            .toggle-active{
                cursor:pointer;
                position:fixed;
                right:20px;
                bottom:40px;
                width: 40px;
                height: 40px;
                border-radius: 20px;
                background: darkblue;
                color: #fff;
                font-size: 20px;
                line-height: 40px;
                text-align: center;
            }
            margin-left:-20px;
            background: #fff;
            padding-left: 20px;
        }
    }
    img.table-img{
         width: 100%;
         height: 100%;
         border-radius: 3px;
    }
    .price{
        font-weight: 700;
        color:@redColor;
    }
    .price-2{
        font-weight: 700;
        background:@redColor;
        color: #fff;
        padding: 2px 10px;
    }
</style>