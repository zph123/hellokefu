<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;


class AuthController extends ApiController
{

    /**
     * 管理员登录
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return $this->error('Unauthorized', 401);
        }
        return response()->json([
            'token' => $token,
            'expires' => auth('api')->factory()->getTTL() * 60,
        ]);
    }

    /**
     * 获取管理员信息
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        try {
            $admin = auth('api')->userOrFail();
            return response()->json($admin);
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return $this->error('User Not Found', 401);
        }

    }


    /**
     * 管理员退出
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
