<?php
/**
 * Created by PhpStorm.
 * User: bing
 * Date: 2019/11/2
 * Time: 11:25
 */

namespace App\Services;


use App\Exceptions\ApiException;
use App\Http\Resources\ChatResource;
use App\Models\Chat;

class ChatEventService extends EventService
{

    protected $server;
    protected $fd;
    protected $data;
    protected $body;
    protected $params;

    public function init($server, $frame)
    {
        /**
         * array:3 [
         * "body" => array:2 [
         * "content" => "555\n"
         * ]
         * "params" => array:2 [
         * "app_uuid" => "8d1b32f0-f3cc-11e9-9994-d740e096dedd"
         * "vid" => "e98ac630-fc85-11e9-ab57-c5097f88c2b7"
         * ]
         * "event" => "send"
         * "type" => "chat"
         * ]
         */
        $this->server = $server;
        $this->fd = $frame->fd;
        $this->data = json_decode($frame->data, true);
        $this->body = $this->data['body'];
        $this->params = $this->data['params'];
        return $this;
    }

    /**
     * 访客端链接
     *
     * @return bool|mixed
     */
    public function connect()
    {
        return $this->redis->visitorFd($this->params['vid'], $this->fd);
    }

    /**
     *
     */
    public function send()
    {
        try {
            $userId = VisitorService::getUserIdByVisitorId($this->params['vid']);

            // 入表
            $chat = Chat::create([
                'visitor_id' => $this->params['vid'],
                'user_id' => $userId,
                'agent' => Chat::AGENT_VISITOR,
                'content' => $this->body['content']
            ]);
            // 发给自己
            dump('#visitorFd--->',$this->fd);
            $this->server->push($this->fd,json_encode(new ChatResource($chat)));

            // 发给客服
            $userFd = $this->redis->userFd($userId);
            dump('#userFd--->',$userFd);
            $this->server->push($userFd, json_encode(new ChatResource($chat)));

        } catch (ApiException $e) {
            dump($e->getMessage());
        }
    }


}