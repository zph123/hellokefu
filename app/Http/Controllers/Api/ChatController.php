<?php
/**
 * Created by PhpStorm.
 * User: bing
 * Date: 2019/10/10
 * Time: 10:31
 */

namespace App\Http\Controllers\Api;


use App\Http\Requests\ChatRequest;
use App\Http\Resources\ChatResource;
use App\Models\Chat;

class ChatController extends ApiController
{

    /**
     * 聊天记录
     *
     * @param ChatRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ChatRequest $request)
    {
        return $this->success(ChatResource::collection(Chat::where('visitor_id', $request->vid)->orderBy('id', SORT_DESC)->paginate($this->perPage)));
    }
}