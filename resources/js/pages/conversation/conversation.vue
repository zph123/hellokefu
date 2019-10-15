<template>
    <div>
        <h2>conversation</h2>
        <input type="text" v-model="message">
        <button v-on:click="send">发送1</button>
        <ul>
            <li v-for="site in sites">
                {{ site.name }}
            </li>
        </ul>
    </div>
</template>

<script>
    //console.log(localStorage.getItem('token'))
    //var ws = new WebSocket("ws://127.0.0.1:9501?token="+localStorage.getItem('token'));
    export default {
        data() {
            return {
                message: 'ceshi',
                sites: [
                    {name: 'Runoob'},
                    {name: 'Google'},
                    {name: 'Taobao'}
                ]
            }
        },
        // mounted() {
        //     var _this = this
        //     ws.onopen = function () {
        //         //进入房间
        //         console.log("进入房间")
        //     };
        //     ws.onmessage = function (evt) {
        //         var received_msg = evt.data;
        //         console.log(2)
        //         _this.sites.push({name: received_msg})
        //     };
        //     ws.onclose = function () {
        //         // 关闭 websocket
        //         console.log("有人退出");
        //     };
        // },
        // methods: {
        //     send() {
        //         var data={'message':this.message,'from':'user'}
        //         ws.send(data);
        //     }
        // }
    }
</script>
<style scoped>
</style>