<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','ordered'];

    public function orderitem()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id', 'id');
    }

    public function address()
    {
        return $this->hasOne('App\Models\Address', 'id', 'address_id');
    }
}
