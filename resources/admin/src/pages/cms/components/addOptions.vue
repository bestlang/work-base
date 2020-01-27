<template>
  <el-form>
    <el-form-item v-for="(option, idx) in options" :key="idx">
      <el-row style="margin-bottom: 10px;">
        <el-col :span="6" style="margin-right: 5px;"><el-input placeholder="选项名" v-model="option.name"></el-input></el-col>
        <el-col :span="4"><el-input placeholder="选项值" v-model="option.value"></el-input></el-col>
        <el-button class="l-plus-minus" v-if="idx == 0" type="primary" size="small" icon="el-icon-plus" circle @click="plus"></el-button>
        <el-button class="l-plus-minus" v-if="idx != 0" type="primary" size="small" icon="el-icon-minus" circle @click="minus(idx)"></el-button>
      </el-row>
    </el-form-item>
  </el-form>
</template>
<script>
  export default {
    props:{
      options:{
        type: Array,
        default:function(){
          return [{name: '', value: ''}]
        }
      }
    },
    data(){
      return {}
    },
    methods:{
      plus(){
        this.options.push({name: '', value: ''})
      },
      minus(idx){
        this.options.splice(idx, 1);
      }
    },
    watch: {
      'options': {
        deep: true,
        handler(val){
          this.$emit('optionsChange', val)
        }
      }
    },
    // created() {
    //   if(this.initOptions.length>0){
    //     this.options = this.initOptions
    //   }else{
    //     this.options = [{name: '', value:''}]
    //   }
    // }
  }
</script>
<style lang="less" scoped>
  .l-plus-minus{margin-left: 5px;}
</style>
