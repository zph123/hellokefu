<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Swoole\WebSocket\Server;

class Chat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole:chat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'chat service';

    /**
     * @var
     */
    protected $server;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $server = new Server("0.0.0.0", 9502);

        $server->on('open', function($server, $req) {
            echo "connection open: {$req->fd}\n";
            $chat = [
                'id'        => '1000',
                'username'  => '管理员',
                'avatar'    => "http://qzapp.qlogo.cn/qzapp/100280987/56ADC83E78CEC046F8DF2C5D0DD63CDE/100",
                'type'      => 'friend',
                'content'   => "请问你有什么疑问吗？"
            ];
            $server->push($req->fd, json_encode($chat));
        });

        $server->on('message', function($server, $frame) {
            echo "received message: {$frame->data} opcode: {$frame->opcode}\n";

            $data = json_decode($frame->data,true);
            if(isset($data['content'])){
                $chat = [
                    'id'        => '1000',
                    'username'  => '管理员',
                    'avatar'    => "http://qzapp.qlogo.cn/qzapp/100280987/56ADC83E78CEC046F8DF2C5D0DD63CDE/100",
                    'type'      => 'friend',
                    'content'   => $data['content']
                ];
                $server->push($frame->fd, json_encode($chat));
            }
            var_dump(json_decode($frame->data,true));
        });

        $server->on('close', function($server, $fd) {
            echo "connection close: {$fd}\n";
        });

        $server->start();
    }
}
