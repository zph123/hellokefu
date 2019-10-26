const init = new WebSocket("ws://127.0.0.1:9501");

function onopen(ws, data) {
    ws.onopen = function () {
        data=JSON.stringify(data)
        ws.send(data);
    }
}

function onmessage(ws, _this) {
    ws.onmessage = function (evt) {
        var received_msg = evt.data
        var json_received_msg = JSON.parse(received_msg)
        var event = json_received_msg.event
        console.log(event)
        _this[event](json_received_msg)
    }
}

function send(ws, data) {
    data=JSON.stringify(data)
    ws.send(data);
}

export default {
    init,
    onopen,
    onmessage,
    send
}