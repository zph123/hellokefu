<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Resources\VisitorResource;
use App\Models\Application;
use App\Models\Visitor;
use App\Services\UserService;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class VisitorController extends ApiController
{
    /**
     * 访客列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->success(VisitorResource::collection(Visitor::where('user_id', $this->user->id)->when(!empty($request->lasted_at), function ($query) {
            return $query->orderBy('lasted_at', SORT_DESC);
        })->orderBy('id', SORT_DESC)->paginate($this->perPage)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     *
     * @param Visitor $visitor
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Visitor $visitor)
    {
        return $this->success(new VisitorResource($visitor));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * 访客信息
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function mine(Request $request)
    {
        try {

            $request->validate([
                'app_uuid' => 'bail|required|uuid|exists:applications,app_uuid',
                'vid' => 'uuid'
            ]);

            $appUuid = $request->input('app_uuid', null);
            $visitorId = $request->input('vid', null);

            $app = Application::where(['app_uuid' => $appUuid])->first();
            // 直接分配给管理员-暂时这么写
            $admin = UserService::getAdminByAppId($app->id);

            if (is_null($visitorId)) {
                $visitor = Visitor::create([
                    'visitor_id' => (string)Uuid::generate(),
                    'user_id' => $admin->id,
                    'app_uuid' => $appUuid,
                    'ip' => $request->getClientIp(),
                    'user_agent' => 'user_agent'
                ]);
            } else {
                $visitor = Visitor::where(['visitor_id' => $visitorId, 'app_uuid' => $appUuid])->first();
            }
            return response()->json([
                'msg' => '',
                'code' => 0,
                'data' => [
                    // 访客
                    'mine' => [
                        "username"  => '访客:'.$visitor->id, //我的昵称
                        "visitor_id"    => $visitor->visitor_id,
                        "id" => $admin->id, //我的ID
                        "status" => "online", //在线状态 online：在线、hide：隐身
                        "remark" => "在深邃的编码世界，做一枚轻盈的纸飞机", //我的签名
                        "avatar" => "http://cdn.firstlinkapp.com/upload/2016_6/1465575923433_33812.jpg" //我的头像
                    ]
                ]
            ], 200);
        } catch (ApiException $e) {
            return response()->json([
                'msg' => $e->getMessage(),
                'code' => -1,
                'data' => []
            ]);
        }
    }
}
