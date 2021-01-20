<template>
    <div>
        <div v-title="'胜任力评估'"></div>
        <div class="l-block">
            <div class="l-block-header">
                <div class="l-flex">
                    <div>
                        <span class="l-go-back" @click="goBack"><span class="iconfont">&#xe601;</span>返回</span>
                        <el-divider direction="vertical"></el-divider>
                        <span>{{name}}:{{employee.user && employee.user.name}}:胜任力评估</span>
                    </div>
                    <div><el-button type="primary" size="small" @click="saveScore">保存</el-button></div>
                </div>
            </div>
            <div class="l-block-body">
                <el-card class="box-card" v-for="category in ability_categories" style="margin-bottom: 20px;">
                    <div slot="header" class="clearfix">
                        <div class="l-flex">
                            <div style="line-height: 32px;">{{category.name}}</div>
                        </div>
                    </div>
                    <el-table
                            :data="category.abilities"
                            border
                            style="width: 100%">
                        <el-table-column
                                prop="name"
                                label="能力名"
                                width="180">
                        </el-table-column>
                        <el-table-column
                                prop="detail"
                                label="能力详情">
                        </el-table-column>
                        <el-table-column
                                prop="totalScore"
                                label="能力分值">
                        </el-table-column>
                        <el-table-column
                                prop="okScore"
                                label="达标分值">
                        </el-table-column>
                        <el-table-column
                                width="180"
                                label="得分">
                            <template slot-scope="scope">
                                <el-input v-model="abilities[`category_${category.id}_ability_${scope.row.id}`]"></el-input>
                            </template>
                        </el-table-column>
                    </el-table>
                </el-card>
            </div>
        </div>
    </div>
</template>

<style scoped lang="less">

</style>

<script>
    import api from 'sysApi'

    export  default {
        data(){
            return {
                name: '',
                position_id: 0,
                user_id: 0,
                ability_categories: [],
                employee:{},
                abilities: {}
            }
        },
        watch:{
            position_id: {
                handler: async function(nVal){
                    await this.getCompetenceDetail(nVal)
                }
            },
            user_id: {
                handler: async function(nVal){
                    await this.getEmployeeDetail(nVal)
                }
            }
        },
        methods:{
            goBack(){
                    this.$store.dispatch("tagNav/removeCurrentTagNav", this.$route.path)
                    this.$router.push('/sniper/employee/employee/subordinate')
            },
            async getEmployeeScore({user_id, position_id} ){
                let res = await api.sniperCompetenceEmployeeScore({user_id, position_id})
                return res.data;
            },
            async saveScore(){
                const {position_id, user_id, abilities} = this;
                let res = await api.sniperCompetenceEmployee({position_id, user_id, abilities})
                if(res.hasError){
                    this.$message.error(res.error);
                }else{
                    this.$message.success('评估成功！');
                }
            },
            async getEmployeeDetail(id){
                let res = await api.sniperGetEmployeeDetail({id});
                this.employee = res.data
            },
            async getCompetenceDetail(position_id){
                let params = {position_id};
                let res = await api.sniperPositionCompetence(params);
                const {ability_categories, name, department_id} = res.data;
                this.ability_categories = ability_categories;
                this.name = name;
                const {user_id} = this;
                let scores = await this.getEmployeeScore({user_id, position_id});
                const scoreMaps = [];
                for(let i=0; i< scores.length; i++){
                    scoreMaps[`${scores[i].ability_category_id}_${scores[i].ability_id}`] = scores[i].score;
                }
                ability_categories.forEach((category) => {
                    category.abilities.forEach((ability) => {
                        this.$set(this.abilities, `category_${category.id}_ability_${ability.id}`, scoreMaps[`${category.id}_${ability.id}`]);
                    });
                });
                console.log(JSON.stringify(this.abilities))

            },
        },
        async mounted(){
            const position_id = parseInt(this.$route.query.position_id) || 0;
            const user_id = parseInt(this.$route.query.user_id) || 0;
            this.position_id = position_id;
            this.user_id = user_id;
        }
    }
</script>