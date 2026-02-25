<?php
namespace App\helpers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Order;
use Pusher\Pusher;
use Auth;
use App\Models\ShippingAddress;
use App\Models\Owner_meta_data;
use App\Models\User_address;
use Notification;
use DB;

use App\Notifications\SendPushNotification;

class Helper{

   
       public static function map($delivery_lat,$delivery_lang,$distributor_lat,$distributor_lang){
                            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$delivery_lat.",".$delivery_lang."&destinations=".$distributor_lat.",".$distributor_lang."&mode=driving&language=pl-PL&key=AIzaSyAMWBCScrGIa5WPe9VB39Kiz_ER7M363uM";
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
            }else{
              $m = 0;
            }
           
            return $m;
     }  
    
  
    public static function SendNotification($title,$body,$type,$val,$user_id){
        $find_user=User::find($user_id);
      $url = 'https://fcm.googleapis.com/fcm/send';
      if($type=="login"){
            // $FcmToken ="";
            $fctoken="";
            // $FcmToken = User::where('id',$find_user->id)->pluck('device_key')->all();

              $FcmToken = $val;  
      }
       
      else if($type=="order_status"){
         
     
          $order=Order::where('id',$val)->first();
              if($order->user_type=="customer"){
                  $FcmToken = User::whereNotNull('device_key')->where('id',$order->customer_id)->pluck('device_key')->all();
                      $delivery=User::select('id','name')->where('id',$order->assigned_deliveryboy)->first();
                   
                  if($order->status=="On the way"){
                        $body="Your Order has been accepted by ".$delivery->name. " ";
                  }
                  if($order->status=="Delivery"){
                        $body="Your Order delivered successfully";
                  }
              }else if($order->user_type=="delivery_agent" || $order->user_type=="retailer"){
            
                    $FcmToken = User::whereNotNull('device_key')->where('id',$order->customer_id)->pluck('device_key')->all();
                     $distributor=User::select('id','name')->where('id',$order->assigned_distributor)->first();
                   
                  if($order->status=="On the way"){
                        $body="Your Order has been accepted by ".$distributor->name. " ";
                  }
                  if($order->status=="Delivery"){
                        $body="Your Order delivered successfully";
                  } 
                }else{
                  $FcmToken="";
                  $fctoken="";
              }
          
        }    
        else if($type=="adminorder_status"){
            $order=Order::where('id',$val)->first();
            if($order->status=="On the way"){
            if($order->user_type=="customer"){
             $user=User::where('id',$order->assigned_deliveryboy)->first();
              $body=$order->order_id." Order has been accpeted by ".$user->name;
            }else{
                 $user=User::where('id',$order->assigned_distributor)->first();
                 $body=$order->order_id." Order has been accpeted by ".$user->name;
            }
            
              $FcmToken = User::whereNotNull('device_key')->where('user_type',"admin")->pluck('device_key')->all();
              
            }else{
                  $FcmToken="";
                  $fctoken="";
            }
        }
        else if($type=="checkout"){
            // $order=Order::where('id',$val)->first();
            //   $FcmToken = User::whereNotNull('device_key')->where('user_type',"admin")->pluck('device_key')->all();
            //   $body=$body ." $order->user_type";
        }
        else if($type=="checkout_retailer"){
            $order=Order::where('id',$val)->first();
            if($order->user_type!="customer"){
              $FcmToken = User::whereNotNull('device_key')->where('user_type',"retailer")->pluck('device_key')->all();
              $body="Order placed from ".$order->user_type;
   
            }else{
                  $FcmToken="";
                  $fctoken="";
            }
    
        }
        
        else if($type=="checkout_customer"){
          
            //   $ord=Order::where('id',$val)->first();
            //   $delivery=Owner_meta_data::where('user_type','delivery_agent')->get();
            //   $ShippingAddress=ShippingAddress::where('order_id',$val)->first();
            //   if(!empty($ShippingAddress)){
            //       $checkuser_address=User_address::where('id',$ShippingAddress->address_id)->first();
            //       $lat=$checkuser_address->lat;
            //       $lang=$checkuser_address->lang;
            //   }else{
            //         $lat="";
            //       $lang="";
            //   }
            //   $FcmToken=array();
            //   foreach($delivery as $d){
                  
                  
            //           $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$d->lat.",".$d->lang."&destinations=".$lat.",".$lang."&mode=driving&language=pl-PL&key=AIzaSyB9YDxNdancLReCY2MbDGAXQdtAFjlc7-Y";
            //             //   $dist='';
            //                 $ch = curl_init();
            //                 curl_setopt($ch, CURLOPT_URL, $url);
            //                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //                 curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            //                 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            //                 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            //                 $response = curl_exec($ch);
            //          $response_a = json_decode($response, true);
            //                 if (isset($response_a['rows'][0]['elements'][0]['distance']['text'])) {
            //                   $m = $response_a['rows'][0]['elements'][0]['distance']['text'];
            //                 }else{
            //                   $m = 0;
            //                 }
                        
            //                 $kms=str_replace(',','.',$m);
            //               // $kms=str_replace('km','',$kms);
            //                 $whatIWant = substr($kms, strpos($kms, " ") + 1); 
            //                 if($whatIWant=="km"){
            //                   $kms=str_replace('km','',$kms);  
            //                 }else{
            //                     $kms=str_replace('m','',$kms);
            //                 }
                          
            //               $orders['kms']= ($kms);
                         

            //                 if((number_format($kms,2))<=5.0){
            //                   $FcmToken = User::whereNotNull('device_key')->where('ID',$d->user_id)->pluck('device_key')->all();
            //                  // array_push($FcmToken,$token);
            //                 }
                     
                        
            //      }
                // var_dump($FcmToken);
                   //  $FcmToken=implode(',',$FcmToken[0]);  
                // $FcmToken = User::whereNotNull('device_key')->where('ID',$order->customer_id)->pluck('device_key')->all();
                // $body="Your order has been placed";
              
            
            
                      $order=Order::where('id',$val)->first();
              $FcmToken = User::whereNotNull('device_key')->where('user_type',"delivery_agent")->where('id',1836)->where('device_key','!=',"")->pluck('device_key')->all();  
              $find_user->user_type="delivery_agent";
            //   $body="order placed ff";
        }
         else if($type=="checkout_customernoty"){
            $order=Order::where('id',$val)->first();
            //   $FcmToken = User::whereNotNull('device_key')->where('user_type',"delivery_agent")->pluck('device_key')->all();
              
                $FcmToken = User::whereNotNull('device_key')->where('id',$order->customer_id)->pluck('device_key')->all();
                $body="Your order has been placed";
               
        }
        
        
        else if($type=="register"){
              $FcmToken = User::whereNotNull('device_key')->where('user_type',"admin")->pluck('device_key')->all();
              $user=User::where('id',$val)->first();
              if($user->user_type=="customer"){
                  $body="New customer has been registered";
              }else if($user->user_type=="distributor"){
                  $body="New Distributor has been Registered and waiting for your Approval";
              }else if($user->user_type=="delivery_agent"){
                  $body="New Delivery agent has been Registered and waiting for your Approval";
              }else{
                  $body="New Retailer has been Registered and waiting for your Approval";
              }
        }
        else{
          $FcmToken = User::whereNotNull('device_key')->pluck('device_key')->all();
      }
       
      if(!empty($FcmToken) && $type!="login"){
        $result=[];
            foreach($FcmToken as $f){
                $value=json_decode($f);
                $result[]=$value;
                
            }
            $tokens=array_merge(...$result);
      }else if( $type=="login"){
          $tokens=array($FcmToken);
      }else{
          $fctoken="";
          $tokens=array($fctoken);
      }
  
      //for mobile
       

                    
                    
      if($find_user->user_type=="customer" || $find_user->user_type=="retailer"){

             $serverKey ='AAAA5gyYFKM:APA91bFs37r-WSRrlVUixCGLS4k_9j_ZKJrYJt9MjduLllXIpox7CCrMTYxUmuNfajZLo1pC1MgBg9RRyEdS-17rFTUWxUomtHXqj1RDxelke-t00eJv4NOqupldI310gQ9k5noko61B';
     }else{
        

            $serverKey ='AAAASjpEv7s:APA91bHk2rejJi004ENKItdn-jCureZzhfvkjVwy4T12xHx27dhQdH8r9Y_f8bCaJWLToAQJld7CNXp-bxLuX1Z0iEuUvzDaCY6WzNiSU6B1ySjrRFrouenE38w5eImi1vYt3OQmGruO';
      }
      //for desktop
                // $serverKey='AAAASjpEv7s:APA91bHk2rejJi004ENKItdn-jCureZzhfvkjVwy4T12xHx27dhQdH8r9Y_f8bCaJWLToAQJld7CNXp-bxLuX1Z0iEuUvzDaCY6WzNiSU6B1ySjrRFrouenE38w5eImi1vYt3OQmGruO';
              

            $data = [
                "registration_ids" =>$tokens,
                "notification" => [
                    "title" => "$title",
                    "body" => $body,  
                ]
            ];
            $encodedData = json_encode($data);
        
            $headers = [
                'Authorization:key='. $serverKey,
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
                
            $result = curl_exec($ch);
        //   /
            if ($result === FALSE) {
             
                die('Curl failed: ' . curl_error($ch));
            } 
            // else{
            //     var_dump($result);
            // }
     
   
            curl_close($ch);
            return $result;
            
           //echo($result);

    }
    
    
    
     public static function Notification($token,$user_id){
 
        
      
      $this->SendNotification("Welcome Rahul","Successfully Logged in","login",$token,$user_id);
                           
      
    }
    
    
   public static function notification_timing($date){
    $seconds  = strtotime(date('Y-m-d H:i:s')) - strtotime($date);

        $months = floor($seconds / (3600*24*30));
        $day = floor($seconds / (3600*24));
        $hours = floor($seconds / 3600);
        $mins = floor(($seconds - ($hours*3600)) / 60);
        $secs = floor($seconds % 60);

        if($seconds < 60)
            $time = $secs." seconds ago";
        else if($seconds < 60*60 )
            $time = $mins." min ago";
        else if($seconds < 24*60*60)
            $time = $hours." hours ago";
        else if($seconds < 24*60*60)
            $time = $day." day ago";
        else
            $time = $months." month ago";

        return $time;
}

public static function encrypt_decrypt($action, $string) {
            $output = false;
            $encrypt_method = "AES-256-CBC";
            $secret_key = '@!kvrahul';
            $secret_iv = '@!kvrahul';
            $key = hash('sha256', $secret_key);
            $iv = substr(hash('sha256', $secret_iv), 0, 16);
            if ( $action == 'encrypt' ) {
                $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
                $output = base64_encode($output);
            } else if( $action == 'decrypt' ) {
                $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
            }
            return $output;
    
}

public static function live_notification(){
          $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
          );
          $pusher = new Pusher(
            '3cb8fd24827957fe7f59',
            '90125215be51dcb483ef',
            '1594049',
            $options
          );
        
          $data=[];
          $pusher->trigger('my-channel', 'my-event', $data);
} 
}
