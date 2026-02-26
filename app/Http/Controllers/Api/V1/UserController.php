<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Carts;
use App\Models\Owner_meta_data;
use App\Models\Order;
use App\Models\Notifications;
use App\Models\Orderproducts;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User_address;
use App\Events\NewEvent;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\helpers\Helper;
use Exception;
class UserController extends Controller
{

public function update_user(Request $request){
     try{
         
            $user=Auth::user();

            $duplicate_check=User::where('email',$request->email)->where('user_type','customer')->where('id','!=',$user->id)->first();
            $duplicate_phone_check=User::where('phone',$request->phone)->where('user_type','customer')->where('id','!=',$user->id)->first();
            // var_dump($duplicate_check);
            // exit;
            if(empty($duplicate_check) && empty($duplicate_phone_check)){
                $user=User::find($user->id);
                $user->update($request->all());
    
               $success['statuscode'] =200;
               $success['message']="User updated successfully";
        
               /**
                * params value (product_id,product_qty)
               **/
               $params=$request->all();
               $success['user']=$user;
               $success['params']=$params;
               $response['response']=$success;
               return response()->json($response, 200); 
            }else if(!empty($duplicate_check)){
                $success['statuscode'] =401;
                $success['message']="Duplicate email entry";
                /**
                 * params value (user_id,otp,token)
                **/
                  $params=[];
                  $success['params']=$params;
                  $response['response']=$success;
                  return response()->json($response, 401);
            }else{
                $success['statuscode'] =401;
                $success['message']="Duplicate phone entry";
                /**
                 * params value (user_id,otp,token)
                **/
                  $params=[];
                  $success['params']=$params;
                  $response['response']=$success;
                  return response()->json($response, 401);
            }
        }
            catch(Exception $e){
            $success['statuscode'] =401;
            $success['message']="Something went wrong";
            /**
             * params value (user_id,otp,token)
            **/
              $params=[];
              $success['params']=$params;
              $response['response']=$success;
              return response()->json($response, 401);
        }
}
}
