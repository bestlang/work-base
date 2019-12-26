<template>
    <div class="ls-container">
        <div class="ls-aside">
            <div class="ls-left">
                <backend-menu></backend-menu>
            </div>
        </div>
        <!--命名视图-->

        <div class="ls-content">
            <div class="ls-top">
                <backend-top></backend-top>
            </div>
            <!--<div class="ls-left">-->
                <!--<backend-menu></backend-menu>-->
            <!--</div>-->
            <!--:class="{'ls-main-collapse': isCollapse}"-->
            <div class="ls-main">
                <div style="box-sizing: border-box;background: #fff;padding: 20px;box-sizing: border-box;">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import top from "@/components/partials/top.vue"
import menu from "@/components/partials/menu.vue"

export default {
    components: {
        "backend-top": top,
        "backend-menu": menu
    },
    computed: {
        isCollapse() {return this.$store.state.system.isCollapse}
    },
    mounted(){
        this.$store.dispatch(this.$types.ACTIVITY_TYPES)
        this.$store.dispatch(this.$types.ACTIVITY_APPLICABLES)
    }
}
</script>
<style scoped lang="less">
    .ls-container{
        margin: 0;
        display: flex;
        flex-flow: row nowrap;
    }
    .ls-aside{
        flex-shrink: 0;
        border-right: 1px solid #e6e6e6;
    }
    .ls-top{
        height: 49px;
        background: #fff;
        width: 100%;
        border-bottom:1px solid #e0e4e9;
        z-index: 2;
    }
    .ls-content{
        width: 100%;
        flex-basis: auto;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    .ls-left{
        text-align: left;
        position: relative;
    }

    .ls-main{
        background: #f4f4f4;
        overflow-y: scroll;
        height: calc(100vh - 49px);
        padding: 20px;
    }
    /*.ls-main-collapse{*/
        /*width: 100%;*/
        /*left: 0;*/
    /*}*/
</style>
