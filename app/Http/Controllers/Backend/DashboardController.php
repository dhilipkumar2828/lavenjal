<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Notifications;
use App\Models\Product;
use Helper;
use App\Models\Carts;
use App\Models\Sales_rep;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use Pusher\Pusher;
use App\Events\NewEvent;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     private static function live_notification(){
        //   $options = array(
        //     'cluster' => 'ap2',
        //     'useTLS' => true
        //   );
        //   $pusher = new Pusher(
        //     '3cb8fd24827957fe7f59',
        //     '90125215be51dcb483ef',
        //     '1594049',
        //     $options
        //   );
        
        //   $data=[];
        //   $pusher->trigger('my-channel', 'my-event', $data);
        //   return false;
} 

private function view_allnotification($value){
          $notifications_val=\App\Models\Notifications::where('status','read')->orderBy('id','desc');
          if($value=="limit"){
            $notifications_val->limit('10');
          }
          $notifications=$notifications_val->get();

    foreach($notifications as $notification){
            $order=\App\Models\Order::where('id',$notification->order_id)->orderBy('id','desc')->first();
            $user_order=\App\Models\Order::first();
            if(!empty($order)){
                $user=\App\Models\User::where('id',$order->customer_id)->first();
                $user_name=(!empty($user->name) ? $user->name : "");
                $user_img=(!empty($user->user_img) ? $user->user_img : "backend/assets/images/avatars/lavenjal-user.png");
            }else{
                $user_name=(!empty($user->name) ? $user->name : "");
                if(!empty($user_order)){
                  $user=\App\Models\User::where('id',$notification->user_id)->first();
                 }
                else{
                  $user="";
                }
                $user_name=(!empty($user)?$user->name:"");
                $user_img=(!empty($user->user_img) ? $user->user_img : "backend/assets/images/avatars/lavenjal-user.png");
            }
            $notification->user_name=$user_name;
            $notification->user_img=$user_img;
    }
// Helper::live_notification();

    $notification_render=view('backend.notifications',['notifications'=>$notifications])->render();
    $count_noty=Notifications::where('status','read')->count();
    return response()->json(['success'=>"Notifications updated successfully",'notification_render'=>$notification_render,'count_noty'=>$count_noty,'notifications'=>$notifications]);
}
    public function index()
    {
     
    

  
  //  return response()->json(['success'=>"Notifications updated successfully",'notification_render'=>$notification_render,'count_noty'=>$count_noty]);
// event(new NewEvent("kvrahul2018@gmail.com"));
//   $options = array(
//     'cluster' => 'ap2',
//     'useTLS' => true
//   );
//   $pusher = new Pusher(
//     'bcb9e6385bb7056a42f2',
//     '026f1c429941d5950442',
//     '1588803',
//     $options
//   );

//   $data['message'] = 'hello world';
//   $pusher->trigger('my-channel', 'my-event', $data);

        return view('backend.dashboard');
    }

public function update_notifications(Request $request){
    
    $notification=Notifications::where('status','read');
    if($request->type!="clear_all"){
      $notification->where('id',$request->id);  
    }
    $notification->update(['status'=>'write']);
    $notifications_val=\App\Models\Notifications::where('status','read')->orderBy('id','desc');
      if($request->view_type=="limit"){
            $notifications_val->limit('10');
          }
          $notifications=$notifications_val->get();

    foreach($notifications as $notification){
            $order=\App\Models\Order::where('id',$notification->order_id)->orderBy('id','desc')->first();
            $user_order=\App\Models\Order::first();
            if(!empty($order)){
                $user=\App\Models\User::where('id',$order->customer_id)->first();
                $user_name=(!empty($user->name) ? $user->name : "");
                $user_img=(!empty($user->user_img) ? $user->user_img : "backend/assets/images/avatars/lavenjal-user.png");
            }else{
                $user_name=(!empty($user->name) ? $user->name : "");
                if(!empty($user_order)){
                  $user=\App\Models\User::where('id',$notification->user_id)->first();
                 }
                else{
                  $user="";
                }
                $user_name=(!empty($user)?$user->name:"");
                $user_img=(!empty($user->user_img) ? $user->user_img : "backend/assets/images/avatars/lavenjal-user.png");
            }
            $notification->user_name=$user_name;
            $notification->user_img=$user_img;
    }

    $notification_render=view('backend.notifications',['notifications'=>$notifications])->render();
     $count_noty=Notifications::where('status','read')->count();
Helper::live_notification();
    return response()->json(['success'=>"Notifications updated successfully",'notification_render'=>$notification_render,'count_noty'=>$count_noty]);
}

public function pusher_notification(Request $request){
        $result=$this->view_allnotification("limit");
        return $result;
}
  public function push_notification()
    {
        return view('backend.push_notification');
    }
  
    public function storeToken(Request $request)
    {
        // $user=Auth::user();
        //         if(empty($user->device_key)){ 
        //                 $token_array=array($request->token);
        //         }else{
        //             $token=array($request->token);
        //             $device_key=json_decode($user->device_key);
           
        //             $token_arr=array_merge($device_key,$token);
        //             //  print_r($device_key);

        //             $token_array=array_unique($token_arr);
    
        //         }
        // $token=$token_array;

        // auth()->user()->update(['device_key'=>json_encode($token)]);
        // return response()->json(['Token successfully stored.']);
        
        
           auth()->user()->update(['unique_id'=>$request->token]);
        return response()->json(['Token successfully stored.']);
    }
    
    
     public function sendWebNotification(Request $request)
    {        
         
        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken = User::where('id',1836)->pluck('device_key')->all();
          
        $serverKey = 'AAAAQzeo7ZA:APA91bG8HRtKvIgfdqS2gUf99ks7Phb5pDyMKuMxkxwuksBaEe0qVB2kM5oVzm7IbKGfvhbEPTrWi0vcDZiV-TeFmzy6BYmZhMylaFL3S74I1NyGZ6JtmZZK965S-WP2d0jq1cFqbMbR';
  
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
            ]
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
        curl_close($ch);
        // FCM response
        dd($result);        
           
    }
    
         
    //QR code cart add
    
    public function QrCode_cartView(Request $request,$id){
      $userid = Helper::encrypt_decrypt('decrypt', $id);
      $products=Product::where('status','active')->get();
      $totalamount=Carts::select(DB::raw('SUM(price * product_qty) AS price'))->where('customer_id',$userid)->first();

      return view('backend.qrcode.view',compact('products','userid','totalamount'));
    }
    
    public function QrCode_cartSave(Request $request){
        $cart=Carts::where('customer_id',$request->user_id)->where('product_id',$request->product_id)->first();
        $product_price=Product::select('customer_price','id','name')->where('id',$request->product_id)->first();
        if(empty($cart)){
          $cart=new Carts;
          $cart->product_id=$request->product_id;
          $cart->customer_id=$request->user_id;
          $cart->product_qty=$request->product_qty;
          $cart->price=$product_price->customer_price;
          $cart->product_name=$product_price->name;
          $cart->deposit_amount=0.00;
          $cart->status="active";
          $cart->save();
        }else{
          $cart=Carts::where('customer_id',$request->user_id)->where('product_id',$request->product_id)->update(['product_qty'=>$request->product_qty]);  
        }
        $totalamount=Carts::select(DB::raw('SUM(price * product_qty) AS price'))->where('customer_id',$request->user_id)->first();
        return response()->json(['totalamount'=>$totalamount]);
    }
    
    public function view_notifications(Request $request){
        $result=$this->view_allnotification("view_all");
        return $result; 
    }
    
    public function salepwd(){
        $sales=Sales_rep::all();
        foreach($sales as $s){
            Sales_rep::where('id',$s->id)->update(['password'=> Hash::make($s->phone)]);
        }
    }

}
