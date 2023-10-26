<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestformResource extends JsonResource
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
            'username' => $this->user->name,
            'userimg' => $this->user ? $this->user->avatar : URL::to('images/splash-logo.png'),
            'prvider_id' => $this->prvider_id,
            'service' => $this->service,
            'name' => $this->provider->name,
            'prv_id' => $this->provider->id,
            'servicename' => $this->servce->name,
            'avatar' => $this->provider ? asset('storage').'/'.$this->provider->logo : URL::to('images/splash-logo.png'),
            'note' => $this->note,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'status' => $this->status,
            'vehicle_id' => $this->vehicle_id,
            'vehicle_name' => $this->vehicle->name ?? ""
        ];
    }
}
