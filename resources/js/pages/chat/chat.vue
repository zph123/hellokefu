<template>
    <div>
        <el-row :gutter="20">
            <el-col :span="6">
                &nbsp;
            </el-col>
            <el-col :span="12">
                <div class="main">
                    <div class="message" ref="viewBox" style="overflow:auto;height:300px">
                        <ul>
                            <li v-for="item in messageList">
                                <p class="time"><span>16:09({{item.created_at}})</span></p>
                                <div v-bind:class="{ self: 'visitor'==item.agent}">
                                    <img class="avatar" width="30" height="30" _v-b412eea0="" src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png">
                                    <div class="text" _v-b412eea0="">
                                        {{ item.content }}
                                    </div>
                                </div>

                            </li>
                        </ul>
                    </div>
                    <br>
                </div>
                <div class='text'>
                    <div class="grid-content bg-purple" contenteditable="true" style="overflow:auto;height:100px">
                        <el-input
                                type="textarea"
                                :autosize="{ minRows: 4, maxRows: 4}"
                                placeholder="请输入内容"
                                resize="none"
                                maxlength="200"
                                outline="none"
                                v-model="message">
                        </el-input>

                    </div>
                </div>
            </el-col>
            <el-col :span="6">
                &nbsp;
            </el-col>
        </el-row>

<!--        <h2>用户的id：{{user.name}}{{user.avatar}}</h2>-->
<!--        <input type="text" v-model="message">-->
<!--        <button v-on:click="sendMessage">发送1</button>-->
    </div>
</template>

<script>
    import { chat } from '../../api/chat'
    import websocket from '../../websocket/index.js';
    export default {
        data() {
            return {
                message: '测试',
                messageList: [
                    {content: '内容1'},
                    {content: '内容2'},
                    {content: '内容3'}
                ],
                user:{
                    name:'',
                    avatar:'',
                },
                visitor:{},
                titleSetInterval:0
            }
        },
        mounted() {
            var _this=this
            document.onkeydown = function(ev){
                let evObj = window.event || ev;
                console.log(evObj.keyCode);
                if (evObj.keyCode==13){
                    _this.sendMessage()
                }
            }
            // 首先通过$refs获取dom元素
            this.box = this.$refs.viewBox
            console.log(this.box)
// 监听这个dom的scroll事件
            this.box.addEventListener('scroll', () => {
                console.log(this.$refs.viewBox.scrollTop)
            }, false)

            //当前窗口visibilitychange事件
            document.addEventListener("visibilitychange",this.onVisibilitychange);
            //获取app_id
            let app_uuid = this.$route.query.app_uuid
            if(app_uuid==undefined){
                alert('请选择您要沟通的app')
                return false
            }else{
                this.visitor.app_uuid=app_uuid
            }
            //连接建立时触发create_visitor请求
            var visitor_id=localStorage.getItem('visitor_id');
            let message=''
            if(visitor_id){
                message={'app_uuid':app_uuid,'event':'visitorConnect','data':{'visitor_id':visitor_id}}
            }else{
                message={'app_uuid':app_uuid,'event':'visitorCreate'}
            }
            // var message=JSON.stringify(json)
            websocket.onopen(websocket.init,message)
            //接收消息监听
            websocket.onmessage(websocket.init,this)
        },
        methods: {
            onVisibilitychange(){
                if (!document.hidden) {   //处于当前页面
                    clearInterval(this.titleSetInterval);
                    document.title="咨询"
                }

            },
            visitorCreateSuccess(message) {
                localStorage.setItem('visitor_id',message.data.visitor_id)
                this.visitor.visitor_id=message.data.visitor_id
                console.log(this.visitor)
                this.user={'user_id':message.data.user_id}
                this.messageList.push({content: message})
            },
            visitorConnectSuccess(message) {
                this.visitor.visitor_id=localStorage.getItem('visitor_id')
                console.log(this.visitor)

                this.user={'user_id':message.data.user_id}
                console.log(message)
                this.openChat()
            },
            sendMessage() {
                let message={'app_uuid':this.visitor.app_uuid,'visitor_id':this.visitor.visitor_id,'agent':'visitor','event':'visitorMessage', 'data':{'content':this.message}}
                websocket.send(websocket.init,message)
                this.messageList.push({content: this.message,agent:'visitor'})
                this.message=''
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
            openChat(){
                chat({'app_uuid': this.visitor.app_uuid,'visitor_id': this.visitor.visitor_id}).then(ret => {
                    const { data, meta } = ret
                    this.messageList=data
                }).catch(err => {
                    console.log(err)
                })
            },

        }
    }
</script>
<style scoped>
    .main{
        margin-top:20px;
        background-color: #eee;
    }

    .message {
        padding: 10px 15px;
        overflow-y: scroll;
    }
     .message .time {
         margin: 7px 0;
         text-align: center;
     }
     .message .time>span {
         display: inline-block;
         padding: 0 18px;
         font-size: 12px;
         color: #fff;
         border-radius: 2px;
         background-color: #dcdcdc;
     }

    .message .avatar[_v-b412eea0] {
        float: left;
        margin: 0 10px 0 0;
        border-radius: 3px;
    }

    .message .text[_v-b412eea0] {
        display: inline-block;
        position: relative;
        padding: 0 10px;
        max-width: calc(100% - 40px);
        min-height: 30px;
        line-height: 2.5;
        font-size: 12px;
        text-align: left;
        word-break: break-all;
        background-color: #fafafa;
        border-radius: 4px;
    }
    .message .text[_v-b412eea0]:before {
        content: " ";
        position: absolute;
        top: 9px;
        right: 100%;
        border: 6px solid transparent;
        border-right-color: #fafafa;
    }
    .message .self{
        text-align: right;
    }
    .message .self .text{
        background-color: #b2e281;
    }
    .message .self .avatar {
        float: right;
        margin: 0 0 0 10px;
    }
    .message .self .text:before {
        right: inherit;
        left: 100%;
        border-right-color: transparent;
        border-left-color: #b2e281;
    }
</style>