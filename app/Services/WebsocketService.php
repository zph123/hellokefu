<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Webpatser\Uuid\Uuid;

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
        //根据$app_uuid找到$app_id（此处需要完善）
        $app_id=$app_uuid;
        //根据规则生成user_id（此处需要完善）
        $user_id=1;
        //生成vistor_id
        $visitor_id=(string)Uuid::generate();
        $created_at = now();
        //入库
        DB::table('visitors')->insert(
            [
                'app_id' => $app_id,
                'user_id' => $user_id,
                'visitor_id'=>$visitor_id,
                'created_at'=>$created_at,
                'visit_number'=>0,
                'unread_number'=>0,
            ]
        );
        //redis
        Redis::set("hello_".$visitor_id, $frame->fd);
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
        $app_id=$arr['app_id'];
        $visitor_id=$arr['data']['visitor_id'];
        //根据app_id和visitor_id查询出user_id，如果没有再次入库
        $result=DB::table('visitors')->where(
            [
                'app_id' => $app_id,
                'visitor_id'=>$visitor_id,
            ]
        )->first();
        if($result){
            Redis::set("hello_".$visitor_id, $frame->fd);
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
}

?>