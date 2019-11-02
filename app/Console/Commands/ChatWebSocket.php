<?php

namespace App\Console\Commands;

use App\Services\ChatEventService;
use App\Services\UserEventService;
use Illuminate\Console\Command;
use Swoole\WebSocket\Server;

class ChatWebSocket extends Command
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
     * @var ChatEventService
     */
    protected $chatEvent;

    /**
     * @var UserEventService
     */
    protected $userEvent;

    /**
     * 访客事件类型
     */
    const CHAT_EVENT_TYPE = 'chat';

    /**
     * 客服事件类型
     */
    const USER_EVENT_TYPE = 'user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ChatEventService $chatEvent,UserEventService $userEvent)
    {
        $this->server = new Server("0.0.0.0", 9502);
        $this->chatEvent = $chatEvent;
        $this->userEvent = $userEvent;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->server->on('open', function($server, $req) {
            echo "connection open: {$req->fd}\n";
        });

        $this->server->on('message', function($server, $frame) {
            echo "received message: {$frame->data} opcode: {$frame->opcode}\n";
            $data = json_decode($frame->data,true);

            // 访客消息
            if(isset($data['event']) && isset($data['type']) && $data['type'] == self::CHAT_EVENT_TYPE){
                $event = $data['event'];
                $ret = $this->chatEvent->init($server,$frame)->$event();
                dump('$ret-->',$ret);
            }

            // 客服消息
            if(isset($data['event']) && isset($data['type']) && $data['type'] == self::USER_EVENT_TYPE){
                $event = $data['event'];
                $ret = $this->userEvent->init($server,$frame)->$event();
                dump('$ret-->',$ret);
            }
        });

        $this->server->on('close', function($server, $fd) {
            echo "connection close: {$fd}\n";
        });

        $this->server->start();
    }
}
