<template>
	<div>
        <div v-title="'部门管理'"></div>
        <div class="l-block">
            <div class="l-block-header">
                <div class="l-flex">
                    <span>员工系统 / 部门管理</span>
                    <el-button type="primary" plain>主要按钮</el-button>
                </div>
            </div>
            <div class="l-block-body">
                <div class="l-department-wrap">
                    <div class="l-department">
                        <h1 class="l-title">技术研发部</h1>
                        <article class="l-employee-count"><b>2</b> 人</article>
                    </div>
                    <div class="l-department">
                        <h1 class="l-title">技术研发部</h1>
                        <article class="l-employee-count"><b>2</b> 人</article>
                    </div>
                    <div class="l-department">
                        <h1 class="l-title">技术研发部</h1>
                        <article class="l-employee-count"><b>2</b> 人</article>
                    </div>
                    <div class="l-department">
                        <h1 class="l-title">技术研发部</h1>
                        <article class="l-employee-count"><b>2</b> 人</article>
                    </div>
                    <div class="l-department">
                        <h1 class="l-title">技术研发部</h1>
                        <article class="l-employee-count"><b>2</b> 人</article>
                    </div>
                    <div class="l-department">
                        <h1 class="l-title">技术研发部</h1>
                        <article class="l-employee-count"><b>2</b> 人</article>
                    </div>
                    <div class="l-department">
                        <h1 class="l-title">技术研发部</h1>
                        <article class="l-employee-count"><b>2</b> 人</article>
                    </div>
                    <div class="l-department">
                        <h1 class="l-title">技术研发部</h1>
                        <article class="l-employee-count"><b>2</b> 人</article>
                    </div>
                    <div class="l-department">
                        <h1 class="l-title">技术研发部</h1>
                        <article class="l-employee-count"><b>2</b> 人</article>
                    </div>
                    <div class="l-department">
                        <h1 class="l-title">技术研发部</h1>
                        <article class="l-employee-count"><b>2</b> 人</article>
                    </div>
                </div>
            </div>
        </div>
	</div>
</template>
<script>
	export default {

	}
</script>
<style scoped lang="less">
    .l-department-wrap{
        display: flex;
        flex-flow: row wrap;
        justify-content: flex-start;
        .l-department{
            position: relative;
            box-shadow: #67C23A;
            height: 140px;
            border:1px solid #f1f1f1;
            width: 220px;
            margin: 20px 30px 0 0;
            border-radius: 2px;
            cursor: pointer;
            &:hover{
                box-shadow: 3px 3px 6px #f1f1f1;
                h1{
                    color: #2d2d2d;
                }
            }
            h1{
                font-size: 16px;
                color: #777;
                padding: 10px 0 0 10px;
                font-weight: bold;
            }
            .l-employee-count{
                position: absolute;
                bottom: 10px;
                left: 10px;
                font-size: 14px;
            }
        }
    }
</style>