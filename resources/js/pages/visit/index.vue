<template>
    <div class="app-container">
        <el-table
                :data="tableData"
                style="width: 100%">
            <el-table-column
                    prop="region"
                    label="地区"
                    width="150">
            </el-table-column>
            <el-table-column
                    prop="ip"
                    label="IP地址"
                    width="120">
            </el-table-column>
            <el-table-column
                    prop="visit_number"
                    label="会话说"
                    width="120">
            </el-table-column>
            <el-table-column
                    prop="company"
                    label="公司"
                    width="120">
            </el-table-column>
            <el-table-column
                    prop="lasted_at"
                    label="最近出现时间"
                    width="300">
            </el-table-column>
            <el-table-column
                    prop="created_at"
                    label="首次出现时间"
                    width="120">
            </el-table-column>
            <el-table-column
                    prop="created_at"
                    label="在线状态"
                    width="120">
            </el-table-column>
            <el-table-column
                    prop="mobile"
                    label="手机"
                    width="120">
            </el-table-column>
            <el-table-column
                    prop="email"
                    label="邮箱"
                    width="120">
            </el-table-column>
            <el-table-column
                    prop="remark"
                    label="备注"
                    width="120">
            </el-table-column>
            <el-table-column
                    label="操作"
                    width="100">
                <template slot-scope="scope">
                    <el-button @click="handleClick(scope.row)" type="text" size="small">查看</el-button>
                    <el-button type="text" size="small">编辑</el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>

</template>
<script>
    export default {
        methods: {
            handleClick(row) {
                console.log(row);
            }
        },

        data() {
            return {
                tableData: [{
                    region: '2016-05-03',
                    ip: '王小虎',
                    visit_number: '上海',
                    company: '普陀区',
                    lasted_at: '上海市普陀区金沙江路 1518 弄',
                    created_at: 200333,
                    mobile:111,
                    email:'itbing@sina.cn',
                    remark:'好人'
                }]
            }
        }
    }
</script>