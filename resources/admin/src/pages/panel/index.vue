<template>
    <div>
        <div v-title="'主界面'"></div>
        <div class="l-app-wrap">
            <div class="l-app" @click="jump('/panel/attendance')">
                <div class="l-icon-wrap">
                    <div class="l-app-icon l-attendance"></div>
                    <!--<svg class="l-app-icon" aria-hidden="true">-->
                        <!--<use xlink:href="#iconkaoqin"></use>-->
                    <!--</svg>-->
                </div>
                <div class="l-app-title">考勤</div>
            </div>
            <div class="l-app" @click="jump('/panel/notice')">
                <div class="l-icon-wrap">
                    <div class="l-app-icon l-notice"></div>
                    <!--<svg class="l-app-icon" aria-hidden="true">-->
                        <!--<use xlink:href="#icongonggao"></use>-->
                    <!--</svg>-->
                </div>
                <div class="l-app-title">公告</div>
            </div>
            <div class="l-app" @click="jump('/panel/download')">
                <div class="l-icon-wrap">
                    <div class="l-app-icon l-file"></div>
                    <!--<svg class="l-app-icon" aria-hidden="true">-->
                        <!--<use xlink:href="#iconfile2"></use>-->
                    <!--</svg>-->
                </div>
                <div class="l-app-title">文件下载</div>
            </div>
            <div class="l-app">
                <div class="l-icon-wrap">
                    <div class="l-app-icon l-org"></div>
                    <!--<svg class="l-app-icon" aria-hidden="true">-->
                        <!--<use xlink:href="#iconzuzhijiagou"></use>-->
                    <!--</svg>-->
                </div>
                <div class="l-app-title">组织架构</div>
            </div>
            <div class="l-app">
                <div class="l-icon-wrap">
                    <div class="l-app-icon l-fellow"></div>
                    <!--<svg class="l-app-icon" aria-hidden="true">-->
                        <!--<use xlink:href="#iconwodetongshiyong"></use>-->
                    <!--</svg>-->
                </div>
                <div class="l-app-title">同事</div>
            </div>
            <div class="l-app">
                <div class="l-icon-wrap">
                    <div class="l-app-icon l-stock"></div>
                    <!--<svg class="l-app-icon" aria-hidden="true">-->
                        <!--<use xlink:href="#icongupiao1"></use>-->
                    <!--</svg>-->
                </div>
                <div class="l-app-title">期权</div>
            </div>
            <div class="l-app">
                <div class="l-icon-wrap">
                    <div class="l-app-icon l-plm"></div>
                    <!--<svg class="l-app-icon" aria-hidden="true">-->
                        <!--<use xlink:href="#icon7liuchengtiaodumoban"></use>-->
                    <!--</svg>-->
                </div>
                <div class="l-app-title">PLM</div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        methods:{
            jump(path){
                this.$router.push(path)
            }
        },
        mounted(){
        }
    }
</script>
<style lang="less">
    .l-attendance{
        background: url('../../assets/icons/attendance.png') no-repeat scroll center / cover;
    }
    .l-notice{
        background: url('../../assets/icons/notice.png') no-repeat scroll center / cover;
    }
    .l-file{
        background: url('../../assets/icons/file.png') no-repeat scroll center / cover;
    }
    .l-org{
        background: url('../../assets/icons/org.png') no-repeat scroll center / cover;
    }
    .l-fellow{
        background: url('../../assets/icons/fellow.png') no-repeat scroll center / cover;
    }
    .l-stock{
        background: url('../../assets/icons/stock.png') no-repeat scroll center / cover;
    }
    .l-plm{
        background: url('../../assets/icons/plm.png') no-repeat scroll center / cover;
    }
    .l-app-wrap{
        margin-top: 20px;
        display: flex;
        flex-flow: row wrap;
        justify-content: flex-start;
        .l-icon-wrap{
            text-align: center;
            font-size: 12px;
            .l-app-icon{
                border-radius: 20px;
                margin: 10px auto 0;
                width: 60px;
                height: 60px;
            }
        }
    }
    .l-app{
        width: 80px;
        cursor: pointer;
        margin-right: 20px;
        border-radius: 10px;
        /*&:hover{*/
            /*background: #fff;*/
        /*}*/
    }
    .l-app-icon:hover{
        background-size: 120%;
        transition: all 5s;
    }
    .l-app-title{
        font-size: 14px;
        color: #5a5e66;
        text-align: center;
        margin: 5px 0 10px;
    }
</style>