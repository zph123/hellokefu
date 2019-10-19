<?php
namespace App\Services;

use App\Http\Resources\VisitorResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Webpatser\Uuid\Uuid;
use App\Models\Visitor;

class WebsocketService
{

    public function __construct()
    {

    }

    public function  visitorCreate($server,$frame){
        //获取参数app_id
        $data=$frame->data;
        $arr=json_decode($data,true);
        $app_uuid=$arr['app_uuid'];
        //根据$app_uuid验证
        //根据规则生成user_id（此处需要完善）
        $user_id=1;
        //生成vistor_id
        $visitor_id=(string)Uuid::generate();
        $created_at = now();
        //入库
        Visitor::insert(
           [
               'app_uuid' => $app_uuid,
               'user_id' => $user_id,
               'visitor_id'=>$visitor_id,
               'created_at'=>$created_at,
               'visit_number'=>0,
               'unread_number'=>0,
           ]
        );
        //redis
        Redis::set("hello:user_visitor:".$visitor_id, $frame->fd);
        Redis::set("hello:fd:".($frame->fd),$visitor_id);
        $message=[
            'from'=>$arr['from'],
            'to'=>$arr['to'],
            'event'=>'visitorCreateSuccess',
            'data'=>[
                'visitor_id'=>$visitor_id,
                'user_id' => $user_id,
            ]
        ];
        $server->push($frame->fd,  json_encode($message));
    }

    public function  visitorConnect($server,$frame){
        //获取参数app_id
        $data=$frame->data;
        $arr=json_decode($data,true);
        $app_uuid=$arr['app_uuid'];
        $visitor_id=$arr['data']['visitor_id'];
        //根据app_uuid和visitor_id查询出user_id，如果没有再次入库
        $result=DB::table('visitors')->where(
            [
                'app_uuid' => $app_uuid,
                'visitor_id'=>$visitor_id,
            ]
        )->first();
        if($result){
            Redis::set("hello:user_visitor:".$visitor_id, $frame->fd);
            Redis::set("hello:fd:".($frame->fd),$visitor_id);
            $user_id=$result->user_id;
            $message=[
                'from'=>$arr['from'],
                'to'=>$arr['to'],
                'event'=>'visitorConnectSuccess',
                'data'=>[
                    'visitor_id'=>$visitor_id,
                    'user_id' => $user_id,
                ]
            ];
            $server->push($frame->fd,  json_encode($message));
        }else{
            //保留功能新应用在此处写代码（此处需要完善）
        }
    }
    public function userConnect($server,$frame){
        $data=$frame->data;
        $arr=json_decode($data,true);
//        dump($arr);
        $user_id=auth('api')->setToken($arr['hello_token'])->user()->id;
        Redis::set("hello:user_visitor:".$user_id, $frame->fd);
        Redis::set("hello:fd:".($frame->fd),$user_id);
    }
    public function userMessage($server,$frame){
        $data=$frame->data;
        $arr=json_decode($data,true);
        dump($arr);
        $user_id=auth('api')->setToken($arr['user_id'])->user()->id;
        $insert_data['user_id']=$user_id;
        $insert_data['visitor_id']=$arr['visitor_id'];
        $insert_data['content']=$arr['data']['content'];
        $insert_data['agent']=$arr['agent'];
        DB::table('chats')->insert($insert_data);
        //转发给visitor
        $visitor_fd=Redis::get("hello:user_visitor:".$arr['visitor_id']);
        dump($visitor_fd);
        $message=[
            'event'=>'messageReceived',
            'data'=>[
                'content'=>$arr['data']['content'],
            ]
        ];
        $visitor_fd=(int)$visitor_fd;
        $server->push($visitor_fd,  json_encode($message));


    }
}

?>