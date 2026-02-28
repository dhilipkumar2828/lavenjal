<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Wishlists;
use App\Models\MostLike;
use App\Models\Feedback;
use App\Models\Carts;
use App\Models\Order;
use App\Models\Orderproducts;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Exception;

class ProductController extends Controller
{

    public function products()
    {
        try{
        $user=Auth::user();
         $url=url('/');
        $products=Product::select('id','name','image','size','slug')->orderBy('orderby','asc')->where('status','active')->limit(6);
        if($user->user_type!="customer"){
            $products->where('type','bottle');
        }
        $products=$products->get();
        foreach($products as $product){
            $product['image']=$url."/".$product['image'];
        }
        
        $params=[];
        $success['statuscode'] =200;
        $success['params']=$params;
        $success['message']="Product List";
        $success['products']=$products;        
        $response['response']=$success;
        return response()->json($response, 200);
        
        //return response()->json(['products'=>$products]);  
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

    public function all_products(Request $request)
    {
        try{
       //  $user_id=$request->user_id;
       $user=Auth::user();
      $url=url('/');
        $products=Product::select('id','name','image','size','slug')->orderBy('orderby','asc')->where('status','active');
        
        if($user->user_type!="customer"){
            $products->where('type','bottle');
        }
        $products=$products->get();

        foreach($products as $product){
           $product['image']=$url."/".$product['image'];
        //   if(!empty($user_id)){
        //       $cart=Carts::where('product_id',$product->id)->where('customer_id',$user_id)->first();
        //       $wishlists=Wishlists::where('product_id',$product->id)->where('customer_id',$user_id)->first();
        //         if(!empty($wishlists)){
        //           $product['wishlist_status']="true";
        //       }else{
        //           $product['wishlist_status']="false";
        //       }
               
        //       if(!empty($cart)){
        //           $product['cart_status']="true";
        //           $product['cart_qty']=$cart->product_qty;
        //       }else{
        //           $product['cart_status']="false";
        //           $product['cart_qty']=0;
        //       }
        //     }else{
        //          $success['statuscode'] =401;
        //          $params=[];
        //          $success['params']=$params;
        //          $success['message']="User not found";
        //          $response['response']=$success;
        //          return response()->json($response, 200);
        //          }
        $product->user_type=Auth::user()->user_type;
        }
          $params=[];
        $success['statuscode'] =200;
        $success['params']=$params;
        $success['message']="Product List";
        $success['products']=$products;        
        $response['response']=$success;
        return response()->json($response, 200);
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
    
        public function product_details(Request $request, $id)
    {
        try {
            $url = url('/');
            $user = Auth::user();

            // 1. Check: User authenticated (Bearer Token check)
            if (empty($user)) {
                return response()->json([
                    'response' => [
                        'statuscode' => 401,
                        'params'     => [],
                        'message'    => 'Unauthorized. Please login.'
                    ]
                ], 200);
            }

            // Use authenticated user's ID from token (no need to send user_id in body)
            $user_id = $user->id;

            // 2. Check: Product exists by slug
            $product = Product::select(
                'id', 'name', 'image', 'size', 'slug',
                'description', 'type', 'customer_price',
                'is_returnable', 'retailer_price', 'deposit_amount', 'status'
            )
            ->where('slug', $id)
            ->where('status', 'active')
            ->first();

            if (empty($product)) {
                return response()->json([
                    'response' => [
                        'statuscode' => 404,
                        'params'     => [],
                        'message'    => 'Product not found for slug: ' . $id
                    ]
                ], 200);
            }

            // 3. Count how many jar-type orders this user has placed
            $is_ordered = 0;
            $order_list = Order::where('customer_id', $user_id)->get();
            foreach ($order_list as $ord) {
                $ord_products = Orderproducts::where('order_id', $ord->id)->first();
                if (!empty($ord_products)) {
                    $ord_product = Product::where('id', $ord_products->product_id)->first();
                    // Fixed: was !empty($product->type=="jar") which is always true
                    if (!empty($ord_product) && $ord_product->type == 'jar') {
                        $is_ordered += 1;
                    }
                }
            }

            // 4. Set full image URL
            $product['image'] = $url . "/" . $product['image'];

            // 5. Set jar flag
            $product['isProductJar'] = ($product->is_returnable == 'yes') ? true : false;

            // 6. Set order count and user type
            $product['order_count'] = $is_ordered;
            $product['user_type']   = $user->user_type;

            // 7. Cart status (null-safe)
            $cart = Carts::where('product_id', $product->id)
                         ->where('customer_id', $user_id)
                         ->first();
            if (!empty($cart)) {
                $product['cart_status'] = "true";
                $product['cart_qty']    = $cart->product_qty;
            } else {
                $product['cart_status'] = "false";
                $product['cart_qty']    = 0;
            }

            // 8. Wishlist status (null-safe)
            $wishlists = Wishlists::where('product_id', $product->id)
                                  ->where('customer_id', $user_id)
                                  ->first();
            $product['wishlist_status'] = !empty($wishlists) ? "true" : "false";

            $params['user_id'] = $user_id;

            $success['statuscode'] = 200;
            $success['params']     = $params;
            $success['message']    = "Product Details";
            $success['products']   = $product;
            $response['response']  = $success;
            return response()->json($response, 200);

        } catch (Exception $e) {
            return response()->json([
                'response' => [
                    'statuscode' => 500,
                    'params'     => [],
                    'message'    => 'Something went wrong: ' . $e->getMessage()
                ]
            ], 200);
        }
    }

public function most_like(){
   try{
       //  $user_id=$request->user_id;
       $user=Auth::user();
        $mostlike=MostLike::all();
        foreach($mostlike as $m){
            $m->selected= $m->selected==1?true:false;
        }
          $params=[];
        $success['statuscode'] =200;
        $success['params']=$params;
        $success['message']="Most Like";
        $success['most_like']=$mostlike;        
        $response['response']=$success;
        return response()->json($response, 200);
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
public function feedback(Request $request){
    
     try{
       //  $user_id=$request->user_id;
       $user=Auth::user();
       if($user->user_type=="delivery_agent"){
          $user->user_type="delivery";
       }
        $feedback=new Feedback();
        $feedback->user_id=$user->id;
        $feedback->rating=$request->rating;
        $feedback->most_like=implode(',',$request->most_like);
        $feedback->explore_next=$request->explore_next;
        $feedback->type=$user->user_type;
        $feedback->save();
          $params['rating']=$request->rating;
          $params['most_like']=$request->most_like;
          $params['explore_next']=$request->explore_next;
        $success['statuscode'] =200;
        $success['params']=$params;
        $success['message']="Feedback List";
        $success['feedback']=$feedback;        
        $response['response']=$success;
        return response()->json($response, 200);
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
