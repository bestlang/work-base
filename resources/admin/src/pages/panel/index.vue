<template>
    <div>
        <div v-title="'主界面'"></div>
        <div class="l-app-wrap">
            <div class="l-app" @click="jump('/panel/attendance')">
                <div class="l-icon-wrap">
                    <svg class="l-app-icon" aria-hidden="true">
                        <use xlink:href="#iconkaoqin"></use>
                    </svg>
                </div>
                <div class="l-app-title">考勤</div>
            </div>
            <div class="l-app" @click="jump('/panel/notice')">
                <div class="l-icon-wrap">
                    <svg class="l-app-icon" aria-hidden="true">
                        <use xlink:href="#icongonggao"></use>
                    </svg>
                </div>
                <div class="l-app-title">公告</div>
            </div>
            <div class="l-app" @click="jump('/panel/download')">
                <div class="l-icon-wrap">
                    <svg class="l-app-icon" aria-hidden="true">
                        <use xlink:href="#iconfile2"></use>
                    </svg>
                </div>
                <div class="l-app-title">文件下载</div>
            </div>
            <div class="l-app">
                <div class="l-icon-wrap">
                    <svg class="l-app-icon" aria-hidden="true">
                        <use xlink:href="#iconwodetongshiyong"></use>
                    </svg>
                </div>
                <div class="l-app-title">同事</div>
            </div>
            <div class="l-app">
                <div class="l-icon-wrap">
                    <svg class="l-app-icon" aria-hidden="true">
                        <use xlink:href="#icongupiao1"></use>
                    </svg>
                </div>
                <div class="l-app-title">期权</div>
            </div>
            <div class="l-app">
                <div class="l-icon-wrap">
                    <svg class="l-app-icon" aria-hidden="true">
                        <use xlink:href="#icon7liuchengtiaodumoban"></use>
                    </svg>
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
    .l-app-wrap{
        margin-top: 20px;
        display: flex;
        flex-flow: row wrap;
        justify-content: flex-start;
        .l-icon-wrap{
            text-align: center;
            font-size: 12px;
            .l-app-icon{
                margin-top: 10px;
                width: 50px;
                height: 50px;
            }
        }

    }
    .l-app{
        width: 80px;
        cursor: pointer;
        margin-right: 20px;
    }
    .l-app-icon:hover{
        background-size: 82%;
    }
    .l-app-title{
        text-align: center;
        margin: 5px 0 10px;
    }
</style>