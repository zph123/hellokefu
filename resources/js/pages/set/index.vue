<template>
    <div class="app-container">
        <el-card class="box-card">
            <!--第一行-->
            <el-card class="box-card">
                <div slot="header" class="clearfix">
                    <span>部署</span>
                </div>
                <el-row :gutter="12">
                    <el-col :span="8">
                        <div>
                            <el-avatar src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"></el-avatar>
                            网页插件
                        </div>
                    </el-col>
                    <el-col :span="8">
                        <div>
                            <el-avatar src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"></el-avatar>
                            聊天链接
                        </div>
                    </el-col>
                </el-row>
            </el-card>
            <!--第二行-->
            <el-card class="box-card" style="margin-top: 10px;">
                <div slot="header" class="clearfix">
                    <span>会话管理</span>
                </div>
                <el-row :gutter="12">
                    <el-col :span="8">
                        <div>
                            <el-avatar src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"></el-avatar>
                            坐席设置
                        </div>
                    </el-col>
                    <el-col :span="8">
                        <div>
                            <el-avatar src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"></el-avatar>
                            通知设置
                        </div>
                    </el-col>
                    <el-col :span="8">
                        <div>
                            <el-avatar src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"></el-avatar>
                            所有访客
                        </div>
                    </el-col>
                </el-row>
            </el-card>
            <!--第三行-->
            <el-card class="box-card" style="margin-top: 10px;">
                <div slot="header" class="clearfix">
                    <span>报表</span>
                </div>
                <el-row :gutter="12">
                    <el-col :span="8">
                        <div>
                            <el-avatar src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"></el-avatar>
                            访客报表
                        </div>
                    </el-col>
                    <el-col :span="8">
                        <div>
                            <el-avatar src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"></el-avatar>
                            坐席报表
                        </div>
                    </el-col>
                </el-row>
            </el-card>

        </el-card>
    </div>
</template>

<style scoped>

</style>

