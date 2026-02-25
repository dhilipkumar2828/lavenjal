<?php 
namespace App\Exports;
 
use App\Models\Order;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
class CustomerExport implements FromCollection,WithHeadings,WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */ 
    protected $start_date;
    protected $end_date;
    protected $time_slot;
 
    function __construct($start_date,$end_date,$time_slot) {
           $this->start_date = $start_date;
           $this->end_date = $end_date;
           $this->time_slot=$time_slot;
           
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
            'Customer Id',
            'Name of customer',
            'Mobile number',
            // 'Area',
            // 'Floor no',
            // 'Is lift available',
            'Address',
            // 'Address line 2',
            'City',
            'State',
            'Pincode',
            'Product Name',
            'No of products ordered',
            'Value of the order',
            'No. of returned jar',
            'Deposit Amount',
             'Discount Amount',
            'Total Amount',
            'Date of order',
            'Date of delivered','
            Time slot selected',
            'Time of delivery',
            'Delivery Partner id',
            'Delivery Partner name',
            'Mode of payment',
            // 'rescheduled order ? yes or no',
            // 'if yes, earlier order ID',
            // 'payment reference number',
            // 'Sales executive reponsible for this area',
            // 'rating for order',
            // 'Remarks while rating',
            // 'Search criteria',
            
        ];
    } 
    public function collection()
    {
        $order=Order::join('order_products','orders.id','order_products.order_id')->join('shipping_address','orders.id','=','shipping_address.order_id')->join('user_addresses','shipping_address.address_id','=','user_addresses.id')
        ->join('users','user_addresses.user_id','users.id')
        // ->join('users as delivery_user','orders.assigned_deliveryboy','delivery_user.id')

        ->join('products','order_products.product_id','products.id')
        
        ->select('orders.id','orders.order_id','orders.customer_id','users.name as u_name','users.phone','user_addresses.address','user_addresses.city'
        ,'user_addresses.state','user_addresses.zip_code','products.name','order_products.quantity',
        'order_products.amount','order_products.returnablejar_qty','orders.deposit_amount','orders.discount_amount','orders.total',DB::raw('DATE_FORMAT(orders.created_at, "%d-%b-%Y") as formatted_request')
          ,'orders.O_delivery_date','orders.delivery_time','orders.O_delivery_time','orders.assigned_deliveryboy','users.id as d_user','orders.payment_type')
          ->where('orders.user_type','customer');
          if(!empty($this->start_date) && !empty($this->end_date)){
          $order=$order->whereBetween('orders.delivery_date', [$this->start_date, $this->end_date]);
          }
       
          if(!empty($this->time_slot)){
          
              $order=$order->where('orders.delivery_time',$this->time_slot);
          }
          $orders=$order->get();

     foreach($orders as $order){
         $user=User::where('id',$order->assigned_deliveryboy)->first();
         if(!empty($user)){
         $order->d_user=$user->name;
         }else{
          $order->d_user="Not assigned";   
         }
     }

        return $orders;
    }
}