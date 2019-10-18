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
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

trait ResultTrait
{

    /**
     * 成功消息统一响应
     *
     * @param JsonResource $data
     * @param int $status
     * @return JsonResponse
     */
    public function success(JsonResource $data = null, string $message = 'success', int $status_code = 200): JsonResponse
    {
        return $this->result($data, $message, $status_code);
    }

    /**
     * 失败消息统一响应
     *
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    public function error(string $message = '', int $status_code = 500): JsonResponse
    {
        return $this->result(null, $message, $status_code);
    }

    /**
     * 统一响应结构体
     *
     * @param JsonResource|null $data
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    protected function result(JsonResource $data = null, string $message = 'ok', int $status_code = 200): JsonResponse
    {
        if (is_null($data)) {
            return response()->json(compact('status_code', 'message'), $status_code);
        } else {
            // List With the page
            if ($data instanceof AnonymousResourceCollection) {
                $meta = [
                    'total' => $data->total(),
                    'per_page' => $data->perPage(),
                    'current_page' => $data->currentPage()
                ];
                return response()->json(compact('data', 'meta', 'message', 'status_code'), $status_code);
            } else {
                return response()->json(compact('data', 'message', 'status_code'), $status_code);
            }
        }
    }
}