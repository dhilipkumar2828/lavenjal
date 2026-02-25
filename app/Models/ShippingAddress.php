<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;
    protected $table="shipping_address";
    protected $fillable = ['order_id','address_id','status','created_at','updated_at'];
}
