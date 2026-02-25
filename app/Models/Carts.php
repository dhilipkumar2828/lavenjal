<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    use HasFactory;
    protected $table="carts";
    protected $fillable = ['customer_id','product_id','product_name','product_qty','discount_amount','price','status','no_of_jars_returned','returnablejar_qty','delivery_charges','deposit_amount','created_at','updated_at'];
}
