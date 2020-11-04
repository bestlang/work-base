<template>
    <div>
        <el-menu router :default-active="activeIndex" class="ls-el-menu" mode="horizontal" @select="handleSelect">
            <el-menu-item index="/panel"><i class="iconfont" style="font-size: 30px">&#xe60e;</i></el-menu-item>
            <!--<el-menu-item index="/panel/attendance">我的考勤</el-menu-item>-->
            <!--<el-menu-item index="/panel/notice">人事公告</el-menu-item>-->
            <el-menu-item style="float: right">
                <el-dropdown @command="commandHandler">
                    <div class="logout"><i class="iconfont">&#xe60d; </i>{{user.name}}</div>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item command="logout"><div><i class="iconfont">&#xe84b; </i>登出</div></el-dropdown-item>
                        <el-dropdown-item v-if="user.type" command="admin"><i class="iconfont">&#xe60a;</i> 管理后台</el-dropdown-item>
                        <el-dropdown-item command="modifyPassword"><i class="iconfont">&#xe618; </i>修改密码</el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
            </el-menu-item>
        </el-menu>
        <div style="padding: 10px;height: calc(100vh - 61px)">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    import api from '../../api/index'
    import { getPrefix } from '../../api/util'
    import {mapGetters} from 'vuex'

    export default {
        computed: {
            ...mapGetters(['user','privileges', 'accessToken', 'csrf'])
        },
        data() {
            return {
                activeIndex: '/panel'
            };
        },
        methods: {
            async commandHandler(command){
                if(command == 'logout'){
                    await this.logout()
                }else if(command == 'admin'){
                    this.$router.push('/')
                }else if(command == 'modifyPassword'){
                    this.$message('还没做')
                }
            },
            handleSelect(key, keyPath) {
                console.log(key, keyPath);
            },
            async logout(){
                await this.$store.dispatch('logout')
            }
        },
        watch:{
            accessToken:{
                handler(newVal){
                    if(!newVal){
                        if(getPrefix() == 'api'){
                            this.$router.push('/login')
                        }else{
                            location.href='/login'
                        }
                    }
                }
            }
        },
        async created(){
            if(getPrefix() == 'ajax'){
                //做api方式登录成功后做的操作
                if(!this.user || !Object.keys(this.user).length){
                    await this.$store.dispatch(this.$types.user)
                }
                if(!this.csrf){
                    await this.$store.dispatch(this.$types.csrf)
                }
            }
        }
    }
</script>
<style lang="less">
    .ls-el-menu{
        background-color: #222;
        .el-menu-item{
            height: 50px;
            line-height: 50px;
            &.is-active{
                color: #fff;
            }
        }
    }
</style>