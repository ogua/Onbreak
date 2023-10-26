<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyreviewResource extends JsonResource
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
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'user_logo' => $this->user ? $this->user->avatar : URL::to('images/splash-logo.png'),
            'prvider_id' => $this->prvider_id,
            'name' => $this->provider->name,
            'avatar' => $this->provider ? asset('storage').'/'.$this->provider->logo : URL::to('images/splash-logo.png'),
            'rate' => $this->rate,
            'note' => $this->note
        ];
    }
}
