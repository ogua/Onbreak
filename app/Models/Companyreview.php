<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companyreview extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function provider()
    {
        return $this->belongsTo(Sprovider::class,'prvider_id','user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
