<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable=['order_id','customer_id','product_id','sub_total','payment_id','user_type','O_delivery_date','O_delivery_time','assigned_deliveryboy','payment_status','deliver_charge','assigned_distributor','returnablejar_qty','deposit_amount','discount_amount','quantity','total','tax_rate','delivery_date','on_the_way_date','cancelled_date','delivery_time','status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

