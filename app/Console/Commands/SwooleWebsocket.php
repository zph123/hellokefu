<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Services\WebsocketService;

class SwooleWebsocket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole:websocket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    public $server;
    public $websocket;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(WebsocketService $websocket)
    {
        parent::__construct();
        $this->websocket=$websocket;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //创建ws
        $this->server = new \Swoole\WebSocket\Server("0.0.0.0", 9501);
        //打开监听
        $this->server->on('open', function (\Swoole\WebSocket\Server $server, $request) {
            echo "fd{$request->fd}进入房间\n";
        });
        //消息监听
        $this->server->on('message', function (\Swoole\WebSocket\Server $server, $frame) {
            echo "收到fd{$frame->fd}请求:{$frame->data}\n";
            //根据data的event类型获取对应的事件
            $data=json_decode($frame->data,true);
            if (isset($data['event'])){
                $event=$data['event'];
                $this->websocket->$event($server,$frame);
            }
        });
        //关闭监听
        $this->server->on('close', function ($ser, $fd) {
            $user_visitor=Redis::get("hello:fd:".$fd);
            Redis::del("hello:fd:".$fd);
            Redis::del("hello:user_visitor:".$user_visitor);
            dump("fd".$fd."离开房间");
        });
        //启动
        $this->server->start();
    }

}
