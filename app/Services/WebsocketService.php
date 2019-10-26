<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Webpatser\Uuid\Uuid;
use App\Models\Visitor;
use App\Models\Chat;
use App\Models\Application;

class WebsocketService
{

    public function __construct()
    {

    }

    //消息类型转化成array
    private function dataArr($frame)
    {
        $data = $frame->data;
        return json_decode($data, true);
    }

    //存储user_visitor和fd到redis中
    private function storeFd($user_visitor, $fd)
    {
        Redis::set("hello:user_visitor:" . $user_visitor, $fd);
        Redis::set("hello:fd:" . ($fd), $user_visitor);
    }
    //异常请求
    private function exceptionRequest($server,$frame,$data)
    {
        $arr=[
            'event'=>'error',
            'data'=>$data
        ];
        $server->push($frame->fd, json_encode($arr));
        return false;
    }

    //客服连接
    public function userConnect($server, $frame)
    {
        $arr = $this->dataArr($frame);
        $user = auth('api')->setToken($arr['hello_token'])->user();
        $user_id=$user->id;
        $this->storeFd($user_id, $frame->fd);
        Redis::sadd("hello:app_id:user:" . ($user->app_id), $user_id);
    }

    public function visitorCreate($server, $frame)
    {
        //获取参数app_uuid
        $arr = $this->dataArr($frame);
        $app_uuid = $arr['app_uuid'];
        //根据规则生成user_id
        $app_arr=Application::where(['app_uuid'=>$app_uuid])->first();
        if($app_arr){
            $appOnlineUser =Redis::smembers("hello:app_id:user:" . ($app_arr->id));
            if (empty($appOnlineUser)){
                $user=User::where(['app_id'=>$app_arr->id,'role'=>1])->first();
                $user_id=$user->id;
            }else{
                $rand_keys = array_rand($appOnlineUser, 1);
                $user_id = $appOnlineUser[$rand_keys];
                $user=User::where(['id'=>$user_id])->first();
                dump('online');
                dump($user_id);
            }
        }else{
            $data="app_uuid not found";
            return $this->exceptionRequest($server,$frame,$data);
        }
        //生成vistor_id
        $visitor_id = (string)Uuid::generate();
        //入库
        Visitor::insert(
            [
                'app_uuid' => $app_uuid,
                'user_id' => $user_id,
                'visitor_id' => $visitor_id,
                'created_at' => now(),
                'visit_number' => 0,
                'unread_number' => 0,
            ]
        );
        //访客redis存储，访客在线添加
        $this->storeFd($visitor_id, $frame->fd);
        Redis::sadd("hello:app_id:visitor:" . ($app_arr->id), $visitor_id);
        $message = [
            'event' => 'visitorCreateSuccess',
            'data' => [
                'visitor_id' => $visitor_id,
                'user'=>[
                    'name' => $user->name,
                    'avatar' => $user->avatar
                ]
            ]
        ];
        $server->push($frame->fd, json_encode($message));
    }

    public function visitorConnect($server, $frame)
    {
        //获取参数app_id
        $arr = $this->dataArr($frame);
        $app_uuid = $arr['app_uuid'];
        $visitor_id = $arr['data']['visitor_id'];
        //根据app_uuid和visitor_id查询出user_id
        $result=Visitor::where([
            'app_uuid' => $app_uuid,
            'visitor_id' => $visitor_id,
        ])->first();
        if ($result) {
            $this->storeFd($visitor_id, $frame->fd);
            $message = [
                'event' => 'visitorConnectSuccess',
                'data' => [
                    'visitor_id' => $visitor_id,
                    'name' => $result->name,
                    'avatar' => $result->avatar,
                ]
            ];
            $server->push($frame->fd, json_encode($message));
        } else {
            //保留功能新应用在此处写代码（此处需要完善）
        }
    }

    public function userMessage($server, $frame)
    {
        $arr = $this->dataArr($frame);
        dump($arr);
        $user_id = auth('api')->setToken($arr['user_id'])->user()->id;

        Chat::insert([
            'user_id' => $user_id,
            'visitor_id' => $arr['visitor_id'],
            'content' => $arr['data']['content'],
            'agent' => Chat::AGENT_USER,
        ]);
        //转发给visitor
        $visitor_fd = Redis::get("hello:user_visitor:" . $arr['visitor_id']);
        dump($visitor_fd);
        $message = [
            'event' => 'messageReceived',
            'data' => [
                'content' => $arr['data']['content'],
            ]
        ];
        $visitor_fd = (int)$visitor_fd;
        $server->push($visitor_fd, json_encode($message));
    }

    public function visitorMessage($server, $frame)
    {
        $arr = $this->dataArr($frame);
        $result = Visitor::where(['app_uuid' => $arr['app_uuid'], 'visitor_id' => $arr['visitor_id']])->first();
        dump($result->user_id);


        Chat::insert([
            'user_id' => $result->user_id,
            'visitor_id' => $result->visitor_id,
            'content' => $arr['data']['content'],
            'agent' => Chat::AGENT_VISITOR,
        ]);


        $user_fd = Redis::get("hello:user_visitor:" . $result->user_id);
        $user_fd = (int)$user_fd;
        $message = [
            'event' => 'messageReceived',
            'data' => [
                'content' => $arr['data']['content'],
            ]
        ];
        $server->push($user_fd, json_encode($message));

    }
}

?>