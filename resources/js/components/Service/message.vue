<template>
    <div class="main-content">
        <div class="message">
            <ul v-if="messages">
                <div class="header">中国.上海.上海</div>

                <li v-for="item in messages">
                    <p class="time">
                        <span>{{ item.created_at | time }}</span>
                    </p>
                    <div class="main" :class="{ self: item.agent === 'user'}">
                        <img class="avatar" width="30" height="30" :src="item.agent === 'user' ? item.user.avatar : item.visitor.avatar" />
                        <div class="text">{{ item.content }}</div>
                    </div>
                </li>
            </ul>
        </div>
        <!--聊天窗-->
        <div class="talk-text">
            <textarea placeholder="在这里输入，按 Enter 发送" v-model="content" @keyup="onKeyup"></textarea>
        </div>
    </div>
</template>
<script>
    import { getToken } from '../../utils/auth'
    import { messages } from '../../api/service'
    export default {
        data(){
            return {
                ws: null,
                vid: false,
                content: '',
                messages: [],
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
        },
        created (){
            this.vid = this.$route.query.vid
            this.init()
        },
        watch: {
            '$route'(to, from) {
                this.vid = to.query.vid
                if (this.vid){
                    messages({vid: this.vid}).then(ret => {
                        console.log(ret)
                        this.messages = ret.data.reverse()
                    }).catch()
                }
            }
        },
        methods: {
            init () {
                this.ws = new WebSocket("ws://47.105.138.9:9502");
                console.log('connect...',this.ws)
                this.ws.onopen = this.webSocketOpen
                this.ws.onmessage = this.webSocketMessage
                this.ws.onerror = this.webSocketError
                this.ws.onclose = this.webSocketClose
                if (this.vid){
                    messages({vid: this.vid}).then(ret => {
                        console.log(ret)
                        this.messages = ret.data.reverse()
                    }).catch()
                }
            },
            webSocketOpen(){
                // 建立链接
                let actions = {body:{},params: {vid: this.vid,token: getToken()},event:'connect',type:'user'};
                this.ws.send(JSON.stringify(actions));
            },
            webSocketMessage(evt){
                let receivedData = evt.data;
                console.log('---receivedData---',receivedData)
                this.messages.push(JSON.parse(receivedData))
            },
            webSocketError(){
            },
            webSocketClose(){
                alert('close');
            },
            onKeyup (e) {
                if (e.keyCode === 13 && this.content.length) {
                    // 发送消息
                    let actions = {body: {content: this.content},params: {vid: this.vid, token: getToken()},event:'send',type:'user'};
                    this.ws.send(JSON.stringify(actions))
                    this.content = '';
                }
            }
        }
    };
</script>
<style lang="less" scoped>
    .main-content{
        .message {
            padding: 10px 15px;
            /*overflow-y: scroll;*/
            overflow:auto;
            border: solid 1px #EBEBEB;
            height: 600px;
            /*height: ~'calc(100% - 860px)';*/
            li {
                margin-bottom: 15px;
            }
            .header{
                text-align: center;
                background-color: #F3F3F3;
                height: 40px;
                line-height: 40px;
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
                /*background-color: #fafafa;*/
                background-color: #F3F3F3;
                border-radius: 4px;

                &:before {
                    content: " ";
                    position: absolute;
                    top: 9px;
                    right: 100%;
                    border: 6px solid transparent;
                    border-right-color: #F3F3F3;
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
        /* 聊天 */
        .talk-text{
            /*position: absolute;*/
            width: 100%;
            bottom: 0;
            left: 0;

            height: 160px;
            border: solid 1px #ddd;
            border-top: none;

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