<?php
/**
 * Created by PhpStorm.
 * User: bing
 * Date: 2019/11/2
 * Time: 14:11
 */

namespace App\Services;


use App\Exceptions\ApiException;
use App\Models\Visitor;

class VisitorService
{

    /**
     * 根据 VisitorId 换 UserId
     *
     * @param $visitorId
     * @return mixed
     * @throws ApiException
     */
    static public function getUserIdByVisitorId(string $visitorId): int
    {
        try {
            $visitor = Visitor::select('user_id')->where(['visitor_id' => $visitorId])->first();
            if (is_null($visitor)) {
                throw new ApiException('Visitor not found.');
            }
            return $visitor->user_id;
        } catch (ApiException $e) {
            throw $e;
        }
    }

}