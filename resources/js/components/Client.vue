<template>
    <div class="chat-box">
        <div class="header">
            <img class="avatar" width="30" height="30" src="http://laravel-admin.test/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg" />
            <span>管理员</span>
        </div>
        <div class="message" id="message-box">
            <div class="message-container" v-loading="loading">
                <ul v-if="messages">
                    <li v-for="item in messages">
                        <p class="time">
                            <span>{{ item.created_at | time }}</span>
                        </p>
                        <div class="main" :class="{ self: item.agent === 'visitor' }">
                            <img class="avatar" width="30" height="30" :src="item.agent === 'visitor' ? item.visitor.avatar : item.user.avatar" />
                            <div class="text">{{ item.content }}</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="talk-text">
            <textarea placeholder="在这里输入，按 Enter 发送" v-model="content" @keyup="onKeyup"></textarea>
        </div>
        <div class="footer">
            <a href="">哈啰客服</a> &nbsp;&nbsp;提供客服系统支持
        </div>
    </div>
</template>
<script>
    import { chat, message } from '../api/client'
    import { visitor } from '../utils/auth'
    export default {
        data(){
            return {
                ws: null,
                content: '',
                loading: true,
                vid: false,
                params: {
                    app_uuid: '',
                },
                visitor: {},
                messages: []
            }
        },
        created() {
            this.params.app_uuid = this.$route.query.app_uuid;
            this.vid = visitor()
            if(this.vid){
                this.params.vid = this.vid
            }
            this.init()
        },
        methods: {
            init () {
                this.ws = new WebSocket("ws://127.0.0.1:9502");
                this.ws.onopen = this.webSocketOpen
                this.ws.onmessage = this.webSocketMessage
                this.ws.onerror = this.webSocketError
                this.ws.onclose = this.webSocketClose

                // 分配客服
                chat(this.params).then(ret => {
                    visitor(ret.data.visitor_id)
                    this.visitor = ret.data
                }).catch()

                if (this.vid){
                    // 聊天内容
                    message(this.params).then(ret => {
                        console.log(ret)
                        this.messages = ret.data.reverse()
                    }).catch()
                }
                this.loading = false
            },
            webSocketOpen(){
                // 建立链接
                let actions = {body:{},params: this.params,event:'connect',type:'chat'};
                this.ws.send(JSON.stringify(actions));
            },
            webSocketMessage(evt){
                let receivedData = evt.data;
                console.log('receivedData...',receivedData)
                this.messages.push(JSON.parse(receivedData))
            },
            webSocketError(){
            },
            webSocketClose(){
                alert('close')
            },
            onKeyup (e) {
                if (e.keyCode === 13 && this.content.length) {
                    console.log(this.content)
                    // 发送消息
                    let actions = {body: {content: this.content},params: this.params,event:'send',type:'chat'};
                    this.ws.send(JSON.stringify(actions))

                    // 发送消息后滚动到底部
                    let box = document.getElementById('message-box');
                    box.scrollTop = parseInt(box.scrollHeight) - parseInt(box.clientHeight)
                    console.log('sending...',actions)
                    this.content = '';
                }
            }
        },
        filters: {
            // 将日期过滤为 hour:minutes
            time (date) {
                if (typeof date === 'string') {
                    date = new Date(date);
                }
                return date.getHours() + ':' + date.getMinutes();
            }
        }
    };
</script>
<style lang="less" scoped>
    .chat-box{
        .header {
            text-align: left;
            color:#fff;
            background-color: #0066A9;
            height: 50px;
            line-height: 50px;
            img {
                margin-top: 10px;
                margin-left: 10px;
                border-radius: 14px;
            }
            span {
                height: 40px;
                line-height: 40px;
            }
        }
        .footer{
            text-align: center;
            /*position: absolute;*/
            color: #D7D7D7;
            width: 100%;
            bottom: 0;
            background-color: #0066A9;
            height: 30px;
            line-height: 30px;
            font-size: 12px;
        }
        .message {
            /*overflow-y: scroll;*/
            overflow:auto;
            height: 350px;
            border:  solid 1px #EBEBEB;
            li {
                margin-bottom: 15px;
            }


            .message-container {
                padding: 10px 15px;
            }
            .time {
                margin: 7px 0;
                text-align: center;

                > span {
                    display: inline-block;
                    padding: 0 18px;
                    font-size: 12px;
                    color: #fff;
                    border-radius: 2px;
                    background-color: #dcdcdc;
                }
            }
            .avatar {
                float: left;
                margin: 0 10px 0 0;
                border-radius: 3px;
            }
            .text {
                display: inline-block;
                position: relative;
                padding: 0 10px;
                max-width: ~'calc(100% - 40px)';
                min-height: 30px;
                line-height: 2.5;
                font-size: 12px;
                text-align: left;
                word-break: break-all;
                background-color: #fafafa;
                border-radius: 4px;

                &:before {
                    content: " ";
                    position: absolute;
                    top: 9px;
                    right: 100%;
                    border: 6px solid transparent;
                    border-right-color: #fafafa;
                }
            }

            .self {
                text-align: right;

                .avatar {
                    float: right;
                    margin: 0 0 0 10px;
                }
                .text {
                    background-color: #b2e281;

                    &:before {
                        right: inherit;
                        left: 100%;
                        border-right-color: transparent;
                        border-left-color: #b2e281;
                    }
                }
            }
        }
        .talk-text {
            /*position: absolute;*/
            width: 100%;
            bottom: 0;
            left: 0;
            border: solid 1px #ddd;
            border-top: none;
            /*border-top: solid 1px #ddd;*/
            height: 160px;

            textarea {
                padding: 10px;
                height: 100%;
                width: 100%;
                border: none;
                outline: none;
                font-family: "Micrsofot Yahei";
                resize: none;
            }
        }
    }

</style>