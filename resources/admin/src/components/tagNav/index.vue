<template>
    <div class="tag-nav">
        <scroll-bar ref="scrollBar">
            <router-link ref="tag" class="tag-nav-li" :class="{'cur':isActive(item)}" v-for="(item, index) in tagNavList"
                         :to="item.fullPath" :key="index">
                {{item.title}}
                <span style="line-height: 0;font-size: 8px;color:#ccc;" class='el-icon-close' @click.prevent.stop="closeTheTag(item, index)" v-if="item.fullPath!==defaultPage"></span>
            </router-link>
        </scroll-bar>
    </div>
</template>

<script>
    import scrollBar from './scrollBar'

    export default {
        data(){
            return {
                defaultPage: '/'
            }
        },
        computed: {
            tagNavList(){
                return this.$store.state.tagNav.openedPageList
            }
        },
        mounted(){
            // 首次加载时将默认页面加入缓存
            this.addTagNav()
        },
        watch: {
            $route(){
                this.addTagNav()
                this.scrollToCurTag()
            }
        },
        methods: {
            addTagNav(){
                let mcs = this.$router.getMatchedComponents()
                let path = this.$route.path
                let fullPath = this.$route.fullPath
                    // ["name","meta","path","hash","query","params","fullPath","matched"]
                // 如果需要缓存则必须使用组件自身的name，而不是router的name
                this.$store.commit("tagNav/addTagNav", {
                    name: mcs[mcs.length-1].name,
                    path: path,
                    fullPath: fullPath,
                    title: this.$route.meta.name
                })
            },
            isActive(item){
                return item.path === this.$route.path
            },
            closeTheTag(item, index){
                // 当关闭当前页面的Tag时，则自动加载前一个Tag所属的页面
                // 如果没有前一个Tag，则加载默认页面
                this.$store.commit("tagNav/removeTagNav", item)
                if(this.$route.path == item.path){
                    if(index){
                            this.$router.push(this.tagNavList[index - 1].path)
                    } else {
                        this.$router.push(this.defaultPage)
                        if(this.$route.path == "/home"){
                            this.addTagNav()
                        }
                    }
                }
            },
            scrollToCurTag(){
                this.$nextTick(() =>{
                    for (let item of this.$refs.tag) {
                        if (item.to === this.$route.path) {
                            this.$refs.scrollBar.scrollToCurTag(item.$el)
                            break
                        }
                    }
                })
            }
        },
        components: {scrollBar}
    }
</script>
<style lang="less" scoped>
    .tag-nav-li{
        font-size: 15px;
        height: 40px;
        line-height: 40px;
        display: inline-block;
        padding: 0 10px;
        box-sizing: border-box;
        /*margin-right: 5px;*/
        font-weight: normal;
        background: transparent;
        color: #888;
        /*+.tag-nav-li{*/
            /*border-left: none;*/
        /*}*/
        &:hover{
            text-decoration: none;
            background: #fff;
         }
        &.cur{
            background: #fff;
            border-top: 1px solid #E4E7ED;
            border-left: 1px solid #E4E7ED;
            border-right: 1px solid #E4E7ED;
            box-shadow: 0 20px 20px #f9f9f9 inset;
        }
    }

    .tag-nav{
        width: 100%;
        height: 40px;
        line-height: 40px;
    }
</style>