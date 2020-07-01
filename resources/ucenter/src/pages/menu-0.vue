<template>
    <el-container>
        <div class="el-aside home">
            <div class="small-word home-aside-bg" v-show="!isCollapse">
                <!--<img class="jqb-logo-img" :src="$store.state.info? $store.state.info.logo_icon: ''" alt="">-->
                <span class="jqb-logo-text">{{title}}</span>
            </div>
            <div class="big-word home-aside-bg" v-show="isCollapse">{{title}}</div>
            <div @mouseover="overAside" @mouseout="outAside" class="aside-wrappers">
                <el-menu :default-active="defaultIndex"
                         class="el-menu-vertical-demo aside"
                         @open="handleOpen"
                         @close="handleClose"
                         background-color="#323232"
                         :collapse="isCollapse">
                    <template v-for="(item, index) in meunData">
                        <template v-if="!item.hide">
                            <template v-if="!item.sub || item.sub.map(vo => {if(!vo.hide) {return vo}}).filter(vo=>vo).length < 1">
                                <el-menu-item :index="(item.index).toString()" @click="jump(item.href)" :key="index">
                                    <i class="iconfont" v-html="item.class"></i>
                                    <span slot="title" class="title">{{item.title}}</span>
                                </el-menu-item>
                            </template>
                            <template v-else>
                                <el-submenu :index="(item.index).toString()" :key="index">
                                    <template slot="title">
                                        <i class="iconfont" v-html="item.class"></i>
                                        <span slot="title" class="title">{{item.title}}</span>
                                    </template>
                                    <template v-for="(vo, key) in item.sub">
                                        <el-menu-item :key="key" v-if="!vo.hide" :index="`${item.index}-${vo.index}`" @click="jump(vo.href)">
                                            <i class="iconfont" v-html="vo.class"></i>
                                            {{vo.title}}
                                        </el-menu-item>
                                    </template>
                                </el-submenu>
                            </template>
                        </template>
                    </template>
                </el-menu>
            </div>
        </div>
        <el-container>
            <el-header class="el-my-header display-row-box">
                <div class="header-right-item display-row-box" @click="handleSwitch">
                    <i class="iconfont">&#xe619; </i>
                </div>
                <div class="header-right display-row-box">
                    <el-dropdown>
                        <span class="el-dropdown-link">
                            <i class="iconfont">&#xe61f; </i>
                            <span>{{$store.state.info && $store.state.info.store_name}}</span>
                            <!-- <i class="el-icon-arrow-down el-icon--right"></i> -->
                        </span>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item @click.native="goShopCenter">店铺中心</el-dropdown-item>
                            <el-dropdown-item @click.native="goLogout">退出</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                    <form :action="logoutUrl" method="POST" style="display: none;" name="logoutForm">
                        <input type="hidden" name="_token" value="OXJJiWnFm823gyxr4lDpFwVGHxBCsfTMZr52QEWt">
                    </form>
                </div>
            </el-header>
            <el-main class="main">
                <template v-if="!isOnTheRoad">
                    <keep-alive>
                        <router-view v-if="$route.meta.keepAlive"></router-view>
                    </keep-alive>
                    <router-view v-if="!$route.meta.keepAlive"></router-view>
                </template>
                <online v-else :title="lineTitle"/>
            </el-main>
        </el-container>
    </el-container>
</template>

<script>
  import '@/assets/menu.css';
  import '@/assets/iconfont/iconfont.css';
  import '@/assets/right_layout.less';
  import meunData from '@/assets/data/menu.json';

  const logoutUrl = `${window.location.origin}/logout`

  export default {
    name: 'meun',
    data() {
      return {
        isCollapse: false,
        defaultIndex: '',
        isOnTheRoad: false,
        logoutUrl,
        lineTitle: '系统维护中',
        meunData: [],
        title: '白中商贸',
      }
    },
    updated() {
      this.defaultIndex = this.$route.meta.routerIndex.toString();
    },
    created() {
      this.meunData = meunData;
    },
    methods: {
      overAside() {
        // this.isCollapse = false
      },
      outAside() {
        // this.isCollapse = true
      },
      handleOpen(key, keyPath) {
        console.log(key, keyPath);
      },
      handleClose(key, keyPath) {
        console.log(key, keyPath);
      },
      handleSwitch() {
        this.isCollapse = !this.isCollapse
      },
      jump(path) {
        this.isOnTheRoad = !path
        if (path) {
          this.$router.push(path)
        }
      },
      goShopCenter() {
        window.location.href = `${window.location.origin}/home`
      },
      async goLogout() {
        document.logoutForm.submit()
      },
    },
  }
</script>

<style scoped>
    .header-right {
        cursor: pointer;
    }
</style>
