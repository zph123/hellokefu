<?php

namespace App\Http\Controllers\Api;

use App\Http\Traits\ResultTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    use ResultTrait;

    protected $perPage = 15;

    protected $user;

    public function __construct(Request $request)
    {
        if (empty($request->size)) {
            $this->perPage = $request->size;
        }

        if (auth('api')->check()) {
            $this->user = auth('api')->user();
        }

        #$this->middleware('jwt.auth', ['except' => 'login']);
    }
}
