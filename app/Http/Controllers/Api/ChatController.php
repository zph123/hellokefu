<?php
/**
 * Created by PhpStorm.
 * User: bing
 * Date: 2019/10/10
 * Time: 10:31
 */

namespace App\Http\Controllers\Api;


use App\Exceptions\ApiException;
use App\Http\Requests\ChatRequest;
use App\Http\Resources\ChatResource;
use App\Models\Chat;
use App\Models\Visitor;

class ChatController extends ApiController
{

    /**
     * 访客端聊天记录
     *
     * @param ChatRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function visitorChat(ChatRequest $request)
    {
        try {
            $visitorId = $request->input('visitor_id');
            $appUuid = $request->input('app_uuid', null);
            if (isset($appUuid)) {

                $visitor = Visitor::where(['app_uuid' => $appUuid, 'visitor_id' => $visitorId])->first();
                if (is_null($visitor)) {
                    throw new ApiException('Not found visitor', 500);
                }

                // 访客端聊天记录
                $chatLog = Chat::where(['visitor_id' => $visitorId, 'user_id' => $visitor->user_id])->orderBy('created_at', SORT_DESC)->paginate($this->perPage);
                return $this->success(ChatResource::collection($chatLog));
            }
            throw new ApiException('app_uuid is invalid');
        } catch (ApiException $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 客服端聊天记录
     *
     * @param ChatRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function serviceChat(ChatRequest $request)
    {
        try {
            $visitorId = $request->input('visitor_id');

            return $this->success(ChatResource::collection(Chat::where(['visitor_id', $visitorId, 'user_id' => $this->user->id])->orderBy('id', SORT_DESC)->paginate($this->perPage)->reverse()));

        } catch (ApiException $e) {
            return $this->error($e->getMessage());
        }
    }
}