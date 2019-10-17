var websocket = {
    ws: function(){
        return new WebSocket("ws://127.0.0.1:9501?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9kZXYuaGVsbG9rZWZ1LmNvbVwvYXBpXC9sb2dpbiIsImlhdCI6MTU3MTMxMjYxNSwiZXhwIjoxNTcxMzE2MjE1LCJuYmYiOjE1NzEzMTI2MTUsImp0aSI6IlQzSVhidU8wMklWN2ZGazMiLCJzdWIiOjIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.E-6mJBQiTQExPgDKbK_rBIvJwr8ZNOZFbAzzFJ5PC3w");
    },
    onopen: function(ws,data){
        ws.onopen = function () {
            ws.send(data);
        }
    },
    onmessage:function(ws,_this){
        ws.onmessage = function (evt) {
            var received_msg=evt.data
            _this.sites.push({name: received_msg})
            var json_received_msg=JSON.parse(received_msg)
            var event=json_received_msg.event
            console.log(event)
            _this[event](json_received_msg)
        }
    },
    // send:function (ws,data) {
    //     console.log(123)
    //     ws.send(data);
    // },

}
export default websocket