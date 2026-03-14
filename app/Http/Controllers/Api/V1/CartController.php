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
    private function get_returnable_jars_count($user_id)
    {
        $delivered_stats = Orderproducts::join('orders', 'order_products.order_id', '=', 'orders.id')
            ->join('products', 'order_products.product_id', '=', 'products.id')
            ->where('order_products.customer_id', $user_id)
            ->where('orders.status', 'Delivery')
            ->where('products.type', 'jar')
            ->selectRaw('SUM(order_products.quantity) as total_delivered, SUM(order_products.no_of_jars_returned) as total_returned')
            ->first();

        $delivered = (int)($delivered_stats->total_delivered ?? 0);
        $returned = (int)($delivered_stats->total_returned ?? 0);

        return max(0, $delivered - $returned);
    }

    private function get_max_jars_ordered($user_id)
    {
        $max = 0;
        $orders = Order::where('customer_id', $user_id)->where('status', 'Delivery')->get();
        foreach ($orders as $ord) {
            $current_order_jars = Orderproducts::join('products', 'order_products.product_id', '=', 'products.id')
                ->where('order_products.order_id', $ord->id)
                ->where('products.type', 'jar')
                ->sum('order_products.quantity');
            
            if ($current_order_jars > $max) {
                $max = $current_order_jars;
            }
        }
        return $max;
    }

    public function add_to_cart(Request $request)
    {
        try {
            $user = Auth::user();

            $user_address = User_address::where('user_id', $user->id)->where('is_default', 'true')->first();
            $charges = $user_address ? DeliveryCharges::where('floor_no', $user_address->floor_no)->first() : null;

            $max_jars_ordered = $this->get_max_jars_ordered($user->id);
            $is_ordered = ($max_jars_ordered > 0 ? 1 : 0);
            $available_to_return = $this->get_returnable_jars_count($user->id);

            if ($request->type == "return_jar") {
                $cart = Carts::where('id', $request->cart_id)->where('customer_id', $user->id)->first();
                if (!$cart) {
                    $success['statuscode'] = 404;
                    $success['message'] = "Cart item not found";
                    return response()->json(['response' => $success], 404);
                }
                $product = Product::find($cart->product_id);
                
                $other_returns = Carts::where('customer_id', $user->id)->where('id', '!=', $cart->id)->sum('no_of_jars_returned');
                $requested_return = (int)$request->returnable_jarqty;
                $allowed_return = min($requested_return, max(0, $available_to_return - $other_returns));
                
                $deposit_amount = max(0, ($cart->product_qty - $allowed_return) * ($product->deposit_amount ?? 150));
                
                $cart->no_of_jars_returned = $allowed_return;
                $cart->deposit_amount = $deposit_amount;
                $cart->save();

                $success['statuscode'] = 200;
                $success['message'] = "Return quantity updated";
                $success['params'] = ['no_of_jars_returned' => $allowed_return, 'deposit_amount' => $deposit_amount];
                return response()->json(['response' => $success], 200);
            }

            $product = Product::find($request->product_id);
            if (!$product) {
                $success['statuscode'] = 404;
                $success['message'] = "Product not found";
                return response()->json(['response' => $success], 404);
            }

            if ($product->type == "jar") {
                if ($is_ordered == 0 && $request->product_qty > 3) {
                    $success['statuscode'] = 400;
                    $success['message'] = "Limit reached! Your limit is 3 for first order.";
                    return response()->json(['response' => $success], 400);
                }
            }

            $product_price = ($user->type == "retailer" ? $product->retailer_price : $product->customer_price);
            $discount_amount = ($user->user_type == "customer" ? ($product->customer_discount * $request->product_qty) : 0);

            $cart = Carts::where('product_id', $request->product_id)->where('customer_id', $user->id)->first();
            
            $current_return = ($cart ? $cart->no_of_jars_returned : 0);
            
            if ($product->type == "jar") {
                $deposit_amount = max(0, ($request->product_qty - $current_return) * ($product->deposit_amount ?? 150));
            } else {
                $deposit_amount = 0;
                $current_return = 0;
            }

            if (!$cart) {
                $cart = new Carts;
                $cart->customer_id = $user->id;
                $cart->product_id = $request->product_id;
                $cart->product_name = $product->name;
            }

            $cart->product_qty = $request->product_qty;
            $cart->price = $product_price;
            $cart->discount_amount = $discount_amount;
            $cart->deposit_amount = $deposit_amount;
            $cart->delivery_charges = ($charges && $charges->is_discount == 'false') ? $charges->amount : '0.00';
            $cart->no_of_jars_returned = $current_return;
            $cart->status = "active";
            $cart->save();

            $success['statuscode'] = 200;
            $success['message'] = "Cart updated successfully";
            $success['params'] = [
                'product_id' => $request->product_id,
                'product_qty' => $request->product_qty,
                'deposit_amount' => $deposit_amount,
                'no_of_jars_returned' => $current_return
            ];
            return response()->json(['response' => $success], 200);

        } catch (Exception $e) {
            $success['statuscode'] = 500;
            $success['message'] = "Something went wrong";
            return response()->json(['response' => $success], 500);
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

            $max_jars_ordered = $this->get_max_jars_ordered($user->id);
            $is_ordered = ($max_jars_ordered > 0 ? 1 : 0);

            $available_jar_balance = $this->get_returnable_jars_count($user->id);
            if (!empty($user_address)) {
                $user_address->update(['returnablejar_qty' => $available_jar_balance]);
            }

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
                        $carts[$key]['default_qty'] = 2;
                        $carts[$key]['max_qty'] = 100;
                    }
                } else {
                    $carts[$key]['is_jar'] = false;
                    $carts[$key]['default_qty'] = 1;
                    $carts[$key]['max_qty'] = 100;
                }

                $carts[$key]['product_image'] = "https://lavenjal.com/" . $product->image;
                $carts[$key]['per_jar_rate'] = $product->deposit_amount;
                
                $subamt += ($cart->price * $cart->product_qty);
                $delivery_charge = ($cart->delivery_charges);
                $depositamt += ($cart->deposit_amount);
                $no_of_jars_returned += $cart->no_of_jars_returned;
                $discountamt += $cart->discount_amount;
                
                $totalamt += ($cart->price * $cart->product_qty) + $cart->deposit_amount;
            }

            $have_empty_lavenjal_jars_with_cap = $available_jar_balance;
            // foreach($carts as $key=>$cart){
            //     $carts[$key]['subamt']=$subamt;
            //     $carts[$key]['depositamt']=$depositamt;
            //     $carts[$key]['returnable_jarqty']=$returnable_jarqty;
            //     $carts[$key]['delivery_charge']=$delivery_charge;
            //     $carts[$key]['totalamt']=$subamt+$depositamt;
            //  }
            $available_jar = $available_jar_balance;

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
