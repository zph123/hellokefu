<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VisitorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'visitor_id'    => $this->visitor_id,
            'app_uuid'      => $this->app_uuid,
            'avatar'        => $this->avatar,
            'region'        => $this->region,
            'ip'            => $this->ip,
            'name'          => $this->name,
            'visit_number'  => $this->visit_number,
            'company'       => $this->company,
            'lasted_at'     => $this->lasted_at,
            'mobile'        => $this->mobile,
            'email'         => $this->email,
            'remark'        => $this->remark,
            'created_at'    => (string) $this->created_at,
            'updated_at'    => (string) $this->updated_at,
            'address'       => $this->address,
            'service'       => $this->user
        ];
    }
}
