<?php 
namespace App\Exports;
 
use App\Models\Order;
use App\Models\Orderproducts;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
class DistributorExport implements FromCollection,WithHeadings,WithColumnWidths
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
            'Distributor Id',
            'Name of distributor',
            'Mobile number',
            // 'Area',
            'Address',
            // 'Address line 2',
            'City',
            'State',
            'Pincode',
            //Any change in the ordered item delivered
            //if yes, details of ordered items and delivered items
            'Value of the order',
            'No. of units empty jar accepted',
            'Date of order',
            'Date of delivered',
            //No of days taken to deliver
            //Sales executive responsible for this area
            //Rating for the order
            //Remarks while rating
            
        ];
    } 
    public function collection()
    {
        $order=Order::join('shipping_address','orders.id','=','shipping_address.order_id')
        ->join('users','orders.assigned_distributor','users.id')
        ->join('user_addresses','users.id','=','user_addresses.user_id')
        // ->join('users as delivery_user','orders.assigned_deliveryboy','delivery_user.id')
        ->join('order_products','orders.id','order_products.order_id')
        ->select('orders.id','orders.order_id','orders.assigned_distributor','users.name','users.phone','user_addresses.address','user_addresses.city'
        ,'user_addresses.state','user_addresses.zip_code',
        'order_products.amount', 'orders.returnablejar_qty',DB::raw('DATE_FORMAT(orders.created_at, "%d-%b-%Y") as formatted_request')
          ,'orders.O_delivery_date')->where('orders.assigned_deliveryboy','!=','')->where('users.user_type','!=','customer')->where('orders.status','Delivery')->groupBy('order_products.order_id');
         
          if(!empty($this->start_date) && !empty($this->end_date)){
          $order=$order->whereBetween('orders.delivery_date', [$this->start_date, $this->end_date]);
          }
          $orders=$order->get();
          foreach($orders as $order){
              $order_products=Orderproducts::where('order_id',$order->id)->Select(DB::raw('SUM(quantity) AS quantity'),DB::raw('SUM(returnablejar_qty) AS returnablejar_qty'),DB::raw('SUM(amount) AS amount'))->first();
              if(!empty($order_products)){
                  $order->amount=$order_products->amount;
                  $order->returnablejar_qty=$order_products->returnablejar_qty;
              }
          }

        return $orders;
    }
}