<template>
    <div>
        <!--first row start-->
        <el-row :gutter="10">
            <el-col :span="18">
                <el-row :gutter="10">
                    <el-col :span="6">
                        <el-card class="box-card">
                            <div slot="header" class="clearfix">
                                <span>版本说明</span>
                            </div>
                        </el-card>
                    </el-col>
                    <el-col :span="18">
                        <el-card class="box-card">
                            <div slot="header" class="clearfix">
                                <span>基础数据</span>
                            </div>
                        </el-card>
                    </el-col>
                </el-row>
            </el-col>
            <el-col :span="6">
                <el-card class="box-card">
                    <div slot="header" class="clearfix">
                        <span>快捷方式</span>
                    </div>
                </el-card>
            </el-col>
        </el-row>
        <!--second row start-->
        <el-row :gutter="10" style="margin-top: 10px;">
            <el-col :span="18">
                <el-card class="box-card">
                    <div slot="header" class="clearfix">
                        <span>数据总览</span>
                    </div>
                </el-card>
            </el-col>
            <el-col :span="6">
                <el-card class="box-card">
                    <div slot="header" class="clearfix">
                        <span>最新消息</span>
                    </div>
                </el-card>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        }
    }
</script>
<style scoped>
</style>
