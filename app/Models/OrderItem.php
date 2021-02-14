<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    public function pro()
    {
        return $this->hasOne('App\Models\Product','id','product_id');
    }
}
