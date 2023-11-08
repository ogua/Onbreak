<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;

class SproviderResource extends JsonResource
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
            'name' => $this->name,
            'logo' => $this->logo ? asset('storage').'/'.$this->logo : URL::to('images/splash-logo.png'),
            'loc' => $this->loc,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'contact' => $this->contact,
        ];
    }
}
