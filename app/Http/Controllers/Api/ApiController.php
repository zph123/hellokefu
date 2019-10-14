<?php

namespace App\Http\Controllers\Api;

use App\Http\Traits\ResultTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    use ResultTrait;

    protected $user;

    public function __construct()
    {
        $this->user = auth('api')->user();

        #$this->middleware('jwt.auth', ['except' => 'login']);
    }
}
