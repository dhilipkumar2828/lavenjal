<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User_address;
use App\Models\Product;
use App\Models\Carts;
use App\Models\Orderproducts;
use App\Models\DeliveryCharges;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Exception;

class CartController extends Controller
{
    public function add_to_cart(Request $request)
    {
        try {

            $user = Auth::user();

            $user_address = User_address::where('user_id', $user->id)->where('is_default', 'true')->first();
            if (!empty($user_address)) {
                $charges = DeliveryCharges::where('floor_no', $user_address->floor_no)->first();
            } else {
                $charges = [];
            }

            // checking is wit first order
            $is_ordered = 0;
            $order_count = Order::where('customer_id', $user->id)->get();
            foreach ($order_count as $ord) {
                $order_products = Orderproducts::where('order_id', $ord->id)->get();
                foreach ($order_products as $ord_products) {
                    $products = Product::where('id', $ord_products->product_id)->where('type','jar')->first();

                    if (!empty($products)) {
                        $is_ordered += 1;
                    }
                }
            }
            
            
            $current_product = Product::where('id', $request->product_id)->where('type','jar')->exists();
            
            // if ($current_product && (($is_ordered == 0 && $request->product_qty > 3) || ($is_ordered > 0 && $request->product_qty > 2))) {
            if ($current_product && $is_ordered == 0 && $request->product_qty > 3) {
                $success['statuscode'] = 400;
                $success['message'] = "Limit reached! Your limit is 3 now.";

                $params = [];
                $success['params'] = $params;
                $response['response'] = $success;
                return response()->json($response, 400);
            }


            if ($request->type == "") {

                $product = Product::where('id', $request->product_id)->first();
                //product price
                if ($user->type == "retailer") {
                    $product_price = $product->retailer_price;
                } else {
                    $product_price = $product->customer_price;
                }


                if ($is_ordered == 0 && $product->type == "jar") {

                    $returnable_jarqty = 0;
                    $no_of_jars_returned = 0;
                    $depositamount = $request->product_qty * $product->deposit_amount;
                } else if (($product->type != "jar" && $is_ordered == 0)) {

                    $depositamount = 0;
                    $no_of_jars_returned = 0;
                    $returnable_jarqty = 0;
                } else {
                    $return_qty = Carts::where('customer_id', $user->id)->sum('no_of_jars_returned');
                    if ($request->product_qty >= $return_qty) {
                        $depositamount = ($request->product_qty - $return_qty) * $product->deposit_amount;
                    } else if ($return_qty >= $request->product_qty) {
                        $depositamount = 0;
                    }
                    $no_of_jars_returned = $return_qty;

                }


                //Apply discount
                if ($user->user_type == "customer") {
                    $discount_amount = ($product->customer_discount * $request->product_qty);
                    // var_dump($request->product_qty);
                    // exit;
                } else {
                    $discount_amount = 0;
                }


            } else {
                $product_rate = Product::where('type', 'jar')->where('status', 'active')->first();
                $cart = Carts::where('product_id', $request->product_id)->where('customer_id', $user->id)->first();
                if ($cart->product_qty >= $request->returnable_jarqty) {
                    $depositamount = ($cart->product_qty - $request->returnable_jarqty) * $product_rate->deposit_amount;
                } else {
                    $depositamount = 0;
                }

                $no_of_jars_returned = $request->returnable_jarqty;
            }



            $duplicate_check = Carts::where('product_id', $request->product_id)->where('customer_id', $user->id)->first();


            if (empty($duplicate_check)) {
                $cart = new Carts;
                $cart->customer_id = $user->id;
                $cart->product_id = $request->product_id;
                $cart->product_qty = $request->product_qty;
                $cart->product_name = $product->name;
                $cart->discount_amount = $discount_amount;
                $cart->delivery_charges = ((!empty($charges) && $charges->is_discount == 'false') ? $charges->amount : '0.00');
                // $cart->total_available_jar=$total_available_jar;
                $cart->no_of_jars_returned = $request->returnable_jarqty;
                $cart->status = "active";
                $cart->price = $product_price;
                $cart->deposit_amount = $depositamount;
                // $cart->returnablejar_qty=$returnable_jarqty;
                $cart->save();
                $success_msg = "Cart added Succesfully";
            } else {
                if ($request->type == "") {
                    $cart = Carts::where('product_id', $request->product_id)->where('customer_id', $user->id)->update(['product_qty' => $request->product_qty, 'discount_amount' => $discount_amount, 'delivery_charges' => ((!empty($charges) && $charges->is_discount == 'false') ? $charges->amount : '0.00')]);

                    if ($product->type == "jar") {
                        $cart = Carts::where('product_id', $request->product_id)->where('customer_id', $user->id)->update(['deposit_amount' => $depositamount]);
                    }
                } else {
                    $cart = Carts::where('product_id', $request->product_id)->where('customer_id', $user->id)->update(['deposit_amount' => $depositamount]);

                    if ($request->type == "return_jar") {
                        $cart = Carts::where('id', $request->cart_id)->where('customer_id', $user->id)->update(['no_of_jars_returned' => $no_of_jars_returned]);
                    }
                }


                $success_msg = "Cart updated Succesfully";
            }


            // 

            $success['statuscode'] = 200;
            $success['message'] = $success_msg;

            /**
             * params value (product_id,product_qty)
             **/
            $params['delivery'] = (!empty($charges) ? $charges->id : '');
            $params['product_id'] = $request->product_id;
            $params['product_qty'] = $request->product_qty;
            $params['user_id'] = $user->id;
            $params['returnable_jarqty'] = $request->returnable_jarqty;
            $params['deposit_amount'] = $depositamount;
            $success['params'] = $params;
            $response['response'] = $success;
            return response()->json($response, 200);
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return response()->json($response, 401);
        }
    }

    public function delete_cart(Request $request)
    {
        try {
            $user = Auth::user();
            $cart = Carts::where('product_id', $request->product_id)->where('customer_id', $user->id)->delete();

            $success['statuscode'] = 200;
            $success['message'] = "Cart deleted successfully";

            /**
             * params value (product_id,product_qty)
             **/
            $params['product_id'] = $request->product_id;


            $success['params'] = $params;
            $response['response'] = $success;
            return response()->json($response, 200);
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return response()->json($response, 401);
        }
    }

    public function cart_lists()
    {
        try {
            $user = Auth::user();
            $carts = Carts::where('status', 'active')->where('customer_id', $user->id)->get();


            $user_address = User_address::where('user_id', $user->id)->where('is_default', 'true')->first();
            if (!empty($user_address)) {
                $charges = DeliveryCharges::where('floor_no', $user_address->floor_no)->first();
            } else {
                $charges = [];
            }

            Carts::where('customer_id', $user->id)->update(['delivery_charges' => ((!empty($charges) && $charges->is_discount == 'false') ? $charges->amount : '0.00')]);

            $order_count = Order::where('customer_id', $user->id)->count();
            $is_jar_available = false;
            $subamt = 0;
            $depositamt = 0;
            $delivery_charge = 0;
            $totalamt = 0;
            $returnable_jarqty = 0;
            $discountamt = 0;
            $no_of_jars_returned = 0;
            $jar_quantity = 0;

            $is_ordered = 0;
            $order_count = Order::where('customer_id', $user->id)->get();
            foreach ($order_count as $ord) {
                $ord_products = Orderproducts::where('order_id', $ord->id)->first();
                if (!empty($ord_products)) {
                    $products = Product::where('id', $ord_products->product_id)->first();
                    if (!empty($products)) {
                        $is_ordered += 1;
                    }
                }
            }

            foreach ($carts as $key => $cart) {
                $carts[$key]['order_count'] = $order_count;
                $product = Product::where('id', $cart->product_id)->first();

                if ($product->type == "jar") {
                    $carts[$key]['is_jar'] = true;
                    $is_jar_available = true;
                    $jar_quantity += $cart->product_qty;
                } else if ($is_jar_available == true) {
                    $carts[$key]['is_jar'] = false;
                    $is_jar_available = true;
                } else {
                    $carts[$key]['is_jar'] = false;
                    $is_jar_available = false;
                }

                // $is_jar_available=($product->type=="jar" ? true:false);
                $carts[$key]['product_image'] = "https://lavenjal.com/" . $product->image;
                $carts[$key]['per_jar_rate'] = $product->deposit_amount;
                //$subamt+=($cart->price * $cart->product_qty)+($cart->product_qty * $product->deposit_amount);
                $subamt += ($cart->price * $cart->product_qty);
                $delivery_charge = ($cart->delivery_charges);
                $depositamt += ($cart->deposit_amount);
                $returnable_jarqty += ($cart->returnablejar_qty);
                $no_of_jars_returned += $cart->no_of_jars_returned;
                $discountamt += $cart->discount_amount;
                if ($cart->deposit_amount != "0") {
                    $totalamt += ($cart->price * $cart->product_qty) + ($cart->product_qty * $product->deposit_amount) - ($cart->deposit_amount);
                } else {
                    $totalamt += ($cart->price * $cart->product_qty) + ($cart->product_qty * $product->deposit_amount) + ($cart->deposit_amount);
                }
            }

            $have_empty_lavenjal_jars_with_cap = $user_address->returnablejar_qty;
            // foreach($carts as $key=>$cart){
            //     $carts[$key]['subamt']=$subamt;
            //     $carts[$key]['depositamt']=$depositamt;
            //     $carts[$key]['returnable_jarqty']=$returnable_jarqty;
            //     $carts[$key]['delivery_charge']=$delivery_charge;
            //     $carts[$key]['totalamt']=$subamt+$depositamt;
            //  }
            $available_jar = $user_address->returnablejar_qty;

            if ($jar_quantity > 0) {
                $delivery_charge = $jar_quantity * (!empty($delivery_charge) ? $delivery_charge : 0);
            }

            $params = [];
            $success['statuscode'] = 200;
            $success['params'] = $params;
            $success['message'] = "Cart List";
            $success['products'] = $carts;
            $success['order_count'] = $is_ordered;


            $success['is_jar_available'] = $is_jar_available;
            $success['have_empty_lavenjal_jars_with_cap'] = $have_empty_lavenjal_jars_with_cap;
            $success['no_of_jars_returned'] = $no_of_jars_returned;
            $success['subamt'] = $subamt;

            $success['depositamt'] = $depositamt;
            $success['returnable_jarqty'] = $available_jar;
            $success['delivery_charge'] = $delivery_charge;
            $success['discount_amount'] = ($user->user_type == "customer" ? $discountamt : '');
            $success['totalamt'] = ($user->user_type == "customer" ? (($subamt + $delivery_charge + $depositamt) - $discountamt) : $subamt + $depositamt + $delivery_charge);

            $response['response'] = $success;
            return response()->json($response, 200);
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return response()->json($response, 401);
        }
    }
}
