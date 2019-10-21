<template>
    <div>
        <h2>用户的id：{{user.user_id}}</h2>
        <input type="text" v-model="message">
        <button v-on:click="sendMessage">发送1</button>
        <ul>
            <li v-for="item in messageList">
                {{ item.content }}
            </li>
        </ul>
    </div>
</template>

<script>
    import Websocket from '../../utils/websocket.js'
    import { chat } from '../../api/chat'
    export default {
        data() {
            return {
                ws:"",
                message: 'chat',
                messageList: [
                    {content: 'Runoob'},
                    {content: 'Google'},
                    {content: 'Taobao'}
                ],
                user:{
                    user_id:''
                },
                visitor:{},
                titleSetInterval:0
            }
        },
        mounted() {
            //当前窗口visibilitychange事件
            document.addEventListener("visibilitychange",this.onVisibilitychange);
            console.log(this.user)
            //获取app_id
            let app_uuid = this.$route.query.app_uuid
            if(app_uuid==undefined){
                alert('请选择您要沟通的app')
                return false
            }else{
                this.visitor.app_uuid=app_uuid
            }
            //new websoket
            const ws=Websocket.ws()
            this.ws=ws
            //连接建立时触发create_visitor请求
            var visitor_id=localStorage.getItem('visitor_id');
            if(visitor_id){
                var json={'app_uuid':app_uuid,'from':'visitor','to':'user','event':'visitorConnect','data':{'visitor_id':visitor_id}}
            }else{
                var json={'app_uuid':app_uuid,'from':'visitor','to':'visitor','event':'visitorCreate'}
            }
            var message=JSON.stringify(json)
            Websocket.onopen(ws,message)
            //接收消息监听
            Websocket.onmessage(ws,this)
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
                // this.messageList.push({content: this.message})

            },
            sendMessage() {
                let json={'app_uuid':this.visitor.app_uuid,'visitor_id':this.visitor.visitor_id,'agent':'visitor','event':'visitorMessage', 'data':{'content':this.message}}
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
</style>