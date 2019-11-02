<template>
    <div class="visitor-info">
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span>基本信息</span>
            </div>
            <el-form ref="form" :model="form" label-width="80px">
                <el-form-item label="姓名">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="手机">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="公司">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="微信">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="备注">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                form: {
                    name: ''
                }
            }
        },
    }
</script>

<style lang="scss" scoped>
    .visitor-info{}
    
</style>