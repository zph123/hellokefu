<?php
/**
 * Created by PhpStorm.
 * User: bing
 * Date: 2019/11/2
 * Time: 12:05
 */

namespace App\Services;


use Illuminate\Support\Facades\Redis;

class RedisService
{

    protected $prefix = 'hello:';

    /**
     * 用户关系绑定
     *
     * @param string $userId
     * @param int|null $value
     * @return bool
     */
    public function userFd(string $userId, int $value = null): int
    {
        $key = $this->prefix . 'user:fd:' . $userId;
        if (isset($value)) {
            return Redis::set($key, $value);
        } else {
            return Redis::get($key);
        }
    }

    /**
     * 访客关系绑定
     *
     * @param string $vid
     * @param int|null $value
     * @return mixed
     */
    public function visitorFd(string $vid, int $value = null): int
    {
        $key = $this->prefix . 'visitor:fd:' . $vid;
        if (isset($value)) {
            return Redis::set($key, $value);
        } else {
            return Redis::get($key);
        }
    }

}