<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     *
     */
    public function toArray($request)
    {
        return [
            'success' => true,
            'id' => $this->id,
            'name' => $this->name,
            'img' => $this->img ? asset('storage').'/'.$this->img : URL::to('images/logo.png'),
            'ptype' => $this->ptype,
            'amnt' => $this->amnt,
            'dscnt' => $this->dscnt,
            'desc' => $this->desc
        ];
    }
}
