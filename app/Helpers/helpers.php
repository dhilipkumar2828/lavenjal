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
    
  
    /**
     * Generate a short-lived OAuth2 Bearer token from a Firebase service account JSON file.
     * Used for FCM HTTP v1 API authentication.
     */
    public static function getFcmAccessToken($serviceAccountPath)
    {
        if (!file_exists($serviceAccountPath)) {
            \Log::error("FCM service account file not found: " . $serviceAccountPath);
            return null;
        }

        $serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);
        if (empty($serviceAccount)) {
            \Log::error("FCM service account JSON is invalid: " . $serviceAccountPath);
            return null;
        }

        $privateKey  = $serviceAccount['private_key'];
        $clientEmail = $serviceAccount['client_email'];
        $tokenUri    = $serviceAccount['token_uri'];

        $now = time();
        $jwtHeader  = base64_encode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
        $jwtClaims  = base64_encode(json_encode([
            'iss'   => $clientEmail,
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud'   => $tokenUri,
            'iat'   => $now,
            'exp'   => $now + 3600,
        ]));

        // URL-safe base64 encode
        $jwtHeader = str_replace(['+', '/', '='], ['-', '_', ''], $jwtHeader);
        $jwtClaims = str_replace(['+', '/', '='], ['-', '_', ''], $jwtClaims);

        $signingInput = $jwtHeader . '.' . $jwtClaims;

        $signature = '';
        $key = openssl_pkey_get_private($privateKey);
        if (!$key || !openssl_sign($signingInput, $signature, $key, 'SHA256')) {
            \Log::error("FCM JWT signing failed.");
            return null;
        }

        $jwtSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        $jwt = $signingInput . '.' . $jwtSignature;

        // Exchange JWT for access token
        $ch = curl_init($tokenUri);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion'  => $jwt,
        ]));
        $response = curl_exec($ch);
        curl_close($ch);

        $token = json_decode($response, true);
        return $token['access_token'] ?? null;
    }


    public static function SendNotification($title,$body,$type,$val,$user_id){
        $find_user=User::find($user_id);

      if($type=="login"){
            $fctoken="";
            $FcmToken = $val;  
      }
       
      else if($type=="order_status"){
          $order=Order::where('id',$val)->first();
              if($order->user_type=="customer"){
                  $FcmToken = User::whereNotNull('device_key')->where('id',$order->customer_id)->pluck('device_key')->all();
                  $delivery=User::select('id','name')->where('id',$order->assigned_deliveryboy)->first();
                  if($order->status=="On the way"){
                        $body="Your Order has been accepted by ".$delivery->name." ";
                  }
                  if($order->status=="Delivery"){
                        $body="Your Order delivered successfully";
                  }
              }else if($order->user_type=="delivery_agent" || $order->user_type=="retailer"){
                    $FcmToken = User::whereNotNull('device_key')->where('id',$order->customer_id)->pluck('device_key')->all();
                    $distributor=User::select('id','name')->where('id',$order->assigned_distributor)->first();
                  if($order->status=="On the way"){
                        $body="Your Order has been accepted by ".$distributor->name." ";
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
            // Reserved for future use
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
            $order=Order::where('id',$val)->first();
            $FcmToken = User::whereNotNull('device_key')->where('user_type',"delivery_agent")->where('id',1836)->where('device_key','!=',"'")->pluck('device_key')->all();
            $find_user->user_type="delivery_agent";
        }
        else if($type=="checkout_customernoty"){
            $order=Order::where('id',$val)->first();
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
       
      // Resolve FCM token list
      if(!empty($FcmToken) && $type!="login"){
          $result=[];
          foreach($FcmToken as $f){
              $value=json_decode($f);
              $result[]=$value;
          }
          $tokens=array_merge(...$result);
      }else if($type=="login"){
          $tokens=array($FcmToken);
      }else{
          $fctoken="";
          $tokens=array($fctoken);
      }

      // -------------------------------------------------------
      // FCM HTTP v1 API — Service Account per user type
      // -------------------------------------------------------
      if($find_user->user_type=="customer" || $find_user->user_type=="retailer"){
          // Customer / Retailer — Firebase project: lavenjal-user
          $serviceAccountPath = storage_path('app/firebase/customer-service-account.json');
          $fcmProjectId       = 'lavenjal-user';
      } else {
          // Distributor / Delivery Boy — Firebase project: lavenjal-delivery
          $serviceAccountPath = storage_path('app/firebase/distributor-service-account.json');
          $fcmProjectId       = 'lavenjal-delivery';
      }

      // Get OAuth2 Bearer token from service account
      $accessToken = self::getFcmAccessToken($serviceAccountPath);

      if(empty($accessToken)){
          \Log::error("FCM: Failed to get access token for user_type: " . $find_user->user_type);
          return json_encode(['error' => 'Failed to get FCM access token.']);
      }

      $fcmUrl  = 'https://fcm.googleapis.com/v1/projects/' . $fcmProjectId . '/messages:send';
      $results = [];

      foreach($tokens as $token){
          if(empty($token)) continue;

          $data = [
              "message" => [
                  "token" => $token,
                  "notification" => [
                      "title" => $title,
                      "body"  => $body,
                  ],
              ]
          ];

          $headers = [
              'Authorization: Bearer ' . $accessToken,
              'Content-Type: application/json',
          ];

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $fcmUrl);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

          $result = curl_exec($ch);
          if ($result === FALSE) {
              $results[] = ['error' => 'Curl failed: ' . curl_error($ch)];
          } else {
              $results[] = json_decode($result, true);
          }
          curl_close($ch);
      }

      return json_encode($results);
    }
    
    
    
     public static function Notification($token,$user_id){
        self::SendNotification("Welcome","Successfully Logged in","login",$token,$user_id);
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
