<template>
    <div class="app-container">

            <h2>conversation</h2>
            <input type="text" v-model="message">
            <button @click="send">发送1</button>
        <el-row :gutter="20">
            <el-col :span="8">
                <div class="grid-content bg-purple">
                    <ul class="infinite-list" v-infinite-scroll="load" style="overflow:auto;height:300px">
                        <el-menu
                                default-active="2"
                                class="el-menu-vertical-demo"
                                @select="openTalk"
                                @close="">
                            <el-menu-item v-for="(item, index) in conversationList" :index="item.id+''">
                                <i class="el-icon-menu"></i>
                                <span slot="title">{{item.id}}</span>
                                <span slot="title"></span>
                            </el-menu-item>

                        </el-menu>
                    </ul>
                </div>
            </el-col>
            <el-col :span="8">
                <div class="grid-content bg-purple">
                    <ul>
                        <li v-for="item in messageList">
                            {{ item.content }}
                        </li>
                    </ul>
                </div>
            </el-col>
            <el-col :span="8">
                <div class="grid-content bg-purple">
                </div>
            </el-col>

        </el-row>
    </div>
</template>

<script>
    import Websocket from '../../utils/websocket.js'
    import { indexVisit } from '../../api/visit'
    export default {
        data() {
            return {
                // count: 0,
                message: 'ceshi',
                meta: {
                    lasted_at:'desc',
                    size: 100,
                },
                messageList: [
                    {content: 'Runoob'},
                    {content: 'Google'},
                    {content: 'Taobao'}
                ],
                conversationList:[]
            }
        },
        mounted() {
            //获取app_id
            //this.getConversation()
        },
        methods: {
            load () {
                // this.count += 15
                this.getConversation()
            },
            openTalk(index){
              console.log(index)
            },
            send() {
            },
            getConversation() {
                indexVisit({'size': this.meta.size,'lasted_at': this.meta.lasted_at}).then(ret => {
                    const { data, meta } = ret
                    console.log(data)
                    this.conversationList=this.conversationList.concat(data)
                    console.log(this.conversationList)
                    // this.meta.total = meta.total
                }).catch(err => {
                    console.log(err)
                })
            }
        }

    }
</script>
<style scoped>
    .el-row {
        margin-bottom: 20px;
        &:last-child {
         margin-bottom: 0;
        }
    }
    .el-col {
        border-radius: 4px;
    }
    .bg-purple-dark {
        background: #99a9bf;
    }
    .bg-purple {
        background: #d3dce6;
    }
    .bg-purple-light {
        background: #e5e9f2;
    }
    .grid-content {
        border-radius: 4px;
        min-height: 36px;
    }
    .row-bg {
        padding: 10px 0;
        background-color: #f9fafc;
    }
</style>