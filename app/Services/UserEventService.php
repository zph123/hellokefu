<?php
/**
 * Created by PhpStorm.
 * User: bing
 * Date: 2019/11/2
 * Time: 13:40
 */

namespace App\Services;


use App\Http\Resources\ChatResource;
use App\Models\Chat;

class UserEventService extends EventService
{

    protected $server;
    protected $fd;
    protected $data;
    protected $body;
    protected $params;
    protected $userId;


    public function init($server,$frame)
    {
        $this->server = $server;
        $this->fd = $frame->fd;
        $this->data = json_decode($frame->data, true);
        $this->body = $this->data['body'];
        $this->params = $this->data['params'];
        $this->userId = auth('api')->setToken($this->params['token'])->user()->id;
        return $this;
    }

    /**
     * 客服端链接
     *
     * @return bool|mixed
     */
    public function connect()
    {
        return $this->redis->userFd($this->userId, $this->fd);
    }

    /**
     *
     */
    public function send()
    {
        // 入表
        $visitorId = $this->params['vid'];
        dump('#visitorFd--->',$visitorId);

        $chat = Chat::create([
            'visitor_id' => $visitorId,
            'user_id' => $this->userId,
            'agent' => Chat::AGENT_USER,
            'content' => $this->body['content']
        ]);
        // 通知自己
        $this->server->push($this->fd,json_encode(new ChatResource($chat)));

        // 通知访客
        $visitorFd = $this->redis->visitorFd($visitorId);
        $this->server->push($visitorFd,json_encode(new ChatResource($chat)));

    }
}