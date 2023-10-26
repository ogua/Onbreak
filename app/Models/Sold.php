<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sold extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function sales()
    {
        return $this->hasMany(Sale::class,'billid','billid');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'receivedby','id');
    }
}
