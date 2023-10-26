<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
            'avatar' => $this->avatar ? asset('storage').'/'.$this->avatar : URL::to('images/splash-logo.png'),
            'model' => $this->model,
            'color' => $this->color,
            'numberplate' => $this->numberplate,
        ];
    }
}
