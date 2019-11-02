
<template>
    <div class="app-container">
        <el-card class="box-card">
            <el-row :gutter="10">
                <!--会话列-->
                <el-col :span="18">
                    <div id="container">
                        <el-row>
                            <!--访客列表-->
                            <el-col :span="6">
                                <list></list>
                            </el-col>

                            <!--聊天记录-->
                            <el-col :span="18">
                                <div class="main">
                                    <message v-if="show"></message>
                                </div>
                            </el-col>

                        </el-row>
                    </div>
                </el-col>
                <!--信息备注列-->
                <el-col :span="6">
                    <visitor v-if="show"></visitor>
                </el-col>
            </el-row>
        </el-card>
    </div>
</template>

<script>
    import List from '../../components/Service/list';
    import Message from '../../components/Service/message';
    import Visitor from '../../components/Service/visitor';

    export default {
        components: { List, Message, Visitor },
        data() {
            return {
                show: false
            }
        },
        watch: {
            '$route'(to, from) {
                this.show = to.query.vid ? true : false;
            }
        },
        created () {
            this.show = this.$route.query.vid ? true : false
        },
        methods: {
            onSubmit() {
                console.log('submit!');
            }
        }
    }
</script>


<style lang="less" scoped>

    #container {
        /*margin: 20px auto;*/
        /*width: 800px;*/
        height: 600px;
        /*overflow: hidden;*/
        border-radius: 3px;

        .main {
            /*position: relative;*/
            /*overflow: hidden;*/
            background-color: #FDFDFD;
        }
    }

</style>

