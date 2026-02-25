<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sales_rep;
use App\Models\Owner_meta_data;
use App\Models\Order;
use Session;
use DB;
use File;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerExport;
use App\Exports\DistributorExport;
use App\Exports\RetailerExport;
use App\Exports\DeliverBoyExport;
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customer_report()
    {
       $orders=DB::table('orders')->join('users','users.id','=','orders.customer_id')->where('users.user_type','=','customer')->orderBy('orders.id','desc')->get(['orders.*','users.*','orders.status as order_status','users.id as user_id','orders.created_at as order_created']);

        foreach($orders as $key=>$order){
            $assign_distributor=Owner_meta_data::where('user_id',$order->customer_id)->first();
            $user=User::where('id',$order->assigned_deliveryboy)->first();
            $order->assigned_delivery=(!empty($user)?$user->name:'Not assigned');
        }
        return view('backend.reports.customer',compact('orders'));

    }
    
    
    public function get_reportlists(Request $request){
        
             $order_list=DB::table('orders')->join('users','users.id','=','orders.customer_id')->orderBy('orders.id','desc');
            
             if($request->user_type!="distributor"){
                 $order_list->where('users.user_type','=',$request->user_type);
             }else{
                 $order_list->where('users.user_type','!=',"customer");
             }
              if(!empty($request->start_date) && !empty($request->end_date)){
                 $order=$order_list->whereBetween('orders.delivery_date', [$request->start_date, $request->end_date]);
              }
              
              if(!empty($request->time_slot)){
                  $order=$order_list->where('delivery_time',$request->time_slot);
              }
             $orders=$order_list->get(['orders.*','users.*','orders.status as order_status','users.id as user_id','orders.created_at as order_created']);

        foreach($orders as $key=>$order){
            $assign_distributor=Owner_meta_data::where('user_id',$order->customer_id)->first();
            $user=User::where('id',$order->assigned_deliveryboy)->first();
            $order->assigned_delivery=(!empty($user)?$user->name:'Not assigned');
            
            if($request->user_type!="customer"){
                $user=User::where('id',$assign_distributor->assigned_distributor)->first();
                $order->assigned_distributor_name=$user->name;
            }
        } 
        if($request->user_type=="customer"){
           $table=view('backend.reports.table',['orders'=>$orders])->render();
        }else if($request->user_type=="retailer"){
          $table=view('backend.reports.retailer_table',['orders'=>$orders])->render();  
        }else if($request->user_type=="distributor"){
          $table=view('backend.reports.distributor_table',['orders'=>$orders])->render();    
        }else if($request->user_type=="delivery_agent"){
          $table=view('backend.reports.delivery_table',['orders'=>$orders])->render();    
        }
        return response()->json(['table'=>$table]);
    }
    
    
    
        public function get_customer_data(Request $request)
    {
        return Excel::download(new CustomerExport($request->start_date,$request->end_date,$request->time_slot), 'customer_reports.xlsx');
    }
    
        public function get_retailer_data(Request $request)
    {
        return Excel::download(new RetailerExport($request->start_date,$request->end_date), 'retailer_reports.xlsx');
    }
    
        public function get_deliveryboy_data(Request $request)
    {
        return Excel::download(new DeliverBoyExport($request->start_date,$request->end_date), 'deliveryboy_reports.xlsx');
    }
    
        public function get_distributor_data(Request $request)
    {
        return Excel::download(new DistributorExport($request->start_date,$request->end_date), 'distributor_reports.xlsx');
    }
    
    public function retailer_report()
        {
          $orders=DB::table('orders')->join('users','users.id','=','orders.customer_id')->where('orders.status','delivery')->where('users.user_type','=','retailer')->orderBy('orders.id','desc')->get(['orders.*','users.*','orders.status as order_status','users.id as user_id','orders.created_at as order_created']);
    
            foreach($orders as $key=>$order){
                $assign_distributor=Owner_meta_data::where('user_id',$order->customer_id)->first();
                $user=User::where('id',$assign_distributor->assigned_distributor)->first();
                $order->assigned_distributor_name=$user->name;
            }
    
            return view('backend.reports.retailer',compact('orders'));
    
        }
        
      public function delivery_boy_report()
        {
           $orders=DB::table('orders')->join('users','users.id','=','orders.customer_id')->where('orders.status','delivery')->where('users.user_type','=','delivery_agent')->orderBy('orders.id','desc')->get(['orders.*','users.*','orders.status as order_status','users.id as user_id','orders.created_at as order_created']);

        foreach($orders as $key=>$order){
            $assign_distributor=Owner_meta_data::where('user_id',$order->customer_id)->first();
            $user=User::where('id',$assign_distributor->assigned_distributor)->first();
            $order->assigned_distributor_name=$user->name;
        }
            return view('backend.reports.delivery_boy',compact('orders'));
    
        }
        
    public function distributor_report()
        {
           $orders=DB::table('orders')->join('users','users.id','=','orders.customer_id')->orderBy('orders.id','desc')->where('orders.status','delivery')->where('orders.user_type','!=','customer')->get(['orders.*','users.*','orders.status as order_status','users.id as user_id','orders.created_at as order_created']);
    
            foreach($orders as $key=>$order){
                $assign_distributor=Owner_meta_data::where('user_id',$order->customer_id)->first();
                if(!empty($assign_distributor)){
                $user=User::where('id',$assign_distributor->assigned_distributor)->first();
                }
                $order->assigned_distributor_name=isset($user)?$user->name:'Not assigned';
            }
           return view('backend.reports.distributor',compact('orders'));
        } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  
}
