<template>
    <div class="tag-nav">
        <scroll-bar ref="scrollBar">
            <router-link ref="tag" class="tag-nav-li" :class="{'cur':isActive(item)}" v-for="(item, index) in tagNavList"
                         :to="item.fullPath" :key="index">
                {{item.title}}
                <span style="line-height: 0" class='el-icon-close' @click.prevent.stop="closeTheTag(item, index)"></span>
            </router-link>
        </scroll-bar>
    </div>
</template>

<script>
    import scrollBar from './scrollBar'

    export default {
        data(){
            return {
                defaultPage: '/dashboard'
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
                //对'/'特殊处理
                if(path == '/'){
                    path = this.defaultPage
                    fullPath = this.defaultPage
                }
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
        height: 30px;
        line-height: 30px;
        display: inline-block;
        padding: 0 8px;
        border: 1px solid #eee;
        box-sizing: border-box;
        margin-right: 5px;
        font-weight: lighter;
        &:hover{
            text-decoration: none;
         }
    }
    .cur{
        background: #293c55;
        color: #F0F0EE;
    }
    .tag-nav{
        width: 100%;
        height: 50px;
    }
</style>