<template>
    <div>
        <div v-title="'下属管理'"></div>
        <div class="l-block">
            <div class="l-block-header">
                下属管理
            </div>
            <div class="l-block-body">
                <div class="l-employee-wrap">
                    <template v-if="subordinates.length">
                        <transition  v-for="(em, index) in subordinates"  :key="index">
                            <div @mouseover.stop="handleMouseOver(em)" @mouseout.stop="handleMouseOut(em)">
                                <div class="l-employee">
                                    <h1 class="l-title">{{em.real_name}}</h1>
                                    <div style="font-size: 10px;">{{em.user ? em.user.email : ''}}</div>
                                    <div class="l-eval-btn" :class="{hide: typeof em.hover == 'undefined' ? true: false, animate__animated: true, animate__flipInX: em.hover ? true : false}">
                                        <el-button type="text" size="small" @click="competenceEval(em)">胜任力评估</el-button>
                                    </div>
                                </div>
                            </div>
                        </transition>
                    </template>
                    <div v-else style="text-align: center;color: #ccc;width: 100%;">暂无下级</div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import api from "sysApi"
    import 'animate.css'

    export default {
        name: 'sniperEmployeeSubordinate',
        data(){
            return {
                subordinates: []
            }
        },
        methods:{
            competenceEval({position_id, user_id}){
                this.$router.push('/sniper/employee/competence?position_id='+position_id + '&user_id=' + user_id)
            },
            handleMouseOver(sub){
                this.$set(sub, 'hover', true);
            },
            handleMouseOut(sub){
                this.$set(sub, 'hover', undefined);
            },
            async getSubordinate(){
                let res = await api.sniperEmployeeSubordinate();
                this.subordinates = res.data;
            }
        },
        async created(){
            await this.getSubordinate()
        }
    }
</script>

<style scoped lang="less">
    .l-eval-btn{
        font-size: 13px;
        border: 1px solid #409EFF;
        width: 90px;
        text-align: center;
        margin-top: 15px;
    }
    .hide{
        display: block;
    }
    .l-employee-wrap{
        display: flex;
        flex-flow: row wrap;
        justify-content: flex-start;
        .l-employee{
            padding: 10px;
            position: relative;
            box-shadow: #67C23A;
            border:1px solid #eee;
            width: 200px;
            height: 140px;
            margin: 20px 20px 0 0;
            border-radius: 3px;
            cursor: pointer;
            background: #F2F8FE;
            img{
                width: 60px;
                height: 60px;
            }
            &:hover{
                box-shadow: 3px 3px 6px #f1f1f1;
                background: #fcf8e3;
                h1{
                    color: #2d2d2d;
                }
            }
            h1{
                font-size: 14px;
                color: #777;
                padding: 10px 0 0 0;
                font-weight: bold;
            }
        }
    }
</style>