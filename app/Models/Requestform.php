<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requestform extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function provider()
    {
        return $this->belongsTo(Sprovider::class,'prvider_id','user_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class,'vehicle_id');
    }

    public function servce()
    {
        return $this->belongsTo(Pservices::class,'prvider_id','uniqueid');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
