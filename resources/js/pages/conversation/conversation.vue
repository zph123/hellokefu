<template>
    <div class="app-container">
        <el-row :gutter="20">
            <el-col :span="8">
                <div class="grid-content bg-purple">
                    <ul class="infinite-list" v-infinite-scroll="load" infinite-scroll-disabled="disabled"
                        style="overflow:auto;height:300px">
                        <el-menu
                                default-active="2"
                                class="el-menu-vertical-demo"
                                @select="openChat"
                                @close="">
                            <el-menu-item  style="height: auto;line-height:35px" v-for="item in conversationList"
                                          :index="item.visitor_id+','+item.id">
                                <el-row style="margin-bottom:0px" type="flex" align="middle">
                                    <el-col :span="5">
<!--                                        <i class="el-icon-menu"></i>-->
                                        <el-avatar :size="60"> 访客 </el-avatar>
                                    </el-col>
                                    <el-col :span="8">
                                        <div>

                                            <span slot="title">
                                                访客{{item.id}}
                                            </span>
                                            <div>
                                                <span slot="title">zph:</span><span slot="title">今天中午去哪吃饭</span>
                                            </div>

                                        </div>

                                    </el-col>
                                    <el-col :span="8">
                                        <div>
                                            <span slot="title">{{item.created_at}}</span>
                                        </div>

                                    </el-col>

                                </el-row>


                            </el-menu-item>

                        </el-menu>
                    </ul>
                </div>
            </el-col>
            <el-col :span="16">
                <el-row>
                    <el-col :span="24">
                        <div style="text-align:center;background-color:#ecf5ff">
                            <el-tag>访客{{visitor.id}}</el-tag>
                        </div>
                        <div class="grid-content bg-purple" style="overflow:auto;height:300px" ref="myScrollbar">

                            <el-card class="box-card">
                                <div v-for="item in messageList" class="text item">
                                    <div v-bind:class="item.agent">
                                        {{ item.content }}
                                    </div>
                                    <!--                            <div v-if="item.agent=='user'" class="">-->
                                    <!--                                <img src="https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif?imageView2/1/w/80/h/80" style="height:30px;">:{{ item.content }}-->
                                    <!--                            </div>-->
                                    <!--                            <div v-else class="">-->
                                    <!--                                {{ item.content }}:<img src="https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif?imageView2/1/w/80/h/80" style="height:30px;">-->
                                    <!--                            </div>-->
                                </div>
                            </el-card>


                        </div>

                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="24">
                        <div class="grid-content bg-purple" contenteditable="true" style="overflow:auto;height:100px">
                            <!--                            <input type="text" v-model="message">-->
                            <el-input
                                    type="textarea"
                                    :autosize="{ minRows: 4, maxRows: 4}"
                                    placeholder="请输入内容"
                                    v-model="message">
                            </el-input>

                        </div>
                        <div>
                            <i @click="sendMessage" class="el-icon-position"></i>
                            <!--                            <button @click="send">发送</button>-->
                        </div>


                    </el-col>
                </el-row>

            </el-col>
            <!--            <el-col :span="8">-->
            <!--                <div class="grid-content bg-purple">-->

            <!--                </div>-->
            <!--            </el-col>-->

        </el-row>
    </div>
</template>

<script>
    import {indexVisit} from '../../api/visit'
    import {chat} from '../../api/chat'
    import websocket from '../../websocket/index.js';

    export default {
        data() {
            return {
                disabled: false,
                message: 'ceshi',
                meta: {
                    lasted_at: 'desc',
                    size: 100,
                },
                messageList: [],
                visitor: {
                    id: '',
                    visitor_id: ''
                },
                conversationList: []
            }
        },
        mounted() {
            this.ws()
        },
        methods: {
            //监听ws
            ws() {
                //用户触发userConnect请求
                let message = {'hello_token': localStorage.getItem('hello_token'), 'event': 'userConnect'}
                websocket.onopen(websocket.init, message)
                websocket.onmessage(websocket.init, this)
            },
            //打开一个会话内容
            openChat(index) {
                let arr = index.split(",");
                this.visitor.visitor_id = arr[0]
                this.visitor.id = arr[1]
                chat({'visitor_id': this.visitor.visitor_id}).then(ret => {
                    const {data, meta} = ret
                    this.messageList = data
                }).catch(err => {
                    console.log(err)
                })
            },
            //发送消息
            sendMessage() {
                let message = {
                    'user_id': localStorage.getItem('hello_token'),
                    'visitor_id': this.visitor.visitor_id,
                    'agent': 'user',
                    'event': 'userMessage',
                    'data': {'content': this.message}
                }
                websocket.send(websocket.init, message)
                this.messageList.push({content: this.message})
            },
            //接收消息
            messageReceived(message) {
                this.messageList.push({content: message.data.content})
                document.title = "未读消息-----"
                this.titleSetInterval = setInterval(this.scrollTitle, 1000);
                console.log(this.titleSetInterval)
            },
            //标题滚动
            scrollTitle() {
                var titleInfo = document.title;
                var firstInfo = titleInfo.charAt(0);
                var lastInfo = titleInfo.substring(1, titleInfo.length);
                document.title = lastInfo + firstInfo;
            },
            //访客列表滚动触发
            load() {
                this.getVisit()
            },
            //获取访客列表
            getVisit() {
                indexVisit({'size': this.meta.size, 'lasted_at': this.meta.lasted_at}).then(ret => {
                    const {data, meta} = ret
                    if (data.length < this.meta.size) {
                        this.disabled = true
                    }

                    this.conversationList = this.conversationList.concat(data)
                    console.log(this.conversationList)
                    // this.meta.total = meta.total
                }).catch(err => {
                    console.log(err)
                })

            },
            //消息列表滚动到底
            scrollDown() {
                this.$refs['myScrollbar'].wrap.scrollTop = this.$refs['myScrollbar'].wrap.scrollHeight
            }

        }

    }
</script>
<style scoped>
    .el-row {
        margin-bottom: 20px;

    &
    :last-child {
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

    /*-------*/
    .messageLeft {
        float: left;
    }

    .messageRight {
        float: right;
    }

    .item {
        padding: 18px 0;
    }

</style>