<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Wishlists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Auth;
use Session;
use Response;

class WishlistController extends Controller
{

    public function add_to_wishlist(Request $request)
    {
        try{
       $user=Auth::user();
       
       
       $product=Product::where('id',$request->product_id)->first();
       $duplicate_check=Wishlists::where('product_id',$request->product_id)->where('customer_id',$user->id)->first();
      
    
       if(empty($duplicate_check)){
            $wishlist=new Wishlists;
            $wishlist->customer_id=$user->id;
            $wishlist->product_id=$request->product_id;
            $wishlist->price=$product->customer_price;
            $wishlist->status="active";
            $wishlist->save();
            $success_msg="Wishlist added Succesfully";
       }else{
            $wishlist=Wishlists::where('product_id',$request->product_id)->where('customer_id',$user->id)->delete();
            $success_msg="Wishlist deleted Succesfully";
       }

       $success['statuscode'] =200;
       $success['message']=$success_msg;

       /**
        * params value (product_id)
       **/
       $params['product_id']=$request->product_id;


       $success['params']=$params;
       $response['response']=$success;
       return \Response::json($response, 200);
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
          return \Response::json($response, 401);
        }
    }
    
    
     public function delete_wislist(Request $request){
         try{
       $user=Auth::user();
       $wishlist=Wishlists::where('product_id',$request->product_id)->where('customer_id',$user->id)->delete();

       $success['statuscode'] =200;
       $success['message']="Wishlist deleted successfully";

       /**
        * params value (product_id,product_qty)
       **/
       $params['product_id']=$request->product_id;


       $success['params']=$params;
       $response['response']=$success;
       return \Response::json($response, 200);
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
          return \Response::json($response, 401);
        }
    }
    
        public function wishlist_lists(){
                 try{
                $user=Auth::user();
                $wishlists=Wishlists::where('status','active')->where('customer_id',$user->id)->get();
                $subamt=0;
                $depositamt=0;
                $delivery_charge=0;
                $totalamt=0;
                $url=url('/');
                foreach($wishlists as $key=>$wishlist){
                    $product=Product::where('id',$wishlist->product_id)->first();
                    
                    $wishlists[$key]['product_image']=$url.'/'.$product->image;
                    $wishlists[$key]['per_jar_rate']=$product->deposit_amount;
                    $wishlists[$key]['product_name']=$product->name;
                    $wishlists[$key]['slug']=$product->slug;
                    $subamt+=($wishlist->price * $wishlist->product_qty);
                    $depositamt+=($wishlist->deposit_amount);
                    if($wishlist->deposit_amount!="0"){
                    $totalamt+=($wishlist->price * $wishlist->product_qty)+($wishlist->product_qty * $product->deposit_amount) - ($wishlist->deposit_amount);
                    }else{
                      $totalamt+=($wishlist->price * $wishlist->product_qty)+($wishlist->product_qty * $product->deposit_amount) + ($wishlist->deposit_amount);  
                    }
                }
            
                
                foreach($wishlists as $key=>$wishlist){
                    $wishlists[$key]['subamt']=$subamt;
                    $wishlists[$key]['depositamt']=$depositamt;
                    $carts[$key]['delivery_charge']=$delivery_charge;
                    $wishlists[$key]['totalamt']=$subamt+$depositamt;
                 }
                 
                
                $params=[];
                $success['statuscode'] =200;
                $success['params']=$params;
                $success['message']="Wishlist List";
                $success['products']=$wishlists;  
                $response['response']=$success;
                return \Response::json($response, 200);
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
                  return \Response::json($response, 401);
                }
             }
}
