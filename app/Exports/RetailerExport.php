<?php 
namespace App\Exports;
 
use App\Models\Order;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
class RetailerExport implements FromCollection,WithHeadings,WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */ 
    protected $start_date;
    protected $end_date;

    function __construct($start_date,$end_date) {
           $this->start_date = $start_date;
           $this->end_date = $end_date;
    }
  public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 20,    
            'C' => 15,
            'D' =>20,
            'E' =>20,
            'F' =>20,
            'G' =>20,
            'H' =>20,
            'I' =>20,
            'J' =>20,
            'K' =>20,
            'L' =>20,
            'M' =>20,
            'N' =>20,
            'O' =>20,
            'P' =>20,
            'Q' =>20,
            'R' =>20,
            'E' =>20,
            'S' =>20,
            'T' =>20,
            'U' =>20,
            'V' =>20,
            'W' =>20,
        ];
    }
    public function headings():array{
        return[
            'Sl No',
            'Order Id',
            'Retailer Id',
            'Name of retailer',
            'Mobile number',
            // 'Area',
            'Address',
            // 'Address line 2',
            'City',
            'State',
            'Pincode',
            'Product Name',
            'No of units ordered',
            'Value of the order',
          
            'Total order value',
            'Date of order',
            'Date of delivered',
             //No of days taken to deliver
             'Delivery Id',
             'Delivered by',
            // 'Sales executive reponsible for this area',
            // 'rating for order',
            // 'Remarks while rating',
            // 'Search criteria',
            
        ];
    } 
    public function collection()
    {
        $order=Order::join('shipping_address','orders.id','=','shipping_address.order_id')->join('user_addresses','shipping_address.address_id','=','user_addresses.id')
        ->join('users','user_addresses.user_id','users.id')
        // ->join('users as delivery_user','orders.assigned_deliveryboy','delivery_user.id')
        ->join('order_products','orders.id','order_products.order_id')
        ->join('products','order_products.product_id','products.id')
        
        ->select('orders.id','orders.order_id','orders.customer_id','user_addresses.full_name','users.phone','user_addresses.address','user_addresses.city'
        ,'user_addresses.state','user_addresses.zip_code','products.name','order_products.quantity',
        'order_products.amount','orders.total',DB::raw('DATE_FORMAT(orders.created_at, "%d-%b-%Y") as formatted_request')
          ,'orders.O_delivery_date','orders.assigned_distributor','orders.assigned_distributor as d_user')
          ->where('orders.user_type','retailer')->where('orders.status','delivery');
          if(!empty($this->start_date) && !empty($this->end_date)){
          $order=$order->whereBetween('orders.delivery_date', [$this->start_date, $this->end_date]);
          }
          $orders=$order->get();
     foreach($orders as $order){
         $user=User::where('id',$order->assigned_distributor)->first();
         if(!empty($user)){
         $order->d_user=$user->name;
         }else{
            $order->d_user="Not assigned";  
         }
     }

        return $orders;
    }
}