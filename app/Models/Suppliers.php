<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function supplyproducts()
    {
        return $this->hasMany(Supplierproduct::class,'supplier_id');
    }
}
