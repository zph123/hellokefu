<template>
    <div class="app-container">
        <el-card class="box-card">
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
        <!--分页-->
        <el-row style="float: right;margin-bottom: 10px;">
            <el-col :span="12">
                <el-pagination
                        background
                        :page-sizes="[1, 15, 20, 30, 40]"
                        layout="total, sizes, prev, pager, next"
                        @size-change="handleSizeChange"
                        @current-change="handleCurrentChange"
                        :page-size="meta.size"
                        :total="meta.total">
                </el-pagination>
            </el-col>
        </el-row>
        </el-card>
    </div>

</template>
<script>
    import { indexVisit } from '../../api/visit'
    export default {
        data() {
            return {
                tableData: [],
                meta: {
                    page: 1,
                    size: 1,
                    total: 0,
                }
            }
        },
        created() {
            this.index()
        },
        methods: {
            handleClick(row) {
                console.log(row);
            },
            index(){
                indexVisit({'size': this.meta.size,'page': this.meta.page}).then(ret => {
                    const { data, meta } = ret
                    this.tableData = data
                    this.meta.total = meta.total
                }).catch(err => {
                    console.log(err)
                })
            },
            handleSizeChange(val) {
                this.meta.size = val;
                this.index()
                console.log(`每页 ${val} 条`);
            },
            handleCurrentChange(val) {
                console.log(`当前页: ${val}`);
                this.meta.page = val;
                this.index()
            }
        }
    }
</script>