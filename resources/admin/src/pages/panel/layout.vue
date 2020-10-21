<template>
    <div>
        <el-menu router :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect">
            <el-menu-item index="/panel">主界面</el-menu-item>
            <el-menu-item index="/panel/attendance">我的考勤</el-menu-item>
            <el-menu-item style="float: right">
                <el-dropdown>
                    <div class="logout"><i class="iconfont">&#xe60d; </i>{{user.name}}</div>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item><div @click="logout"><i class="iconfont">&#xe84b; </i>登出</div></el-dropdown-item>
                        <el-dropdown-item><i class="iconfont">&#xe618; </i>修改密码</el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
            </el-menu-item>
        </el-menu>
        <div style="border-top: 10px solid #f1f1f1;padding: 10px;height: calc(100vh - 61px)">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    import api from '../../api/index'
    import { getPrefix } from '../../api/util'
    import {mapGetters} from 'vuex'
    import Cookies from 'js-cookie'

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
                if(!this.user || !this.user.length){
                    await this.$store.dispatch(this.$types.user)
                }
                if(!this.csrf){
                    await this.$store.dispatch(this.$types.csrf)
                }
                // if(!Cookies.get(this.$types.logined)){
                //     Cookies.set(this.$types.logined, true, new Date(new Date().getTime() + 10 * 60 * 1000))
                // }
            }
        }
    }
</script>