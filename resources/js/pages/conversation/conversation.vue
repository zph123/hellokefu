<template>
    <div class="app-container">

            <ul class="infinite-list" v-infinite-scroll="load" style="overflow:auto">
                <li v-for="i in count" class="infinite-list-item">{{ i }}</li>
            </ul>


            <h2>conversation</h2>
            <input type="text" v-model="message">
            <button @click="send">发送1</button>
            <ul>
                <li v-for="site in sites">
                    {{ site.name }}
                </li>
            </ul>
           


    </div>
</template>

<script>
    import Websocket from '../../utils/websocket.js'
    export default {
        data() {
            return {
                message: 'ceshi',
                count: 0,
                sites: [
                    {name: 'Runoob'},
                    {name: 'Google'},
                    {name: 'Taobao'}
                ]
            }
        },
        mounted() {
            //获取app_id
            let app_id = this.$route.query.app_id
            //new websoket
            const ws=Websocket.ws()
            this.ws=ws
            //连接建立时触发visitor_create请求
            var json={'app_id':app_id,'from':'user','event':'user_connect'}
            var data=JSON.stringify(json)
            Websocket.onopen(ws,data)
            //接收消息监听
            Websocket.onmessage(ws,this)

        },
        methods: {
            send() {
                // var json={'message':this.message,'from':'visitor','event':'create_visitor'}
                // var data=JSON.stringify(json)
                // Websocket.send(this.ws,data);
            },
            load () {
                this.count += 2
            }
        }

    }
</script>
<style scoped>
</style>