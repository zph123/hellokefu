<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\VisitorResource;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends ApiController
{
    /**
     * 访客列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->success(VisitorResource::collection(Visitor::orderBy('id',SORT_DESC)->paginate($this->perPage)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     *
     * @param Visitor $visitor
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Visitor $visitor)
    {
        return $this->success(new VisitorResource($visitor));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
