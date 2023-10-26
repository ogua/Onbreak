<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PservicesResource extends JsonResource
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
            'prov_id' => $this->prov_id,
            'provname' => $this->provider->name,
            'avatar' => $this->provider ? asset('storage').'/'.$this->provider->logo : URL::to('images/splash-logo.png'),
            'name' => $this->name
        ];
    }
}
