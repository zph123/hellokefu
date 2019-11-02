<?php
/**
 * Created by PhpStorm.
 * User: bing
 * Date: 2019/11/2
 * Time: 13:41
 */

namespace App\Services;


class EventService
{
    protected $redis;

    public function __construct(RedisService $redis)
    {
        $this->redis = $redis;
    }
}