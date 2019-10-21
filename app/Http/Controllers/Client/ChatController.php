<?php

namespace App\Http\Controllers\Client;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        try {
            $request->validate([
                'app_uuid' => 'bail|required|uuid|exists:applications,app_uuid',
            ]);

            $appUuid = $request->input('app_uuid', null);
            $app = Application::where(['app_uuid' => $appUuid])->first();


            return view('client.chat.index',['app_uuid'=>$appUuid]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
