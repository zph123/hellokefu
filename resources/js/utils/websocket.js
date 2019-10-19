var websocket = {
    ws: function(){
        return new WebSocket("ws://127.0.0.1:9501");
    },
    onopen: function(ws,data){
        ws.onopen = function () {
            ws.send(data);
        }
    },
    onmessage:function(ws,_this){
        ws.onmessage = function (evt) {
            var received_msg=evt.data
            var json_received_msg=JSON.parse(received_msg)
            var event=json_received_msg.event
            console.log(event)
            _this[event](json_received_msg)
        }
    },
    send:function (ws,data) {
        ws.send(data);
    },

}
export default websocket