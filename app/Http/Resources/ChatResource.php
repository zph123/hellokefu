<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
//            'visitor_id'    => $this->visitor_id,
            'user' => [
                'name' => $this->user->name,
                'avatar' => $this->user->avatar
            ],
            'visitor' => [
                'visitor_id' => $this->visitor->visitor_id,
                'name' => $this->visitor->name,
                'avatar' => $this->visitor->avatar
            ],
            'content' => $this->content,
            'agent' => $this->agent,
            'received_at' => (string)$this->received_at,
            'created_at' => (string)$this->created_at
        ];
    }
}
