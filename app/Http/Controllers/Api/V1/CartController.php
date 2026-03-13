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

            // checking is with first order - calculating total jars ever ordered in any single previous order
            $max_jars_ordered = 0;
            $orders = Order::where('customer_id', $user->id)->get();
            foreach ($orders as $ord) {
                $current_order_jars = Orderproducts::join('products', 'order_products.product_id', '=', 'products.id')
                    ->where('order_products.order_id', $ord->id)
                    ->where('products.type', 'jar')
                    ->sum('order_products.quantity');
                
                if ($current_order_jars > $max_jars_ordered) {
                    $max_jars_ordered = $current_order_jars;
                }
            }
            $is_ordered = ($max_jars_ordered > 0 ? 1 : 0);
            
            
            $current_product = Product::where('id', $request->product_id)->where('type','jar')->exists();
            
            // JAR type - 1st order max 3, 2nd order+ max 2
            if ($current_product) {
                if ($is_ordered == 0 && $request->product_qty > 3) {
                    // 1st order - max 3 jars
                    $success['statuscode'] = 400;
                    $success['message'] = "Limit reached! Your limit is 3 for first order.";
                    $params = [];
                    $success['params'] = $params;
                    $response['response'] = $success;
                    return response()->json($response, 400);
                }
                // Use max_jars_ordered for future checks too if needed
                if ($max_jars_ordered > 0 && $request->product_qty > 100) { // Example limit for returned customers
                     // ... existing or new logic ...
                }
                // 2nd order onwards - No limit (removed the else if for qty > 2)
            } else {
                // Non-JAR products - No specific limit enforced here, allowing up to max_qty (100) in UI
                // $request->merge(['product_qty' => 1]); // Removed this line to allow more than 1
            }


            if ($request->type == "") {

                $product = Product::where('id', $request->product_id)->first();
                //product price
                if ($user->type == "retailer") {
                    $product_price = $product->retailer_price;
                } else {
                    $product_price = $product->customer_price;
                }


                if ($product->type == "jar") {
                    // Get other jar products already in cart
                    $other_jars_qty = Carts::join('products', 'carts.product_id', '=', 'products.id')
                        ->where('carts.customer_id', $user->id)
                        ->where('products.type', 'jar')
                        ->where('carts.product_id', '!=', $request->product_id)
                        ->sum('carts.product_qty');
                    
                    $total_jars_in_cart = $request->product_qty + $other_jars_qty;
                    
                    if ($max_jars_ordered == 0) {
                        // First time customer: deposit for all jars (up to 3)
                        $total_deposit_needed = $total_jars_in_cart * $product->deposit_amount;
                    } else {
                        // Subsequent orders: deposit only for extra jars beyond max previously ordered
                        $total_deposit_needed = max(0, $total_jars_in_cart - $max_jars_ordered) * $product->deposit_amount;
                    }

                    // Subtract deposit already accounted for in other cart items
                    $other_cart_deposit = Carts::join('products', 'carts.product_id', '=', 'products.id')
                        ->where('carts.customer_id', $user->id)
                        ->where('products.type', 'jar')
                        ->where('carts.product_id', '!=', $request->product_id)
                        ->sum('carts.deposit_amount');
                    
                    $depositamount = max(0, $total_deposit_needed - $other_cart_deposit);
                    $no_of_jars_returned = 0;
                    $returnable_jarqty = 0;
                } else {
                    $depositamount = 0;
                    $no_of_jars_returned = 0;
                    $returnable_jarqty = 0;
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

            $max_jars_ordered = 0;
            $orders = Order::where('customer_id', $user->id)->get();
            foreach ($orders as $ord) {
                $current_order_jars = Orderproducts::join('products', 'order_products.product_id', '=', 'products.id')
                    ->where('order_products.order_id', $ord->id)
                    ->where('products.type', 'jar')
                    ->sum('order_products.quantity');
                
                if ($current_order_jars > $max_jars_ordered) {
                    $max_jars_ordered = $current_order_jars;
                }
            }
            $is_ordered = ($max_jars_ordered > 0 ? 1 : 0);

            foreach ($carts as $key => $cart) {
                $carts[$key]['order_count'] = $order_count;
                $product = Product::where('id', $cart->product_id)->first();

                if ($product->type == "jar") {
                    $carts[$key]['is_jar'] = true;
                    $is_jar_available = true;
                    $jar_quantity += $cart->product_qty;
                    
                    if ($is_ordered == 0) {
                        $carts[$key]['default_qty'] = 3;
                        $carts[$key]['max_qty'] = 3;
                    } else {
                        $carts[$key]['default_qty'] = 2; // Updated to 2
                        $carts[$key]['max_qty'] = 100; // Unlimited practically
                    }
                } else if ($is_jar_available == true) {
                    $carts[$key]['is_jar'] = false;
                    $is_jar_available = true;
                    $carts[$key]['default_qty'] = 1;
                    $carts[$key]['max_qty'] = 100; // Updated to 100
                } else {
                    $carts[$key]['is_jar'] = false;
                    $is_jar_available = false;
                    $carts[$key]['default_qty'] = 1;
                    $carts[$key]['max_qty'] = 100; // Updated to 100
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
