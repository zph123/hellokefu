<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        //
        $server = new \swoole_websocket_server("127.0.0.1", 9502);

        $server->on('open', function($server, $req) {
            echo "connection open: {$req->fd}\n";
        });

        $server->on('message', function($server, $frame) {
            echo "received message: {$frame->data}\n";
            $server->push($frame->fd, json_encode(["hello", "world"]));
        });

        $server->on('close', function($server, $fd) {
            echo "connection close: {$fd}\n";
        });

        $server->start();
    }
}
