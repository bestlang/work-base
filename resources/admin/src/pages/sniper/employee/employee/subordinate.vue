<template>
    <div>
        <div v-title="'下级管理'"></div>
        <div>
            下级管理
        </div>
    </div>
</template>

<script>
    import api from "sysApi"

    export default {
        name: 'sniperEmployeeSubordinate',
        methods:{
            async getSubordinate(){
                let res = await api.sniperEmployeeSubordinate()
                alert(JSON.stringify(res))
            }
        },
        async created(){
            await this.getSubordinate()
        }
    }
</script>

<style scoped>

</style>