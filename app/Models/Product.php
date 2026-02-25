<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','image','type','customer_price','retailer_price','customer_discount','distributor_discount','distributor_price','deleted','slug','size','description','quantity_per_case','deposit_amount','is_returnable','orderby','status'];
}
