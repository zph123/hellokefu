<?php

namespace App\Http\Controllers\Api;

use App\Http\Traits\ResultTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    use ResultTrait;

    public function __construct()
    {
        #$this->middleware('jwt.auth', ['except' => 'login']);
    }
}
