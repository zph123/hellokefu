<?php

namespace App\Http\Controllers\Api;

use App\Http\Traits\ResultTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    use ResultTrait;

    protected $perPage;

    protected $user;

    public function __construct(Request $request)
    {
        $this->perPage = $request->size;

        $this->user = auth('api')->user();

        #$this->middleware('jwt.auth', ['except' => 'login']);
    }
}
