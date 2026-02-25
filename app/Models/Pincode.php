<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\City;
class Pincode extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table="pincodes";
    protected $guarded=[];
   // protected $fillable = ['name','image','type','customer_price','retailer_price','slug','size','description','quantity_per_case','deposit_amount','is_returnable','status'];
   
   public function cities(){
       return $this->hasOne(City::class,'id','city');
   }
}
