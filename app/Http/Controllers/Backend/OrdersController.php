<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\User_address;
use App\Models\ShippingAddress;
use DB;
use Session;
use App\Models\Orderproducts;
use App\Models\Owner_meta_data;
use App\Models\Sales_rep;
class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private function map($delivery_lat, $delivery_lang, $distributor_lat, $distributor_lang)
    {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $delivery_lat . "," . $delivery_lang . "&destinations=" . $distributor_lat . "," . $distributor_lang . "&mode=driving&language=pl-PL&key=AIzaSyAMWBCScrGIa5WPe9VB39Kiz_ER7M363uM";
        //   $dist='';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        $response_a = json_decode($response, true);
        if (isset($response_a['rows'][0]['elements'][0]['distance']['text'])) {
            $m = $response_a['rows'][0]['elements'][0]['distance']['text'];
        } else {
            $m = 0;
        }

        return $m;
    }

    public function index()
    {
        return view('backend.orders.index');

    }

    public function view()
    {

        return view('backend.orders.view');
    }

    public function delivery()
    {

        return delivery('backend.orders.view_delivery');
    }



    public function customermap(Request $request, $id)
    {
        $address = User_address::where('id', $id)->first();
        return view('backend.orders.map', ['address' => $address]);
    }

    public function customerorder(Request $request, $id)
    {
        $nearbydelivery = Owner_meta_data::get();

        $order = Order::where('order_id', $id)->first();
        $shipping_address = ShippingAddress::where('order_id', $order->id)->first();
        $address = User_address::where('id', $shipping_address->address_id)->withTrashed()->first();

        // $Dname=array();
        // foreach($nearbydelivery as $d){
        //     $dist=$this->map($d->lat,$d->lang,$address->lat,$address->lang);
        //      $kms=str_replace(',','.',$dist);
        //       $whatIWant = substr($kms, strpos($kms, " ") + 1); 
        //     if($whatIWant=="km"){
        //       $kms=str_replace('km','',$kms);  
        //     }else{
        //         $kms=str_replace('m','',$kms);
        //         $kms=$kms/1000;
        //     }
        //     if((number_format($kms,2))<=5.0){
        //         array_push($Dname,$d->name_of_shop);

        //     }
        // }
        // dd($Dname);



        if (!empty($order)) {
            $assigned_distributor = Owner_meta_data::withTrashed()->where('user_id', $order->customer_id)->first();
            $customer = User::withTrashed()->where('id', $order->customer_id)->first();

            $assigned_salesrep = Owner_meta_data::withTrashed()->where('user_id', $order->customer_id)->first();
            if ($order->user_type == "customer") {
                $delivery_boy = User::withTrashed()->where('id', $order->assigned_deliveryboy)->first();
                $A_del = Owner_meta_data::withTrashed()->where('user_id', $order->assigned_deliveryboy)->first();
            } else {
                $delivery_boy = User::withTrashed()->where('id', $order->assigned_distributor)->first();
                $A_del = Owner_meta_data::withTrashed()->where('user_id', $order->assigned_distributor)->first();
            }

            $order_details = Orderproducts::where('order_id', $order->id)->get();

            $subtotal = 0;
            foreach ($order_details as $order_detail) {
                $subtotal += $order_detail->total_amount;
                $product = Product::where('id', $order_detail->product_id)->first();
                if (!empty($product)) {
                    $order_detail->product_name = $product->name;
                    $order_detail->product_image = $product->image;
                }
            }

            return view('backend.orders.customer-order', compact('order', 'customer', 'order_details', 'subtotal', 'delivery_boy', 'address', 'A_del'));
        } else {
            return redirect('');
        }
    }
    public function retailerorder()
    {

        return view('backend.orders.retailer-order');
    }
    public function deliveryorders()
    {

        return view('backend.orders.deliveryboy-order');
    }
    public function resheduled()
    {

        return view('backend.orders.resheduled');
    }
    public function canceled()
    {

        return view('backend.orders.canceled');
    }



    public function customerorderlist(Request $request)
    {

        $orders = DB::table('orders')->join('users', 'users.id', '=', 'orders.customer_id')->where('users.user_type', '=', 'customer')
            // ->orderBy('orders.delivery_date','desc')
            ->orderBy('orders.id', 'desc')
            ->where('orders.status', 'Order placed');

        if (!empty($request->start_date) && !empty($request->end_date)) {

            $orders = $orders->whereBetween('delivery_date', [$request->start_date, $request->end_date]);
        }
        if (!empty($request->time_slot)) {
            $orders = $orders->where('delivery_time', $request->time_slot);
        }
        $orders = $orders->get(['orders.*', 'users.*', 'orders.status as order_status', 'users.id as user_id', 'orders.created_at as order_created']);
        foreach ($orders as $key => $order) {
            $assign_distributor = Owner_meta_data::where('user_id', $order->customer_id)->first();
            $user = User::where('id', $order->assigned_deliveryboy)->first();
            $order->assigned_delivery = (!empty($user) ? $user->name : 'Not assigned');
        }
        return view('backend.orders.customerorderlist', ['orders' => $orders, 'start_date' => $request->start_date, 'end_date' => $request->end_date, 'time_slot' => $request->time_slot]);
    }

    public function retailerorderlist(Request $request)
    {
        $orders = DB::table('orders')->join('users', 'users.id', '=', 'orders.customer_id')->where('users.user_type', '=', 'retailer')
            ->orderBy('orders.id', 'desc')
            ->where('orders.status', 'Order placed')->get(['orders.*', 'users.*', 'orders.status as order_status', 'users.id as user_id', 'orders.created_at as order_created']);

        foreach ($orders as $key => $order) {
            $assign_distributor = Owner_meta_data::where('user_id', $order->customer_id)->first();
            if (!empty($assign_distributor)) {
                $user = User::where('id', $assign_distributor->assigned_distributor)->first();
            } else {
                $user['name'] = "";
            }
            $order->assigned_distributor_name = (!empty($user) ? $user->name : "");
        }

        return view('backend.orders.retailer-order-list', compact('orders'));
    }
    public function deliveryboyorderlist()
    {
        $orders = DB::table('orders')->join('users', 'users.id', '=', 'orders.customer_id')->where('users.user_type', '=', 'delivery_agent')->orderBy('orders.id', 'desc')->where('orders.status', 'Order placed')->get(['orders.*', 'users.*', 'orders.status as order_status', 'users.id as user_id', 'orders.created_at as order_created']);

        foreach ($orders as $key => $order) {
            $assign_distributor = Owner_meta_data::where('user_id', $order->customer_id)->first();

            if (!empty($assign_distributor)) {

                $user = User::where('id', $assign_distributor->assigned_distributor)->first();
            } else {
                $user['name'] = "";
            }
            $order->assigned_distributor_name = (!empty($user) ? $user->name : "");
        }

        return view('backend.orders.deliveryboy-order-list', compact('orders'));
    }

    public function distributororderlist()
    {
        $orders = DB::table('orders')->join('users', 'users.id', '=', 'orders.customer_id')->orderBy('orders.id', 'desc')->where('orders.status', 'Order placed')->where('orders.user_type', '!=', 'customer')->get(['orders.*', 'users.*', 'orders.status as order_status', 'users.id as user_id', 'orders.created_at as order_created']);

        foreach ($orders as $key => $order) {
            $assign_distributor = Owner_meta_data::where('user_id', $order->customer_id)->first();
            if (!empty($assign_distributor)) {
                $user = User::where('id', $assign_distributor->assigned_distributor)->first();
            }
            $order->assigned_distributor_name = isset($user) ? $user->name : 'Not assigned';
        }
        return view('backend.orders.distributor-order-list', compact('orders'));
    }

    public function order_details(Request $request)
    {

        if ($request->user_type != "distributor") {
            $orders = DB::table('orders')->join('users', 'users.id', '=', 'orders.customer_id')->where('users.user_type', '=', $request->user_type)->orderBy('orders.id', 'desc')->where('orders.status', $request->order_status);
        } else {
            // $orders=DB::table('orders')->join('users','users.id','=','orders.customer_id')->orderBy('orders.id','desc')->where('orders.status','Order placed')->where('orders.user_type','!=','customer')->get(['orders.*','users.*','orders.status as order_status','users.id as user_id','orders.created_at as order_created']);

            $orders = DB::table('orders')->join('users', 'users.id', '=', 'orders.customer_id')->where('orders.user_type', '!=', 'customer')->orderBy('orders.id', 'desc')->where('orders.status', $request->order_status);
        }


        if (!empty($request->start_date) && !empty($request->end_date)) {

            $orders = $orders->whereBetween('delivery_date', [$request->start_date, $request->end_date]);
        }
        if (!empty($request->time_slot)) {
            $orders = $orders->where('delivery_time', $request->time_slot);
        }

        $orders = $orders->get(['users.*', 'orders.*', 'orders.status as order_status']);

        foreach ($orders as $key => $order) {
            if ($order->delivery_date == null) {
                $order->delivery_date = "";
            }
            $assign_distributor = Owner_meta_data::where('user_id', $order->customer_id)->first();
            if ($order->user_type == "customer") {
                $user = User::where('id', $order->assigned_deliveryboy)->first();
            } else {
                $user = User::where('id', $order->assigned_distributor)->first();
            }
            $order->assigned_delivery = (!empty($user) ? $user->name : 'Not assigned');
        }
        return response()->json(['orders' => $orders]);
    }
    public function order_status(Request $request)
    {
        $validate = $request->validate([
            'status' => 'required',
        ]);

        Order::where('id', $request->order_id)->update(['status' => $request->status]);


        $check_status = Order::where('id', $request->order_id)->first();

        if (!empty($check_status)) {
            $c_no_of_ordered = 0;
            $c_no_of_jars_returned = 0;

            $order_products = OrderProducts::where('customer_id', $check_status->customer_id)->get();

            foreach ($order_products as $p) {
                $order = Order::where('id', $p->order_id)->first();
                $product = Product::where('id', $p->product_id)->first();

                if ($product->type == "jar") {
                    if ($order->status == "Delivery") {
                        $c_no_of_ordered += $p->quantity;
                    }
                    $c_no_of_jars_returned += $p->no_of_jars_returned;
                }
            }
            User::where('id', $check_status->customer_id)->update(['returnablejar_qty' => $c_no_of_ordered - $c_no_of_jars_returned]);
        }


        Session::flash('message', 'Order status updated');
        return redirect()->back();
    }

    public function user_address()
    {
        $users = User_address::where('floor_no', NULL)->orWhere('floor_no', '')->get();
        $arr = array();
        $a = 0;
        foreach ($users as $user) {
            $u = User::where('id', $user->user_id)->first();
            if (!empty($u)) {
                if ($u->user_type = "customer") {
                    $a += 1;
                }
            }
        }
        dd($a);
    }
}
