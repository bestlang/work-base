<template>
    <div>
        <div v-title="'主界面'"></div>
        <div class="l-app-wrap">
            <div class="l-app" @click="jump('/panel/attendance')">
                <div class="l-app-icon l-attendance"></div>
                <div class="l-app-title">考勤</div>
            </div>
            <div class="l-app">
                <div class="l-app-icon l-fellow"></div>
                <div class="l-app-title">同事</div>
            </div>
            <div class="l-app">
                <div class="l-app-icon l-stock"></div>
                <div class="l-app-title">期权</div>
            </div>
            <div class="l-app">
                <div class="l-app-icon l-flow"></div>
                <div class="l-app-title">产品生命周期</div>
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
<style>
    .l-app-wrap{
        margin-top: 20px;
        display: flex;
        flex-flow: row wrap;
        justify-content: flex-start;
    }
    .l-app{
        width: 100px;height: 100px;
        cursor: pointer;
    }
    .l-app-wrap .l-app-icon{
        width: 80px;
        height: 80px;
        border: 1px solid #ccc;
        border-radius: 10px;
        margin-right: 20px;
        margin-bottom: 20px;
        margin: 0 auto;
    }
    .l-app-icon:hover{
        background-size: 82%;
    }
    .l-app-title{
        text-align: center;
        margin: 5px 0 10px;
    }
    .l-attendance{
        background: url("/vendor/sniper/images/attendance.png") no-repeat scroll center / 80%;
    }
    .l-stock{
        background: url("/vendor/sniper/images/stock.png") no-repeat scroll center / 80%;
    }
    .l-flow{
        background: url("/vendor/sniper/images/flow.png") no-repeat scroll center / 80%;
    }
    .l-fellow{
        background: url("/vendor/sniper/images/fellow.png") no-repeat scroll center / 80%;
    }
</style>