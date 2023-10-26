<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;

class CartResource extends JsonResource
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
            'id' => $this->id,
            'appid' => $this->appid,
            'name' => $this->product->name,
            'img' => $this->product->img ? asset('storage').'/'.$this->product->img : URL::to('images/splash-logo.png'),
            'ptype' => $this->product->ptype,
            'price' => 'Gh¢'.$this->price,
            'qty' => $this->qty,
            'dscnt' => $this->dscnt,
            'total' => 'Gh¢'.$this->total,
            'date' => $this->date
        ];
    }
}
