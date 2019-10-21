<template>
    <div class="app-container">
        <el-row :gutter="20">
            <el-col :span="8">
                <div class="grid-content bg-purple">
                    <ul class="infinite-list" v-infinite-scroll="load" infinite-scroll-disabled="disabled" style="overflow:auto;height:300px">
                        <el-menu
                                default-active="2"
                                class="el-menu-vertical-demo"
                                @select="openChat"
                                @close="">
                            <el-menu-item v-for="(item, index) in conversationList" :index="item.visitor_id+''">
                                <i class="el-icon-menu"></i>
                                <span slot="title">{{item.id}}：{{item.visitor_id}}</span>
                                <span slot="title"></span>
                            </el-menu-item>

                        </el-menu>
                    </ul>
                </div>
            </el-col>
            <el-col :span="16">
                <el-row>
                    <el-col :span="24">
                        <div class="grid-content bg-purple" style="overflow:auto;height:300px" ref="myScrollbar">
                            <div>{{visitor}}</div>
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
    import Websocket from '../../utils/websocket.js'
    import { indexVisit } from '../../api/visit'
    import { chat } from '../../api/chat'
    export default {
        data() {
            return {
                disabled:false,
                message: 'ceshi',
                meta: {
                    lasted_at:'desc',
                    size: 100,
                },
                messageList: [],
                visitor: {},
                user: {},
                conversationList:[]
            }
        },
        mounted() {
            //new websoket
            const ws=Websocket.ws()
            this.ws=ws
            //连接建立时触发userConnect请求
            var hello_token=localStorage.getItem('hello_token');
            var json={'hello_token':hello_token,'from':'user','to':'visitor','event':'userConnect'}
            var message=JSON.stringify(json)
            Websocket.onopen(ws,message)
            //接收消息监听
            Websocket.onmessage(ws,this)
        },
        methods: {
            load () {
                this.getConversation()
            },
            openChat(index){
              this.visitor={'visitor_id':index}
                chat({'visitor_id': this.visitor.visitor_id}).then(ret => {
                    const { data, meta } = ret
                    this.messageList=data
                }).catch(err => {
                    console.log(err)
                })
            },
            sendMessage() {
                let json={'user_id':localStorage.getItem('hello_token'),'visitor_id':this.visitor.visitor_id,'agent':'user','event':'userMessage', 'data':{'content':this.message}}
                let message=JSON.stringify(json)
                Websocket.send(this.ws,message)
                this.messageList.push({content: this.message})

            },
            messageReceived(message){
                this.messageList.push({content: message.data.content})
                document.title="未读消息-----"
                this.titleSetInterval=setInterval(this.scrollTitle, 1000);
                console.log(this.titleSetInterval)
            },
            scrollTitle() {
                var titleInfo = document.title;
                var firstInfo = titleInfo.charAt(0);
                var lastInfo = titleInfo.substring(1, titleInfo.length);
                document.title = lastInfo + firstInfo;
            },
            getConversation() {
                indexVisit({'size': this.meta.size,'lasted_at': this.meta.lasted_at}).then(ret => {
                    const { data, meta } = ret
                    if(data.length<this.meta.size){
                        this.disabled=true
                    }

                    this.conversationList=this.conversationList.concat(data)
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
    /*-------*/
    .messageLeft {
        float: left;
    }
    .messageRight {
        float: right;
    }
    .text {
        /*font-size: 14px;*/
    }

    .item {
        padding: 18px 0;
    }

</style>