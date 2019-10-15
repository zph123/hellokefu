<?php
/**
 * Created by PhpStorm.
 * User: bing
 * Date: 2019/10/10
 * Time: 15:43
 */


namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait ResultTrait
{

    /**
     * 成功消息统一响应
     *
     * @param JsonResource $data
     * @param int $status
     * @return JsonResponse
     */
    public function success(JsonResource $data = null, int $status = 200): JsonResponse
    {
        return $this->result($data, 'success', $status);
    }

    /**
     * 失败消息统一响应
     *
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    public function error(string $message = '', int $status = 500): JsonResponse
    {
        return $this->result(null, $message, $status);
    }

    /**
     * 统一响应结构体
     *
     * @param JsonResource|null $data
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    protected function result(JsonResource $data = null, string $message = 'ok', int $status = 200): JsonResponse
    {
        dump($data);die;
        $ret['message'] = $message;
        #$ret['status'] = $status;
        if (isset($data)) {
            $ret['data'] = $data;
        }
        if (isset($data['meta'])){
            $ret['meta'] = $data['meta'];
        }
        return response()->json($ret, $status);
    }
}