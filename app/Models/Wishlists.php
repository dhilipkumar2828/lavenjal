<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlists extends Model
{
    use HasFactory;
    protected $table="wishlists";
    protected $fillable = ['customer_id','product_id','price','status','created_at','updated_at'];
}
