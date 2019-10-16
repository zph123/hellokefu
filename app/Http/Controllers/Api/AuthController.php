<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Requests\UserRequest;
use App\Models\Application;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;


class AuthController extends ApiController
{

    /**
     * 客服登录
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
     * 获取客服信息
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
     * 客服退出
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * 客服管理员注册
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRequest $request)
    {
        try {
            DB::transaction(function () use ($request){

                $app = new Application();
                $app->app_uuid = (string) Uuid::generate();
                $app->save();

                $user = new User();
                $user->app_id   = $app->id;
                $user->name     = '管理员';
                $user->email    = $request->email;
                $user->password = bcrypt($request->password);
                $user->role     = User::ROLE_ADMIN;
                $user->save();

            },3);

            return response()->json(['message' => 'Register successfully']);

        } catch (ApiException $e) {
            return $this->error($e->getMessage(),500);
        }
    }
}
