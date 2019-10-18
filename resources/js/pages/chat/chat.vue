<template>
    <div>
        <h2>用户的id：{{user.user_id}}</h2>
        <input type="text" v-model="message">
        <button v-on:click="send">发送1</button>
        <ul>
            <li v-for="item in messageList">
                {{ item.content }}
            </li>
        </ul>
    </div>
</template>

<script>
    import Websocket from '../../utils/websocket.js'
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
                }
            }
        },
        mounted() {
            console.log(this.user)
            //获取app_id
            let app_id = this.$route.query.app_id
            if(app_id==undefined){
                alert('请选择您要沟通的app')
                return false
            }
            //new websoket
            const ws=Websocket.ws()
            this.ws=ws
            //连接建立时触发create_visitor请求
            var visitor_id=localStorage.getItem('visitor_id');
            if(visitor_id){
                var json={'app_id':app_id,'from':'visitor','to':'user','event':'visitorConnect','data':{'visitor_id':visitor_id}}
            }else{
                var json={'app_id':app_id,'from':'visitor','to':'visitor','event':'visitorCreate'}
            }
            var message=JSON.stringify(json)
            Websocket.onopen(ws,message)
            //接收消息监听
            Websocket.onmessage(ws,this)
        },
        methods: {
            visitorCreateSuccess(message) {
                localStorage.setItem('visitor_id',message.data.visitor_id)
                this.user={'user_id':message.data.user_id}
                this.messageList.push({content: message})
            },
            visitorConnectSuccess(message) {
                this.user={'user_id':message.data.user_id}
                console.log(message)
                this.messageList.push({content: message})

            },
            send() {
                console.log("send")
            },

        }
    }
</script>
<style scoped>
</style>