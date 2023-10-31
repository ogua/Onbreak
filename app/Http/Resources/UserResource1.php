<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->username,
            'name' => $this->name,
            'avatar' => $this->avatar ? $this->avatar : URL::to('images/splash-logo.png'),
            'role' => $this->role,
            'contact' => $this->contact
        ];
    }
}
