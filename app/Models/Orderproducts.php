<?php



namespace App\Models;

use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class Orderproducts extends Model

{

    use HasFactory;
    protected $table="order_products";
    protected $fillable=['order_id','product_id','customer_id','quantity','amount','no_of_jars_returned','status','cancellation_fee','returnablejar_qty','total_amount'];



public function product(){
    return $this->hasMany(Product::class,'id','product_id');
}
}

