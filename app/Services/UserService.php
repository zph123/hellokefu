<?php
/**
 * Created by PhpStorm.
 * User: bing
 * Date: 2019/10/19
 * Time: 17:20
 */

namespace App\Services;


use App\Models\User;

class UserService
{

    /**
     * 根据 APP ID 获取管理员
     *
     * @param $appId
     * @return mixed
     * @throws \Exception
     */
    static public function getAdminByAppId($appId)
    {
        try {
            $user = User::where('app_id', $appId)->role(User::ROLE_ADMIN)->first();
            if (is_null($user)) {
                throw new \Exception('User not found for by app uuid');
            }
            return $user;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 生成随机头像-临时用
     *
     * @return string
     */
    static public function generateAvatar($num = null)
    {
        $num = isset($num) ? $num : rand(1, 4);
        return '/images/user' . $num . '.png';
    }
}