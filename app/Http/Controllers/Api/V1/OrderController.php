<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Carts;
use App\Models\Owner_meta_data;
use App\Models\Order;
use App\Models\Notifications;
use App\Models\Mobile_notifications;
use App\Models\Orderproducts;
use App\Models\DeliveryCharges;
use App\Models\Product;
use App\Models\ShippingAddress;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Auth;
use Session;
use App\Models\User_address;
use Response;
use App\Events\NewEvent;
use Str;

use App\Models\Pincode;
use DB;
use Carbon\Carbon;
use Helper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

    private $easebuzz_url;
    private $easebuzz_key;
    private $easebuzz_salt;


    public function __construct()
    {
        $this->easebuzz_url = env('EASEBUZZ_URL', 'https://pay.easebuzz.in/payment/initiateLink'); // Replace with your actual key

        $this->easebuzz_key = env('EASEBUZZ_MERCHANT_KEY', ''); // Replace with your actual key
        $this->easebuzz_salt = env('EASEBUZZ_MERCHANT_SALT', ''); // Replace with your actual salt
    }


    private function time()
    {
        $timeslot = array(
            '1' => "Any time",
            '2' => "8am - 12pm",
            '3' => "12pm - 8pm",
            '4' => "8am - 11am",
            '5' => "11am - 2pm",
            '6' => "2pm - 5pm",
            '7' => "5pm - 8pm"
        );
        return $timeslot;
    }
    private function time_slot($time)
    {
        $timeslot = $this->time();
        return $timeslot[$time];
    }


    private function map($delivery_lat, $delivery_lang, $distributor_lat, $distributor_lang)
    {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $delivery_lat . "," . $delivery_lang . "&destinations=" . $distributor_lat . "," . $distributor_lang . "&mode=driving&language=pl-PL&key=AIzaSyAMWBCScrGIa5WPe9VB39Kiz_ER7M363uM";
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
        } else {
            $m = 0;
        }

        return $m;
    }



    public function initiate_payment(Request $request)
    {
        try {
            //$user = Auth::user();
            $user_details = User::find($request->userId);
            // Getting user details
            $userId = $request->userId;
            $orderId = $request->order_id;
            if (empty($userId)) {
                return response()->json([
                    'error' => 'Unauthorized User',
                    'message' => 'Invalid User',
                ], 400);
            }

            $user_details = User::find($userId);
            if (empty($user_details)) {
                return response()->json([
                    'error' => 'Unauthorized User',
                    'message' => 'Invalid User',
                ], 401);
            }

            if (empty($orderId)) {
                return response()->json([
                    'error' => 'Invalid Order ID!',
                    'message' => 'Order ID must not be empty',
                ], 400);
            }

            if (empty($request->delivery_date)) {
                return response()->json([
                    'error' => 'Delivery Date Required',
                    'message' => 'Delivery Date Required Field',
                ], 400);
            }

            if (empty($request->delivery_time)) {
                return response()->json([
                    'error' => 'Delivery Time Required',
                    'message' => 'Delivery Time Required Field',
                ], 400);
            }

            // fetching amount
            $amount = $this->checkNull($request->amount);
            if (empty($amount))
                return response()->json([
                    'error' => 'Input warning',
                    'message' => 'Invalid amount',
                ], 400);

            // Getting the user selected address
            $selectedAddress = User_address::where('user_id', $userId)->where('is_default', 'true')->first();
            if (empty($selectedAddress)) {
                return response()->json([
                    'error' => 'Input warning',
                    'message' => 'Invalid Address Selected',
                ], 400);
            }

            $get_shipadd = DeliveryCharges::where('floor_no', $selectedAddress->floor_no)
                ->where('status', 'active')
                ->selectRaw("IF(is_discount = 'true', 0, amount) as amount")
                ->first();
            if (empty($get_shipadd)) {
                return response()->json([
                    'error' => 'Input warning',
                    'message' => 'Invalid Floor Selected',
                ], 400);
            }

            $pincode = Pincode::where('pincode', $selectedAddress->zip_code)->first();
            if (empty($pincode)) {
                return response()->json([
                    'error' => 'Input warning',
                    'message' => 'Invalid pincode',
                ], 400);
            }

            // Generate transaction ID
            $txnid = Str::upper('LVJ-' . Str::random(12));

            // Retrieve validated data
            $productinfo = $this->checkNull($request->productinfo);
            $firstname = $this->checkNull($request->firstname);
            $email = $this->checkNull($request->email);
            $phone = $this->checkNull($request->phone);

            if (empty($productinfo))
                return response()->json([
                    'error' => 'Input warning',
                    'message' => 'Invalid productinfo',
                ], 400);

            if (empty($firstname))
                return response()->json([
                    'error' => 'Input warning',
                    'message' => 'Invalid firstname',
                ], 400);

            if (empty($email))
                return response()->json([
                    'error' => 'Input warning',
                    'message' => 'Invalid email',
                ], 400);

            if (empty($phone))
                return response()->json([
                    'error' => 'Input warning',
                    'message' => 'Invalid phone',
                ], 400);


            // Checking existance
            $isOrderAlreadyExist = Order::where('order_id', $orderId)->exists();

            // ----------------------------------------------- Creating Order --------------------------------------------------------------
            Owner_meta_data::select('assigned_distributor')->where('user_id', $user_details->id)->first();Owner_meta_data::select('assigned_distributor')->where('user_id', $user_details->id)->first();
            // $orderid = Str::upper('LVJ-' . Str::random(6));
            $order = new Order;
            $order->order_id = $orderId;
            $order->customer_id = $user_details->id;
            $order->selected_address_id = $selectedAddress->id;
            $order->assigned_distributor = $user_details->assigned_distributor;
            $order->payment_response = null; //now set empty
            $order->payment_type = "ease_buzz"; //default ease_buzz

            // $order->total=round(($subamt + $depositamt+$deliveramt));
            if (empty($request->payment_response)) {
                $order->payment_status = "unpaid";
            } else {
                $order->payment_status = "paid";
            }
            $order->assigned_distributor = (!empty($owners_meta_data->assigned_distributor) ? $owners_meta_data->assigned_distributor : '');
            $order->delivery_date = $request->delivery_date;
            $order->delivery_time = $this->time_slot($request->delivery_time);
            $order->status = "Order placed";
            $order->user_type = $user_details->user_type;

            $subamt = 0;
            $depositamt = 0;

            $quantity = 0;
            $discountamt = 0;
            $totalamt = 0;
            $jar_quantity = 0;
            $returnablejar_qty = 0;
            $deliveramt = 0;
            // Getting cart details
            $carts = Carts::where('customer_id', $userId)->where('status', 'active')->get();
            $jar_product_ids = Product::where('type', 'jar')
                ->whereIn('id', $carts->pluck('product_id'))
                ->pluck('id');

            foreach ($carts as $cart) {
                if ($jar_product_ids->contains($cart->product_id)) {
                    $jar_quantity += $cart->product_qty;
                } else {
                    $quantity += $cart->product_qty;
                }

                $subamt += $cart->product_qty * $cart->price;
                $depositamt += $cart->deposit_amount;
                $discountamt += $cart->discount_amount;
                $returnablejar_qty += $cart->returnablejar_qty;
            }

            $order->discount_amount = ($user_details->user_type == "customer" ? $discountamt : '');
            $order->total = ($user_details->user_type == "customer" ? (($subamt + $depositamt + $deliveramt) - $discountamt) : $subamt + $depositamt + $deliveramt);
            $order->returnablejar_qty = $returnablejar_qty;
            $order->sub_total = round($subamt);
            $order->deposit_amount = round($depositamt);
            $order->deliver_charge = round($deliveramt);

            if (!$isOrderAlreadyExist) {
                $order->save();

                foreach ($carts as $cart) {
                    $orderproducts = new OrderProducts;
                    $orderproducts->order_id = $order->id;
                    $orderproducts->product_id = $cart->product_id;
                    $orderproducts->customer_id = $userId;
                    $orderproducts->quantity = $cart->product_qty;
                    $orderproducts->amount = round($cart->price);

                    $orderproducts->no_of_jars_returned = $cart->no_of_jars_returned;
                    $orderproducts->returnablejar_qty = $cart->returnablejar_qty;
                    $orderproducts->total_amount = round($cart->product_qty * $cart->price);
                    $orderproducts->status = "active";
                    $orderproducts->save();
                }

                $shipping_address = new ShippingAddress;
                $shipping_address->order_id = $order->id;
                $shipping_address->address_id = $request->address_id;
                $shipping_address->save();
            }

            if ($jar_quantity > 0) {
                $deliveramt = $jar_quantity * (!empty($get_shipadd) ? $get_shipadd->amount : 0);
            } else {
                $deliveramt = !empty($get_shipadd) ? $get_shipadd->amount : 0;
            }

            $totalamt = $user_details->user_type == "customer" ? (($subamt + $depositamt + $deliveramt) - $discountamt) : $subamt + $depositamt + $deliveramt;
            if ($totalamt <= 0 || $totalamt != $amount) {
                return response()->json([
                    'error' => 'Input warning',
                    'message' => 'Invalid total amount. please double-check your cart',
                    "totalamt" => $totalamt,
                    "amount" => $amount,
                    "subamt" => $subamt,
                    "depositamt" => $depositamt,
                    "deliveramt" => $deliveramt,

                ], 400);
            }

            // ------------------------- Generate hash and validate its success ------------------------
            $hashed_value = $this->generate_hash($txnid, $totalamt, $productinfo, $firstname, $email);

            // Prepare POST data
            $postData = http_build_query([
                'key' => $this->easebuzz_key,
                'txnid' => $txnid, //pass order id instead of txnid
                'amount' => $totalamt,
                'productinfo' => $productinfo,
                'firstname' => $firstname,
                'phone' => $phone,
                'email' => $email,
                'surl' => 'https://lavenjal.com',
                'furl' => 'https://lavenjal.com',
                'hash' => $hashed_value,
                'salt' => $this->easebuzz_salt,
            ]);

            // Initialize cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->easebuzz_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
                'Content-Type: application/x-www-form-urlencoded',
            ]);

            // Execute cURL and check for errors
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                $error_message = curl_error($ch);
                curl_close($ch);
                throw new \Exception("cURL Error: $error_message");
            }

            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // Ensure response is valid JSON
            $decodedResponse = json_decode($response, true);
            if ($decodedResponse === null) {
                throw new \Exception('Invalid JSON response received from API.');
            }

            // Check for HTTP errors
            if ($http_status >= 400) {
                return response()->json([
                    'error' => 'API Error',
                    'message' => $decodedResponse['message'] ?? 'Unexpected error occurred.',
                ], $http_status);
            }

            // Log and return successful response
            Log::info('Payment initiated successfully.', $decodedResponse);
            return response()->json(json_decode($response, true), 200);
        } catch (\Exception $e) {
            // Handle general exceptions
            Log::error('Payment initiation failed.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'error' => 'Server Error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }



    public function generate_hash($txnid, $amount, $productinfo, $firstname, $email)
    {
        if (empty($this->easebuzz_key))
            return '';

        if (empty($this->easebuzz_salt))
            return '';

        $paymentHashString = "{$this->easebuzz_key}|{$txnid}|{$amount}|{$productinfo}|{$firstname}|{$email}|||||||||||{$this->easebuzz_salt}";
        $hashed_data = $this->generateHash($paymentHashString);

        return $hashed_data;
    }

    private function checkNull($value)
    {
        return $value === null ? '' : $value;
    }

    private function generateHash($data)
    {
        return strtolower(hash('sha512', $data));
    }


    public function payment_api(Request $request)
    {
        date_default_timezone_set("Asia/Kolkata");
        $user = Auth::user();
        $user_details = User::find($user->id);

        if (!empty($user_details)) {
            $carts = Carts::where('customer_id', $user->id)->where('status', 'active')->get();
            $orderid = Str::upper('LVJ-' . Str::random(6));
            $selectedAddress = User_address::where('user_id', $user->id)->where('is_default', 'true')->first();
            if (!empty($selectedAddress)) {
                $get_shipadd = DeliveryCharges::where('floor_no', $selectedAddress->floor_no)
                    ->where('status', 'active')
                    ->selectRaw("IF(is_discount = 'true', 0, amount) as amount")
                    ->first();

                $pincode = Pincode::where('pincode', $selectedAddress->zip_code)->first();

                if (!empty($pincode)) {
                    $selectedAddress->isServiceAvailable = true;
                } else {
                    $selectedAddress->isServiceAvailable = false;
                }
            } else {
                $get_shipadd = [];
            }
            $products = [];

            $subamt = 0;
            $depositamt = 0;
            $deliveramt = 0;
            $returnablejar_qty = 0;
            $total_available_jar = 0;
            $jars_ordered = 0;
            $quantity = 0;
            $discountamt = 0;
            foreach ($carts as $cart) {
                $product = Product::find($cart->product_id);
                $cart->product_image = url('/') . '/' . $product->image;
                if ($product->type == "jar") {
                    $jars_ordered += $cart->product_qty;
                }
                $quantity += $cart->product_qty;
                $subamt += $cart->product_qty * $cart->price;
                $depositamt += $cart->deposit_amount;
                $returnablejar_qty += $cart->no_of_jars_returned;
                $discountamt += $cart->discount_amount;
            }

            if ($jars_ordered > 0)
                $deliveramt = $jars_ordered * (!empty($get_shipadd) ? $get_shipadd->amount : 0);
            else
                $deliveramt = (!empty($get_shipadd) ? $get_shipadd->amount : '');

            //price details
            $price_details = collect([]);
            $price_details->put("sub_amount", $subamt);
            $price_details->put("deposit_amount", $depositamt);
            $price_details->put("deliver_charges", $deliveramt);
            $price_details->put("total_amount", ($user->user_type == "customer" ? (($subamt + $depositamt + $deliveramt) - $discountamt) : $subamt + $depositamt + $deliveramt));
            $price_details->put("discount_amount", ($user->user_type == "customer" ? $discountamt : ''));

            //Item details

            $item_details = collect([]);
            $item_details->put("no_of_jars_returned", $returnablejar_qty);
            $item_details->put("no_of_jars_ordered", $jars_ordered);


            $success['statuscode'] = 200;
            $success['message'] = "Payment Api";

            /**
             * params value (product_id,product_qty)
             **/
            $params = [];
            $success['params'] = $params;
            $success['orderid'] = $orderid;

            $success['selected_address'] = $selectedAddress;
            $success['products'] = $carts;
            $success['pricedetails'] = $price_details;
            $success['itemdetails'] = $item_details;

            $response['response'] = $success;
            return \Response::json($response, 200);
        } else {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return \Response::json($response, 401);
        }
    }

    public function checkout(Request $request)
    {
        try {
            date_default_timezone_set("Asia/Kolkata");
            $user = Auth::user();
            $user_details = User::find($user->id);

            if (empty($request->order_id)) {
                return \Response::json(['message' => "Order Id must not be empty", 'statusCode' => 401], 401);
            }

            if ($user_details->status != 1) {
                return \Response::json(['message' => "Your account is inactive", 'statusCode' => 401], 401);
            }

            $owners_meta_data = Owner_meta_data::select('assigned_distributor')->where('user_id', $user->id)->first();
            $get_useradd = User_address::where('id', $request->address_id)->first();
            if (!empty($get_useradd)) {
                $get_shipadd = DeliveryCharges::where('floor_no', $get_useradd->floor_no)
                    ->where('status', 'active')
                    ->selectRaw("IF(is_discount = 'true', 0, amount) as amount")
                    ->first();
            } else {
                $get_shipadd = [];
            }

            $orderid = $request->order_id;
            $carts = Carts::where('customer_id', $user->id)->where('status', 'active')->get();
            $subamt = 0;
            $depositamt = 0;
            $deliveramt = (!empty($get_shipadd) ? $get_shipadd->amount : '');
            $returnablejar_qty = 0;
            $total_available_jar = 0;
            $discountamt = 0;
            foreach ($carts as $cart) {
                $subamt += $cart->product_qty * $cart->price;
                $depositamt += $cart->deposit_amount;
                $returnablejar_qty += $cart->returnablejar_qty;
                $total_available_jar = $cart->total_available_jar;
                $discountamt += $cart->discount_amount;
                //  $deliveramt=$cart->delivery_charges;
            }

            if ($request->is_reschedule === false) {
                Order::where('order_id', $orderid)->update(['payment_response' => $request->payment_response, 'payment_status' => 'paid']);

                $orderData = Order::select('id')->where('order_id', $orderid)->first();

                //Notifications
                $u_type = ucfirst($user->user_type);
                $notifications = new Notifications;
                $notifications->user_id = $user->id;
                $notifications->order_id = $orderData->id;
                $notifications->message = "Order placed from " . $user_details->name . " " . $u_type;
                $notifications->type = "orders";
                $notifications->save();

                Mobile_notifications::where('user_id', $user->id)->where('order_id', $orderid)->where('type', 'orders')->delete();
                $notifications = new Mobile_notifications;
                $notifications->user_id = $user->id;
                $notifications->order_id = $orderData->id;
                $notifications->message = "order_placed";
                $notifications->type = "orders";
                $notifications->created_at = now();
                $notifications->save();

                $c_no_of_ordered = 0;
                $c_no_of_jars_returned = 0;

                foreach ($carts as $cart) {
                    // $c_no_of_ordered = 0;
                    // $c_no_of_jars_returned = 0;

                    $order_products = OrderProducts::where('customer_id', $user->id)->get();

                    foreach ($order_products as $p) {
                        $order = Order::where('id', $p->order_id)->first();
                        $product = Product::where('id', $p->product_id)->first();

                        if ($product && $product->type == "jar") {
                            if ($order && $order->status == "Delivery") {
                                $c_no_of_ordered += $p->quantity;
                            }
                            $c_no_of_jars_returned += $p->no_of_jars_returned;
                        }
                    }
                }

                User::where('id', $user->id)->update(['returnablejar_qty' => $c_no_of_ordered - $c_no_of_jars_returned]);

                Carts::where('customer_id', $user->id)->delete();


                // if (!empty($order_primary_id)) {
                Helper::SendNotification($orderid, "Order placed from " . $user->name . "", "checkout_customer", $orderData->id, $user->id);
                Helper::SendNotification("Hi " . $user->name . "", "Order placed from " . $user->name . "", "checkout_customernoty", $orderData->id, $user->id);
                // }
                // Helper::SendNotification($order->order_id,"Order placed from ".$user->name."","checkout_retailer",$order->id,$user->id);
                Helper::live_notification();
            } else {
                $check_order = Order::find($request->order_id);
                if (!empty($check_order)) {
                    if ($check_order->status == "Order placed") {
                        $order = Order::where('id', $request->order_id)->update(['delivery_time' => $this->time_slot($request->delivery_time), 'delivery_date' => $request->delivery_date]);
                    } else {
                        $success['statuscode'] = 200;
                        $success['message'] = "Status changed to " . $check_order->status . "";
                        /**
                         * params value (user_id,otp,token)
                         **/

                        $params = [];
                        $success['params'] = $params;
                        $response['response'] = $success;
                        return \Response::json($response, 401);
                    }
                    $notifications = new Mobile_notifications;
                    $notifications->user_id = $user->id;
                    $notifications->order_id = $request->order_id;
                    $notifications->message = "reschedule";
                    $notifications->type = "orders";
                    $notifications->created_at = now();
                    $notifications->save();
                }
            }
            //send sms to user
            $key = "QgR0kyTsNbOWkDU1";
            $mbl = $user_details->phone;
            $name = $user_details->name;
            $orderId = $request->order_id;
            $message_content = 'Dear Customer ' . $name . ',"Your order has been received, the order ID ' . $orderId . ',Thanks for shopping with us!"- BHUVIJ NOURISHMENTS PRIVATE LIMITED.';
            $encoded_message_content = urlencode($message_content);
            $senderid = "BHUVIJ";
            $route = 1;
            $templateid = "1707174124034728182";
            $sms_url = "https://sms.textspeed.in/vb/apikey.php?apikey=$key&senderid=$senderid&templateid=$templateid&number=$mbl&message=$encoded_message_content";

            $sms_response = file_get_contents($sms_url);
            if ($sms_response === FALSE) {
                return response()->json([
                    'statuscode' => 500,
                    'message' => "Failed to send message",
                    'error' => "Unable to fetch response from API"
                ], 500);
            }
            $sms_cust_data = json_decode($sms_response, true);
            if (!isset($sms_cust_data['status']) || $sms_cust_data['status'] !== 'Success') {
                return response()->json([
                    'statuscode' => $sms_cust_data['code'] ?? 400,
                    'message' => "Failed to send message",
                    'error' => $sms_cust_data['description'] ?? 'Unknown error'
                ], 400);
            }

            //send sms to admin
            $admin_mbl = "9243111520,9164640255";
            $admin_message_content = 'Dear Lavenjal, "You have received order from customer ' . $name . ' and order ID ' . $orderId . '.Please review order details on your admin panel."BHUVIJ NOURISHMENTS PRIVATE LIMITED.';
            $admin_encoded_message_content = urlencode($admin_message_content);
            $senderid = "BHUVIJ";
            $route = 1;
            $ad_templateid = "1707174124043071803";
            $sms_admin_url = "https://sms.textspeed.in/vb/apikey.php?apikey=$key&senderid=$senderid&templateid=$ad_templateid&number=$admin_mbl&message=$admin_encoded_message_content";

            $sms_admin_response = file_get_contents($sms_admin_url);
            if ($sms_admin_response === FALSE) {
                return response()->json([
                    'statuscode' => 500,
                    'message' => "Failed to send message",
                    'error' => "Unable to fetch response from API"
                ], 500);
            }
            $sms_admin_data = json_decode($sms_admin_response, true);
            if (!isset($sms_admin_data['status']) || $sms_admin_data['status'] !== 'Success') {
                return response()->json([
                    'statuscode' => $sms_admin_data['code'] ?? 400,
                    'message' => "Failed to send message",
                    'error' => $sms_admin_data['description'] ?? 'Unknown error'
                ], 400);
            }
            $success['statuscode'] = 200;
            $success['message'] = "Order saved successfully";
            $customer_name = User::select('name')->where('id', $user->id)->first();
            /**
             * params value (product_id,product_qty)
             **/
            $params['order_id'] = $orderid;
            $params['delivery_date'] = $request->delivery_date;
            // $params['delivery_time'] = $this->time_slot($request->delivery_time);
            $params['is_reschedule'] = $request->is_reschedule;
            $params['address_id'] = $request->address_id;
            $success['params'] = $params;
            $response['response'] = $success;

            return \Response::json($response, 200);
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return \Response::json($response, 401);
        }
    }

    // public function checkout(Request $request)
    // {
    //     try {
    //         date_default_timezone_set("Asia/Kolkata");
    //         $user = Auth::user();
    //         $user_details = User::find($user->id);

    //         if ($user_details->status != 1) {
    //             return \Response::json(['message' => "Your account is inactive", 'statusCode' => 401], 401);
    //         }

    //         $owners_meta_data = Owner_meta_data::select('assigned_distributor')->where('user_id', $user->id)->first();
    //         $get_useradd = User_address::where('id', $request->address_id)->first();
    //         if (!empty($get_useradd)) {
    //             $get_shipadd = DeliveryCharges::where('floor_no', $get_useradd->floor_no)
    //                 ->where('status', 'active')
    //                 ->selectRaw("IF(is_discount = 'true', 0, amount) as amount")
    //                 ->first();
    //         } else {
    //             $get_shipadd = [];
    //         }
    //         // $user_type=User::select('user_type')->where('id',$user->id)->first();
    //         //      if(!empty($owners_meta_data->assigned_distributor)){
    //         //          $checkout=true;
    //         //      }else{
    //         //          $checkout=false;
    //         //      }

    //         //      if($user_type->user_type=="customer"){
    //         //             $checkout=true;
    //         //      }else{
    //         //             $checkout=false;
    //         //      }
    //         // if( $checkout){

    //         $orderid = Str::upper('LVJ-' . Str::random(6));
    //         $carts = Carts::where('customer_id', $user->id)->where('status', 'active')->get();
    //         $subamt = 0;
    //         $depositamt = 0;
    //         $deliveramt = (!empty($get_shipadd) ? $get_shipadd->amount : '');
    //         $returnablejar_qty = 0;
    //         $total_available_jar = 0;
    //         $discountamt = 0;
    //         foreach ($carts as $cart) {
    //             $subamt += $cart->product_qty * $cart->price;
    //             $depositamt += $cart->deposit_amount;
    //             $returnablejar_qty += $cart->returnablejar_qty;
    //             $total_available_jar = $cart->total_available_jar;
    //             $discountamt += $cart->discount_amount;
    //             //  $deliveramt=$cart->delivery_charges;
    //         }

    //         if ($request->is_reschedule == false) {

    //             // $order = new Order;
    //             // $order->order_id = $orderid;
    //             // $order->customer_id = $user->id;
    //             // $order->assigned_distributor = $user->assigned_distributor;
    //             // $order->payment_response = $request->payment_response;//now set empty
    //             // $order->payment_type = $request->payment_type;//default ease_buzz

    //             // $order->sub_total = round($subamt);
    //             // $order->deposit_amount = round($depositamt);

    //             // $order->discount_amount = ($user->user_type == "customer" ? $discountamt : '');
    //             // $order->total = ($user->user_type == "customer" ? (($subamt + $depositamt + $deliveramt) - $discountamt) : $subamt + $depositamt + $deliveramt);


    //             // // $order->total=round(($subamt + $depositamt+$deliveramt));
    //             // $order->deposit_amount = round($depositamt);
    //             // $order->deliver_charge = round($deliveramt);
    //             // if (empty($request->payment_response)) {
    //             //     $order->payment_status = "unpaid";
    //             // } else {
    //             //     $order->payment_status = "paid";
    //             // }
    //             // $order->assigned_distributor = (!empty($owners_meta_data->assigned_distributor) ? $owners_meta_data->assigned_distributor : '');
    //             // $order->delivery_date = $request->delivery_date;
    //             // $order->returnablejar_qty = $returnablejar_qty;
    //             // $order->delivery_time = $this->time_slot($request->delivery_time);
    //             // $order->status = "Order placed";

    //             // $order->user_type = $user->user_type;

    //             // $order->save();

    //             $order = Order::find($request->order_id);
    //             $shipping_address = new ShippingAddress;
    //             $shipping_address->order_id = $order->id;
    //             $shipping_address->address_id = $request->address_id;
    //             $shipping_address->save();



    //             //Notifications
    //             $u_type = ucfirst($user->user_type);
    //             $notifications = new Notifications;
    //             $notifications->user_id = $user->id;
    //             $notifications->order_id = $order->id;
    //             $notifications->message = "Order placed from " . $user_details->name . " " . $u_type;
    //             $notifications->type = "orders";
    //             $notifications->save();

    //             Mobile_notifications::where('user_id', $user->id)->where('order_id', $order->id)->where('type', 'orders')->delete();
    //             $notifications = new Mobile_notifications;
    //             $notifications->user_id = $user->id;
    //             $notifications->order_id = $order->id;
    //             $notifications->message = "order_placed";
    //             $notifications->type = "orders";
    //             $notifications->created_at = now();
    //             $notifications->save();
    //             $c_no_of_ordered = 0;
    //             $c_no_of_jars_returned = 0;

    //             foreach ($carts as $cart) {


    //                 // $orderproducts = new OrderProducts;
    //                 // $orderproducts->order_id = $order->id;
    //                 // $orderproducts->product_id = $cart->product_id;
    //                 // $orderproducts->customer_id = $user->id;
    //                 // $orderproducts->quantity = $cart->product_qty;
    //                 // $orderproducts->amount = round($cart->price);

    //                 // $orderproducts->no_of_jars_returned = $cart->no_of_jars_returned;
    //                 // $orderproducts->returnablejar_qty = $cart->returnablejar_qty;
    //                 // $orderproducts->total_amount = round($cart->product_qty * $cart->price);
    //                 // $orderproducts->status = "active";
    //                 // $orderproducts->save();


    //                 $c_no_of_ordered = 0;
    //                 $c_no_of_jars_returned = 0;

    //                 $order_products = OrderProducts::where('customer_id', $user->id)->get();

    //                 foreach ($order_products as $p) {
    //                     $order = Order::where('id', $p->order_id)->first();
    //                     $product = Product::where('id', $p->product_id)->first();

    //                     if ($product && $product->type == "jar") {
    //                         if ($order && $order->status == "Delivery") {
    //                             $c_no_of_ordered += $p->quantity;
    //                         }
    //                         $c_no_of_jars_returned += $p->no_of_jars_returned;
    //                     }
    //                 }
    //                 User::where('id', $user->id)->update(['returnablejar_qty' => $c_no_of_ordered - $c_no_of_jars_returned]);


    //                 Carts::where('customer_id', $user->id)->delete();


    //                 // Helper::SendNotification($order->order_id,"Order placed from ".$user->name."","checkout",$order->id,$user->id);


    //                 Helper::SendNotification($order->order_id, "Order placed from " . $user->name . "", "checkout_customer", $order->id, $user->id);
    //                 Helper::SendNotification("Hi " . $user->name . "", "Order placed from " . $user->name . "", "checkout_customernoty", $order->id, $user->id);
    //                 // Helper::SendNotification($order->order_id,"Order placed from ".$user->name."","checkout_retailer",$order->id,$user->id);
    //                 Helper::live_notification();
    //             }
    //         }
    //         else {

    //             $check_order = Order::find($request->order_id);
    //             if (!empty($check_order)) {
    //                 if ($check_order->status == "Order placed") {
    //                     $order = Order::where('id', $request->order_id)->update(['delivery_time' => $this->time_slot($request->delivery_time), 'delivery_date' => $request->delivery_date]);

    //                 } else {
    //                     $success['statuscode'] = 200;
    //                     $success['message'] = "Status changed to " . $check_order->status . "";
    //                     /**
    //                      * params value (user_id,otp,token)
    //                      **/

    //                     $params = [];
    //                     $success['params'] = $params;
    //                     $response['response'] = $success;
    //                     return \Response::json($response, 401);
    //                 }
    //                 $notifications = new Mobile_notifications;
    //                 $notifications->user_id = $user->id;
    //                 $notifications->order_id = $request->order_id;
    //                 $notifications->message = "reschedule";
    //                 $notifications->type = "orders";
    //                 $notifications->created_at = now();
    //                 $notifications->save();
    //             }
    //         }
    //         // $order_products=OrderProducts::where('customer_id',$user->id)->get();

    //         // foreach($order_products as $p){
    //         //     $order=Order::where('id',$p->order_id)->first();
    //         //     $product=Product::where('id',$p->product_id)->first();

    //         //       if($product->type=="jar" && $order->status=="Delivery"){

    //         //         $c_no_of_ordered+=$p->quantity;
    //         //         $c_no_of_jars_returned+=$p->no_of_jars_returned;
    //         //     }
    //         // }
    //         //  $user->update(['returnablejar_qty'=>$c_no_of_ordered- $c_no_of_jars_returned]);
    //         //  Carts::where('customer_id',$user->id)->delete();



    //         $success['statuscode'] = 200;
    //         $success['message'] = "Order saved successfully";
    //         $customer_name = User::select('name')->where('id', $user->id)->first();
    //         /**
    //          * params value (product_id,product_qty)
    //          **/
    //         $params['order_id'] = $request->order_id;
    //         $params['delivery_date'] = $request->delivery_date;
    //         $params['delivery_time'] = $this->time_slot($request->delivery_time);
    //         $params['is_reschedule'] = $request->is_reschedule;
    //         $params['address_id'] = $request->address_id;
    //         $success['params'] = $params;
    //         $response['response'] = $success;

    //         // Helper::SendNotification("Order","New Order ".$orderid ." from ".$customer_name->name);
    //         try {
    //             // event(new NewEvent($orderid));
    //         } catch (Exception $e) {
    //             $success['statuscode'] = 401;
    //             $success['message'] = "Something went wrong";
    //             /**
    //              * params value (user_id,otp,token)
    //              **/
    //             $params = [];
    //             $success['params'] = $params;
    //             $response['response'] = $success;
    //             return \Response::json($response, 401);
    //         }
    //         return \Response::json($response, 200);
    //         //  }
    //         // else{
    //         //         $success['statuscode'] =401;
    //         //         $success['message']="Distributor not assigned";
    //         //         $params=[];
    //         //         $success['params']=$params;
    //         //         $response['response']=$success;
    //         //         return \Response::json($response, 401);
    //         // }

    //         // print_r($this->time_slot($request->timeslot));
    //     } catch (Exception $e) {
    //         $success['statuscode'] = 401;
    //         $success['message'] = "Something went wrong";
    //         /**
    //          * params value (user_id,otp,token)
    //          **/
    //         $params = [];
    //         $success['params'] = $params;
    //         $response['response'] = $success;
    //         return \Response::json($response, 401);
    //     }
    // }

    public function order_lists()
    {
        try {
            $user = Auth::user();

            $user_filter_type = "customer_id";

            if ($user->user_type == 'delivery_agent')
                $user_filter_type = "assigned_deliveryboy";

            $orders = Order::select('order_id', 'total', 'created_at', 'delivery_date', 'status', 'id', 'delivery_time')->where($user_filter_type, $user->id)->orderBy('id', 'desc')->where('payment_status', 'paid')->get();

            $track_orders = Order::select('order_id', 'total', 'created_at', 'delivery_date', 'status', 'id', 'delivery_time')->where($user_filter_type, $user->id)->orderBy('id', 'desc')->where('status', '!=', 'Delivery')->where('payment_status', 'paid')->get();

            foreach ($orders as $key => $order) {

                //$selectedSlot=$this->time_slot(array_keys($order->delivery_time));
                $arrays = array_flip($this->time());

                $orders[$key]['selecedSlot'] = $arrays[$order->delivery_time];
                $itemscnt = 0;
                $ord = Orderproducts::where('order_id', $order->id)->get();
                foreach ($ord as $o) {


                    $order_products = Orderproducts::find($o->id);
                    foreach ($order_products->product as $product) {
                        if ($product->type == "jar") {
                            $itemscnt += $order_products->quantity;
                        }
                    }
                }
                // $order_product = Orderproducts::where('order_id', $order->id)->sum('quantity');
                $sum_jar = Orderproducts::where('order_id', $order->id)->sum('no_of_jars_returned');




                $orders[$key]['items_count'] = $itemscnt;
                $orders[$key]['no_of_returnable_jar'] = $sum_jar;
                if ($order->status == "Delivery") {
                    $order->status = "Delivered";
                }
                $orders[$key]['created_date'] = $order->delivery_date;
                $orders[$key]['ord_id'] = $order['order_id'];
                $orders[$key]['order_id'] = $order['id'];
            }






            foreach ($track_orders as $key => $order) {

                $itemscnt = 0;
                $ord = Orderproducts::where('order_id', $order->id)->get();
                foreach ($ord as $o) {
                    $order_products = Orderproducts::find($o->id);
                    foreach ($order_products->product as $product) {
                        if ($product->type == "jar") {
                            $itemscnt += $order_products->quantity;
                        }
                    }
                }
                // $order_product = Orderproducts::where('order_id', $order->id)->sum('quantity');
                $sum_jar = Orderproducts::where('order_id', $order->id)->sum('no_of_jars_returned');




                $track_orders[$key]['items_count'] = $itemscnt;
                $track_orders[$key]['no_of_returnable_jar'] = $sum_jar;
                if ($order->status == "Delivery") {
                    $order->status = "Delivered";
                }
                $track_orders[$key]['created_date'] = $order->delivery_date;
                $track_orders[$key]['ord_id'] = $order['order_id'];
                $track_orders[$key]['order_id'] = $order['id'];
            }

            $success['statuscode'] = 200;
            $success['message'] = "Orders lists";

            /**
             * params value (product_id,product_qty)
             **/
            $params = [];
            $success['params'] = $params;
            $success['orders'] = $orders;

            $success['track_order'] = $track_orders;

            $response['response'] = $success;
            return \Response::json($response, 200);
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return \Response::json($response, 401);
        }
    }


    public function order_details(Request $request)
    {
        try {
            $user = Auth::user();

            $orders = Order::select('order_id', 'sub_total', 'tax_rate', 'created_at', 'status', 'total', 'deposit_amount', 'discount_amount', 'deliver_charge', 'id', 'delivery_date', 'delivery_time', 'returnablejar_qty', 'customer_id')->where('id', $request->order_id)->orderBy('id', 'desc')->first();

            $customer = User::select('id', 'name')->where('id', $orders->customer_id)->first();
            $orders['customer_name'] = $customer->name;


            if (!empty($orders)) {
                $itemscnt = 0;
                $ord = Orderproducts::where('order_id', $request->order_id)->get();
                foreach ($ord as $o) {
                    $order_product = Orderproducts::find($o->id);
                    foreach ($order_product->product as $key => $product) {
                        if ($product->type == "jar") {
                            $itemscnt += $order_product->quantity;
                        }
                    }
                }
                // $no_of_jars_ordered = Orderproducts::where('order_id', $request->order_id)->sum('quantity');
                $sum_jar = Orderproducts::where('order_id', $orders->id)->sum('no_of_jars_returned');
                $orders->items_count = $itemscnt;
                $orders->no_of_returnable_jar = $sum_jar;


                $ship_address = ShippingAddress::where('order_id', $orders->id)->first();

                $user_address = User_address::where('id', $ship_address->address_id)->first();
                if (!empty($user_address)) {
                    $orders['address'] = $user_address->address . ', ' . $user_address->city . ', ' . $user_address->state . ', ' . $user_address->zip_code;
                } else {
                    $orders['address'] = "";
                }

                $orders['floor_no'] = $user_address->floor_no;
                $orders['created_date'] = $orders->delivery_date;
            }

            $orderdetails = OrderProducts::where('order_id', $request->order_id)->get();
            $productdetails = [];
            $url = url('/');
            foreach ($orderdetails as $key => $orderdetail) {
                $product = Product::where('id', $orderdetail->product_id)->first();
                if (!empty($product)) {
                    $img = $url . '/' . $product->image;
                } else {
                    $img = "";
                }
                $productdetails[$key]['product_img'] = $img;
                $productdetails[$key]['product_name'] = (!empty($product) ? $product->name : '');
                $productdetails[$key]['amount'] = $orderdetail->amount;
                $productdetails[$key]['product_qty'] = $orderdetail->quantity;
                $productdetails[$key]['returnablejar_qty'] = $orderdetail->returnablejar_qty;
            }

            $ord_date = Order::select('on_the_way_date', 'cancelled_date', 'O_delivery_date', 'delivery_date', 'created_at')->where('id', $request->order_id)->first();
            $order_date['order_placed_date'] = (!empty($ord_date->delivery_date) ? Carbon::parse($ord_date->delivery_date)->format('d-m-Y') : '');
            // $order_date['on_the_way_date']=(!empty($ord_date->on_the_way_date)?$ord_date->on_the_way_date:'');
            $order_date['on_the_way_date'] = (!empty($ord_date->on_the_way_date) ? Carbon::parse($ord_date->on_the_way_date)->format('d-m-Y') : '');
            $order_date['delivery_date'] = (!empty($ord_date->O_delivery_date) ? Carbon::parse($ord_date->O_delivery_date)->format('d-m-Y') : '');
            $order_date['cancelled_date'] = (!empty($ord_date->cancelled_date) ? Carbon::parse($ord_date->cancelled_date)->format('d-m-Y') : '');
            // $order_date['order_placed_date']=$order_date->created_at->format('Y-m-d');

            $success['statuscode'] = 200;
            $success['message'] = "Orders lists";

            /**
             * params value (product_id,product_qty)
             **/
            $params['order_id'] = $request->order_id;
            $params['user_id'] = $user->id;
            $success['params'] = $params;
            $success['orders'] = $orders;
            $success['orders_date'] = $order_date;
            $success['product_details'] = $productdetails;
            $success['returnablejar_qty'] = (!empty($orders) ? $orders->returnablejar_qty : '');
            $success['no_of_jars_available'] = (!empty($orders) ? Orderproducts::where('order_id', $orders->id)->sum('quantity') : '0');
            $response['response'] = $success;
            return \Response::json($response, 200);
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return \Response::json($response, 401);
        }
    }

    public function distributor_orderLists(Request $request)
    {

        try {

            $user = Auth::user();

            if (!empty($user)) {
                if ($user->user_type == "distributor") {
                    $orderplaced = array();
                    $orders = Order::select('order_id', 'total', 'created_at', 'status', 'id', 'customer_id', 'delivery_date', 'delivery_time')->orderBy('updated_at', 'desc')->where('assigned_distributor', $user->id)->where('status', $request->status)->limit($request->count)->get();
                    $orderplaced['data'] = [];
                    foreach ($orders as $key => $order) {
                        $customer = User::select('id', 'name')->where('id', $order->customer_id)->first();
                        $orders[$key]['created_date'] = $order->delivery_date;
                        $orders[$key]['customer_name'] = $customer->name;
                        $orders[$key]['km'] = "";
                        $order_products = Orderproducts::where('order_id', $order->id)->count();
                        $order->product_quantity = $order_products;

                        $orderplaced['data'] = $orders;
                    }

                    $success['statuscode'] = 200;
                    $success['message'] = "Orders lists";
                    /**
                     * params value (product_id,product_qty)
                     **/
                    $params['count'] = $request->count;
                    $success['params'] = $params;
                    $success['orders'] = $orderplaced;
                    $response['response'] = $success;
                    return \Response::json($response, 200);
                } else {
                    $success['statuscode'] = 401;
                    $success['message'] = "Please login as distributor";
                    $params = [];
                    $success['params'] = $params;
                    $response['response'] = $success;
                    return \Response::json($response, 401);
                }
            } else {
                $success['statuscode'] = 401;
                $success['message'] = "Please login";
                $params = [];
                $success['params'] = $params;
                $response['response'] = $success;
                return \Response::json($response, 401);
            }
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return \Response::json($response, 401);
        }
    }



    public function distributor_orderDetails(Request $request)
    {
        try {
            $user = Auth::user();

            if ($user->user_type == "distributor" || $user->user_type == "delivery_agent") {
                $address_table = User_address::select('lat', 'lang')->where('user_id', $user->id)->first();
                if (!empty($address_table)) {
                    $lat = $address_table->lat;
                    $lang = $address_table->lang;
                    $orders = Order::join('shipping_address', 'orders.id', '=', 'shipping_address.order_id')->join('user_addresses', 'shipping_address.address_id', '=', 'user_addresses.id')->where('orders.id', $request->order_id)->select('orders.order_id', "user_addresses.lat as customer_lat", "user_addresses.lang as customer_lang", 'orders.sub_total', 'orders.total', 'orders.created_at', 'orders.status', 'orders.total', 'orders.id', 'orders.deposit_amount', 'orders.deliver_charge', 'orders.delivery_date', 'orders.returnablejar_qty', 'orders.delivery_time', 'orders.customer_id', DB::raw("COALESCE(6371 * acos(cos(radians(" . $lat . ")) 
                        * cos(radians(user_addresses.lat)) 
                        * cos(radians(user_addresses.lang) 
                        - radians(" . $lang . ")) 
                        + sin(radians(" . $lat . ")) 
                        * sin(radians(user_addresses.lat))),0) AS distance"))

                        ->first();
                    $customer = User_address::select('id', 'full_name')->where('user_id', $orders->customer_id)->first();
                    if (!empty($orders)) {
                        $orders['created_date'] = $orders->delivery_date;
                        $orders['delivery_time'] = $orders->delivery_time;
                        $orders['customer_name'] = isset($customer) ? $customer->full_name : '';



                        $dist = $this->map($lat, $lang, $orders->customer_lat, $orders->customer_lang);
                        $kms = str_replace(',', '.', $dist);
                        $whatIWant = substr($kms, strpos($kms, " ") + 1);
                        if ($whatIWant == "km") {
                            $kms = str_replace('km', '', $kms);
                        } else {
                            $kms = str_replace('m', '', $kms);
                            $kms = $kms / 1000;
                        }

                        $orders['kms'] = ($kms);


                        // $orders['kms']=round($orders->distance,2);
                        $order_products = Orderproducts::where('order_id', $orders->id)->count();
                        $orders['product_quantity'] = $order_products;
                        $ship_address = ShippingAddress::where('order_id', $orders->id)->first();
                        $user_address = User_address::where('id', $ship_address->address_id)->first();
                        // $orders['address']=(!empty($user_address->address) ?$user_address->address:''). ', '.(!empty($user_address->city)?$user_address->city:''). ', '.(!empty($user_address->state)?$user_address->state:''). ', '.(!empty($user_address->zip_code)?$user_address->zip_code:'');
                        if (!empty($user_address)) {
                            $orders['address'] = $user_address->address . ', ' . $user_address->city . ', ' . $user_address->state . ', ' . $user_address->zip_code;
                        } else {

                            $orders['address'] = "";
                        }
                        
                        
                        $orders->no_of_jars_ordered = 0;
                        $ordered_products = Orderproducts::select('product_id')->where('order_id', $orders->id)->get();

                        if ($ordered_products->isNotEmpty()) {
                            // Get all product IDs related to the order
                            $productIds = $ordered_products->pluck('product_id');

                            // Check for products of type 'jar'
                            $jar_product_ids = Product::whereIn('id', $productIds)
                                ->where('type', 'jar')
                                ->pluck('id');

                            if ($jar_product_ids->isNotEmpty()) {
                                // Sum quantities only for products that are 'jar'
                                $orders->no_of_jars_ordered = Orderproducts::where('order_id', $orders->id)
                                    ->whereIn('product_id', $jar_product_ids)
                                    ->sum('quantity');
                            }
                        }

                        $orders['no_of_jars_available'] = $orders->no_of_jars_ordered;
                        // $orders['no_of_jars_available'] = Orderproducts::where('order_id', $orders->id)->sum('quantity');
                        $orders['no_of_jars_returned'] = Orderproducts::where('order_id', $orders->id)->sum('no_of_jars_returned');
                    }

                    $orderdetails = OrderProducts::where('order_id', $request->order_id)->get();
                    $productdetails = [];
                    $url = url('/');
                    foreach ($orderdetails as $key => $orderdetail) {
                        $product = Product::where('id', $orderdetail->product_id)->first();
                        $productdetails[$key]['product_img'] = $url . '/' . (!empty($product) ? $product->image : '');
                        $productdetails[$key]['product_name'] = (!empty($product) ? $product->name : '');
                        $productdetails[$key]['amount'] = $orderdetail->amount;
                        $productdetails[$key]['product_qty'] = $orderdetail->quantity;
                        $productdetails[$key]['returnablejar_qty'] = $orderdetail->returnablejar_qty;
                    }
                    $S_address = collect([]);
                    $shipping_address = ShippingAddress::where('order_id', $orders->id)->first();
                    if (!empty($shipping_address)) {
                        $ordered_address = User_address::where('id', $ship_address->address_id)->withTrashed()->first();
                        $S_address = $ordered_address;
                    } else {
                        $S_address = [];
                    }


                    $U_address = collect([]);
                    $user_address = User_address::where('user_id', $user->id)->where('is_default', 'true')->first();

                    if (!empty($user_address)) {
                        $U_address = $user_address;
                    } else {
                        $U_address = [];
                    }




                    $success['statuscode'] = 200;
                    $success['message'] = "Orders lists";

                    /**
                     * params value (product_id,product_qty)
                     **/
                    $params['status'] = $request->status;
                    $params['user_id'] = $user->id;
                    $success['params'] = $params;
                    $success['orders'] = $orders;
                    $success['product_details'] = $productdetails;
                    $success['address'] = $S_address;
                    $success['lat_lang'] = $U_address;
                    $response['response'] = $success;
                    return \Response::json($response, 200);
                } else {
                    $success['statuscode'] = 200;
                    $success['message'] = "Address list empty";
                    $params = [];
                    $success['params'] = $params;
                    $response['response'] = $success;
                    return \Response::json($response, 401);
                }
            } else {
                $success['statuscode'] = 401;
                $success['message'] = "Please login";
                $params = [];
                $success['params'] = $params;
                $response['response'] = $success;
                return \Response::json($response, 401);
            }
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return \Response::json($response, 401);
        }
    }

    public function report_details(Request $request)
    {
        try {
            $user = Auth::user();
            $report_count = collect([]);
            if (!empty($user)) {
                $order_placed = Order::select('status')->where('status', 'Order placed')->where('payment_status', 'paid')->get();
                $on_the_way = Order::select('status')->where('assigned_deliveryboy', $user->id)->where('status', 'On the way')->get();
                $delivery = Order::select('status')->where('assigned_deliveryboy', $user->id)->where('status', 'Delivery')->get();
                $cancelled = Order::select('status')->where('assigned_deliveryboy', $user->id)->where('status', 'Cancelled')->get();

                $report_count->put("order_placed", count($order_placed));
                $report_count->put("on_the_way", count($on_the_way));
                $report_count->put("delivery", count($delivery));
                $report_count->put("cancelled", count($cancelled));

                $success['statuscode'] = 200;
                $success['message'] = "Report details";

                /**
                 * params value (product_id,product_qty)
                 **/
                $params = [];
                $success['params'] = $params;
                $success['orders'] = $report_count;
                $response['response'] = $success;
                return \Response::json($response, 200);
            } else {
                $success['statuscode'] = 401;
                $success['message'] = "Please login";
                $params = [];
                $success['params'] = $params;
                $response['response'] = $success;
                return \Response::json($response, 401);
            }
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return \Response::json($response, 401);
        }
    }

    private function deg2rad($deg)
    {
        return $deg * (3.14159 / 180);
    }

    //Delivery orders
    public function delivery_orderLists(Request $request)
    {

        try {
            $user = Auth::user();
            if (!empty($user)) {
                $user_table = User::find($user->id);
                
                
                if(empty($user_table)) {
                    $success['statuscode'] = 401;
                    $success['message'] = "User not found";

                    $success['params'] = [];
                    $response['response'] = $success;
                    return \Response::json($response, 401);
                }
                
                $owner_meta_data = Owner_meta_data::where('user_id', $user_table->id)->first();
                
                
                if(empty($owner_meta_data)) {
                    $success['statuscode'] = 401;
                    $success['message'] = "User not found";

                    $success['params'] = [];
                    $response['response'] = $success;
                    return \Response::json($response, 401);
                }
                
                
                if($owner_meta_data->status == 0) {
                    $success['statuscode'] = 401;
                    $success['message'] = "We're on it! Your account will be ready shortly.";

                    $success['params'] = [];
                    $response['response'] = $success;
                    return \Response::json($response, 401);
                }


                if ($user_table->user_type == "delivery_agent") {
                    $address_table = User_address::select('lat', 'lang')->where('user_id', $user_table->id)->first();
                    if (!empty($address_table)) {
                        $lat = $address_table->lat;
                        $lang = $address_table->lang;

                        $orderss = Order::join('shipping_address', 'orders.id', '=', 'shipping_address.order_id')->join('user_addresses', 'shipping_address.address_id', '=', 'user_addresses.id')->join('users', 'user_addresses.user_id', '=', 'users.id')->select(
                            "orders.delivery_time",
                            "user_addresses.lat as customer_lat",
                            "user_addresses.lang as customer_lang",
                            "orders.id as order_id",
                            "orders.order_id as ord_id",
                            "users.status as user_status",
                            "orders.created_at as ord_created_at",
                            'orders.delivery_date',
                            "orders.total",
                            "orders.status as order_status",
                            'user_addresses.*',
                            'orders.returnablejar_qty',
                            'shipping_address.*',
                            DB::raw("COALESCE(6371 * acos(cos(radians(" . $lat . ")) 
                        * cos(radians(user_addresses.lat)) 
                        * cos(radians(user_addresses.lang) 
                        - radians(" . $lang . ")) 
                        + sin(radians(" . $lat . ")) 
                        * sin(radians(user_addresses.lat))),0) AS distance")
                        )

                            ->where('orders.status', $request->status)
                            ->where('orders.payment_status', 'paid')
                            ->where('orders.user_type', 'customer');

                        if ($request->status != "Order placed") {
                            $orderss->orderBy('orders.updated_at', 'desc');
                            $orderss->where('orders.assigned_deliveryboy', $user->id);
                        } else {
                            $orderss->orderBy('orders.id', 'desc');
                        }
                        $orders = $orderss->get();
                        $success['statuscode'] = 200;
                        $success['message'] = "Delivery boy order lists";

                        /**
                         * params value (product_id,product_qty)
                         **/
                        $ord = array();

                        foreach ($orders as $key => $order) {


                            $dist = $this->map($lat, $lang, $order->customer_lat, $order->customer_lang);
                            $kms = str_replace(',', '.', $dist);



                            $whatIWant = substr($kms, strpos($kms, " ") + 1);

                            if ($whatIWant == "km") {

                                $kms = str_replace('km', '', $kms);
                            } else {

                                $kms = str_replace('m', '', $kms);
                                $kms = $kms / 1000;
                            }

                            if ((number_format($kms, 2)) <= 5.0) {
                                $order_products = Orderproducts::where('order_id', $order->order_id)->count();
                                $order->product_quantity = $order_products;
                                $order->created_date = $order->delivery_date;
                                $order->delivery_time = $order->delivery_time;
                                $order->kms = ($kms);

                                $order->no_of_jars_ordered = 0;
                                $ordered_products = Orderproducts::select('product_id')->where('order_id', $order->order_id)->get();

                                if ($ordered_products->isNotEmpty()) {
                                    // Get all product IDs related to the order
                                    $productIds = $ordered_products->pluck('product_id');

                                    // Check for products of type 'jar'
                                    $jar_product_ids = Product::whereIn('id', $productIds)
                                        ->where('type', 'jar')
                                        ->pluck('id');

                                    if ($jar_product_ids->isNotEmpty()) {
                                        // Sum quantities only for products that are 'jar'
                                        $order->no_of_jars_ordered = Orderproducts::where('order_id', $order->order_id)
                                            ->whereIn('product_id', $jar_product_ids)
                                            ->sum('quantity');
                                    }
                                }

                                // Sum all no_of_jars_returned instead of fetching the first one
                                $order->no_of_jars_returned = Orderproducts::where('order_id', $order->order_id)->sum('no_of_jars_returned');

                                array_push($ord, $order);
                            } else {

                                unset($orders[$key]);
                            }
                        }
                        $params['lat'] = $lat;
                        $params['lang'] = $lang;

                        $success['orders'] = $ord;
                        $success['params'] = $params;
                        $response['response'] = $success;
                        return \Response::json($response, 200);
                    } else {
                        $success['statuscode'] = 401;
                        $success['message'] = "Address list empty";
                        $params = [];
                        $success['params'] = $params;
                        $response['response'] = $success;
                        return \Response::json($response, 401);
                    }
                } else if ($user_table->user_type == "distributor") {

                    $user_status = $user->user_status;
                    $address_table = User_address::select('lat', 'lang')->where('user_id', $user_table->id)->first();
                    if (!empty($address_table)) {
                        $lat = $address_table->lat;
                        $lang = $address_table->lang;
                        $orders = Order::
                            // ->join('user_addresses','shipping_address.address_id','=','user_addresses.id')

                            //old
                            // join('shipping_address','orders.id','=','shipping_address.order_id')->join('owners_meta_data','owners_meta_data.user_id','=','orders.customer_id')
                            // ->select("orders.id","orders.delivery_time","orders.order_id as ord_id","orders.assigned_distributor","orders.created_at as ord_created_at","orders.total","orders.status as order_status",'shipping_address.*',"owners_meta_data.name_of_owner as full_name")
                            // ->where('orders.status','=',$request->status)
                            // // ->where('orders.customer_id',188)
                            // ->where('orders.assigned_distributor',$user->id)
                            // ->orderBy('orders.id','desc')
                            // ->get();

                            join('shipping_address', 'orders.id', '=', 'shipping_address.order_id')->join('user_addresses', 'shipping_address.address_id', '=', 'user_addresses.id')->join('owners_meta_data', 'owners_meta_data.user_id', '=', 'orders.customer_id')
                            ->select("orders.delivery_time", "user_addresses.lat as customer_lat", "user_addresses.lang as customer_lang", "orders.id as order_id", "orders.order_id as ord_id", "orders.assigned_distributor", "orders.created_at as ord_created_at", "orders.total", "orders.status as order_status", 'shipping_address.*', 'orders.returnablejar_qty', "owners_meta_data.name_of_owner as full_name", "user_addresses.*", DB::raw("COALESCE(6371 * acos(cos(radians(" . $lat . ")) 
                                    * cos(radians(user_addresses.lat)) 
                                    * cos(radians(user_addresses.lang) 
                                    - radians(" . $lang . ")) 
                                    + sin(radians(" . $lat . ")) 
                                    * sin(radians(user_addresses.lat))),0) AS distance"))

                            ->where('orders.status', '=', $request->status)
                            // ->where('orders.customer_id',188)
                            ->where('orders.assigned_distributor', $user->id)
                            ->orderBy('orders.id', 'desc')
                            ->get();



                        $success['statuscode'] = 200;
                        $success['message'] = "Distributor order lists";

                        /**
                         * params value (product_id,product_qty)
                         **/
                        $ord = array();
                        foreach ($orders as $key => $order) {

                            $dist = $this->map($lat, $lang, $order->customer_lat, $order->customer_lang);
                            $kms = str_replace(',', '.', $dist);
                            $whatIWant = substr($kms, strpos($kms, " ") + 1);
                            if ($whatIWant == "km") {
                                $kms = str_replace('km', '', $kms);
                            } else {
                                $kms = str_replace('m', '', $kms);
                                $kms = $kms / 1000;
                            }
                            if ((number_format($kms, 2)) <= 5.0) {

                                $order_products = Orderproducts::where('order_id', $order->id)->count();
                                $order->product_quantity = $order_products;
                                $order->created_date = $order->delivery_date;
                                $order->delivery_time = $order->delivery_time;

                                $order->kms = ($kms);
                                // $order->kms=round($order->distance,2);
                                $order->no_of_jars_available = Orderproducts::where('order_id', $order->id)->sum('quantity');
                                $order->no_of_jars_returned = Orderproducts::where('order_id', $order->id)->sum('no_of_jars_returned');
                                array_push($ord, $order);
                            } else {

                                unset($orders[$key]);
                            }
                        }
                        $params = [];
                        $success['orders'] = $ord;
                        $success['params'] = $params;
                        $response['response'] = $success;
                        return \Response::json($response, 200);
                    } else {
                        $success['statuscode'] = 401;
                        $success['message'] = "Address list empty";
                        $params = [];
                        $success['params'] = $params;
                        $response['response'] = $success;
                        return \Response::json($response, 401);
                    }
                } else {
                    $success['statuscode'] = 401;
                    $success['message'] = "Invalid Login user type";
                    $params = [];
                    $success['params'] = $params;
                    $response['response'] = $success;
                    return \Response::json($response, 401);
                }
            } else {
                $success['statuscode'] = 401;
                $success['message'] = "Please login";
                $params = [];
                $success['params'] = $params;
                $response['response'] = $success;
                return \Response::json($response, 401);
            }
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return \Response::json($response, 401);
        }
    }


    public function deliveryboy_order_status(Request $request)
    {
        try {
            date_default_timezone_set("Asia/Kolkata");
            $user = Auth::user();
            if (!empty($user)) {

                $user_table = User::find($user->id);
                if (!empty($user_table)) {



                    $check_status = Order::where('id', $request->order_id)->first();

                    if (!empty($check_status)) {
                        $custdetails = User::find($check_status->customer_id);
                        $order_details = Orderproducts::where('order_id', $check_status->id)->get();

                        if ($user->user_type == "delivery_agent") {
                            if (!empty($request->status) && $request->status != "Delivery") {
                                $check_order_already_assign_del_boy = Order::where('id', $request->order_id)
                                    ->where('status', 'On the way')
                                    ->exists();

                                if ($check_order_already_assign_del_boy) {
                                    $success['statuscode'] = 400;
                                    $success['message'] = "This Order has already been assigned";
                                    $params = [];
                                    $success['params'] = $params;
                                    $response['response'] = $success;
                                    return \Response::json($response, 400);
                                }
                            }
                                
                            if (empty($check_status->assigned_deliveryboy) || $check_status->assigned_deliveryboy == $user->id) {
                                $on_the_waydate = $check_status->on_the_way_date;
                                $cancelled_date = $check_status->cancelled_date;
                                $delivered_date = $check_status->O_delivery_date;
                                $delivered_time = $check_status->O_delivery_time;
                                if ($request->status == "Delivery") {
                                    $delivered_date = date("Y-m-d");
                                    $delivered_time = date("h:i:sa");
                                }

                                if ($request->status == "On the way") {
                                    $on_the_waydate = date("Y-m-d");
                                    $cancelled_date = $check_status->cancelled_date;
                                } else if ($request->status == "Cancelled") {
                                    $on_the_waydate = $check_status->on_the_way_date;
                                    $cancelled_date = date("Y-m-d");
                                }

                                Order::where('id', $request->order_id)->update(['status' => $request->status, 'assigned_deliveryboy' => $user->id, 'O_delivery_date' => $delivered_date, 'O_delivery_time' => $delivered_time, 'on_the_way_date' => $on_the_waydate, 'cancelled_date' => $cancelled_date]);

                                $c_no_of_ordered = 0;
                                $c_no_of_jars_returned = 0;

                                $order_products = OrderProducts::where('customer_id', $check_status->customer_id)->get();

                                foreach ($order_products as $p) {
                                    $order = Order::where('id', $p->order_id)->where('status', 'Delivery')->where('selected_address_id', $check_status->selected_address_id)->first();

                                    if (!empty($order)) {
                                        $product = Product::where('id', $p->product_id)->first();

                                        if (!empty($product)) {
                                            if ($product->type == "jar") {
                                                $c_no_of_ordered += $p->quantity;
                                                $c_no_of_jars_returned += $p->no_of_jars_returned;
                                            }
                                        }
                                    }
                                }

                                // User::where('id', $check_status->customer_id)->update(['returnablejar_qty' => $c_no_of_ordered - $c_no_of_jars_returned]);
                                User_address::where('id', $check_status->selected_address_id)->update(['returnablejar_qty' => $c_no_of_ordered - $c_no_of_jars_returned]);

                                Mobile_notifications::where('user_id', $check_status->customer_id)->where('order_id', $request->order_id)->where('type', 'orders')->delete();
                                if ($check_status->status == "Order placed") {

                                    //Notifications
                                    $notifications = new Notifications;
                                    $notifications->user_id = $check_status->customer_id;
                                    $notifications->order_id = $request->order_id;
                                    $notifications->message = $check_status->order_id . " Order has been accepted by " . $user_table->name . " Delivery boy";
                                    $notifications->type = "orders";
                                    $notifications->save();

                                    $notifications = new Mobile_notifications;
                                    $notifications->user_id = $check_status->customer_id;
                                    $notifications->order_id = $request->order_id;
                                    $notifications->message = "on_the_way";
                                    $notifications->type = "orders";
                                    $notifications->created_at = now();
                                    $notifications->save();
                                }
                                //Notifications
                                $notifications = new Notifications;
                                $notifications->user_id = $check_status->customer_id;
                                $notifications->order_id = $request->order_id;
                                $notifications->message = $check_status->order_id . "Order status changed to " . $request->status . "";
                                $notifications->type = "orders";
                                $notifications->status = "status_update";
                                $notifications->save();

                                $msg_replace = str_replace(" ", "_", $request->status);
                                if (strtolower($msg_replace) != "on_the_way") {
                                    $notifications = new Mobile_notifications;
                                    $notifications->user_id = $check_status->customer_id;
                                    $notifications->order_id = $request->order_id;
                                    $notifications->message = strtolower($msg_replace);
                                    $notifications->type = "orders";
                                    $notifications->created_at = now();
                                    $notifications->status = "status_update";
                                    $notifications->save();
                                }

                                if ($check_status->user_type == "customer" && $msg_replace == "Delivery") {

                                    foreach ($order_details as $key => $order_detail) {
                                        $product = Product::find($order_detail->product_id);
                                        Product::where('id', $order_detail->product_id)->update(['quantity_per_case' => $product->quantity_per_case - $order_detail->quantity]);
                                    }
                                }


                                if ($request->status == "On the way" || $request->status == "Delivery") {
                                    Helper::SendNotification("Hi " . $custdetails->name . "", "Your Order status changed successfully", "order_status", $request->order_id, $check_status->customer_id);

                                    Helper::SendNotification("Order status", "Your Order status changed successfully", "adminorder_status", $request->order_id, $check_status->customer_id);
                                }
                                $available_jar = $check_status->returnablejar_qty;
                                // $no_of_jars_ordered = Orderproducts::where('order_id', $check_status->id)->sum('quantity');
                                $success['statuscode'] = 200;
                                $success['message'] = "Status changed successfully";

                                /**
                                 * params value (product_id,product_qty)
                                 **/
                                $success['returnable_jarqty'] = $available_jar;
                                // $success['no_of_jars_ordered'] = $no_of_jars_ordered;
                                $params['order_id'] = $request->order_id;
                                $success['params'] = $params;
                                $response['response'] = $success;
                                return \Response::json($response, 200);
                            }
                        } else if ($user->user_type == "distributor") {

                            if (empty($check_status->assigned_distributor) || $check_status->assigned_distributor == $user->id) {
                                if ($request->status == "Delivery") {
                                    $delivered_date = date("Y-m-d");
                                    $delivered_time = date("h:i:sa");
                                } else {
                                    $delivered_date = $check_status->O_delivery_date;
                                    $delivered_time = $check_status->O_delivery_time;
                                }

                                if ($request->status == "On the way") {
                                    $on_the_waydate = date("Y-m-d");
                                    $cancelled_date = $check_status->cancelled_date;
                                } else if ($request->status == "Cancelled") {
                                    $on_the_waydate = $check_status->on_the_way_date;
                                    $cancelled_date = date("Y-m-d");
                                } else {
                                    $on_the_waydate = "";
                                    $cancelled_date = "";
                                }
                                Order::where('id', $request->order_id)->update(['status' => $request->status, 'assigned_deliveryboy' => $user->id, 'O_delivery_date' => $delivered_date, 'O_delivery_time' => $delivered_time, 'on_the_way_date' => $on_the_waydate, 'cancelled_date' => $cancelled_date]);
                                Mobile_notifications::where('user_id', $check_status->customer_id)->where('order_id', $request->order_id)->where('type', 'orders')->delete();
                                if ($check_status->status == "Order placed") {

                                    //Notifications
                                    $notifications = new Notifications;
                                    $notifications->user_id = $check_status->customer_id;
                                    $notifications->order_id = $request->order_id;
                                    $notifications->message = $check_status->order_id . " Order has been accepted by " . $user_table->name . " Distributor";
                                    $notifications->type = "orders";
                                    $notifications->save();

                                    $notifications = new Mobile_notifications;
                                    $notifications->user_id = $check_status->customer_id;
                                    $notifications->order_id = $request->order_id;
                                    $notifications->message = "on_the_way";
                                    $notifications->type = "orders";
                                    $notifications->created_at = now();
                                    $notifications->save();
                                }

                                //Notifications
                                $notifications = new Notifications;
                                $notifications->user_id = $check_status->customer_id;
                                $notifications->order_id = $request->order_id;
                                $notifications->message = $check_status->order_id . "Order status changed to " . $request->status . "";
                                $notifications->type = "orders";
                                $notifications->status = "status_update";
                                $notifications->save();


                                $msg_replace = str_replace(" ", "_", $request->status);
                                if (strtolower($msg_replace) != "on_the_way") {
                                    $notifications = new Mobile_notifications;
                                    $notifications->user_id = $check_status->customer_id;
                                    $notifications->order_id = $request->order_id;
                                    $notifications->message = strtolower($msg_replace);
                                    $notifications->type = "orders";
                                    $notifications->status = "status_update";
                                    $notifications->created_at = now();
                                    $notifications->save();
                                }

                                if ($request->status == "On the way" || $request->status == "Delivery") {
                                    Helper::SendNotification("Hi " . $custdetails->name . "", "Your Order status changed successfully", "order_status", $request->order_id, $check_status->customer_id);

                                    Helper::SendNotification("Order status", "Your Order status changed successfully", "adminorder_status", $request->order_id, $check_status->customer_id);
                                }
                                $available_jar = $check_status->returnablejar_qty;
                                // $no_of_jars_ordered = Orderproducts::where('order_id', $check_status->id)->sum('quantity');

                                $success['statuscode'] = 200;
                                $success['message'] = "Status changed successfully";

                                /**
                                 * params value (product_id,product_qty)
                                 **/
                                $success['returnable_jarqty'] = $available_jar;
                                // $success['no_of_jars_ordered'] = $no_of_jars_ordered;
                                $params['order_id'] = $request->order_id;
                                $success['params'] = $params;
                                $response['response'] = $success;
                                return \Response::json($response, 200);
                            }
                        } else {
                            $success['statuscode'] = 401;
                            $success['message'] = "Delivery boy already assigned";
                            $params = [];
                            $success['params'] = $params;
                            $response['response'] = $success;
                            return \Response::json($response, 401);
                        }
                    } else {
                        $success['statuscode'] = 200;
                        $success['message'] = "No orders found";
                        $params = [];
                        $success['params'] = $params;
                        $response['response'] = $success;
                        return \Response::json($response, 401);
                    }
                } else {
                    $success['statuscode'] = 401;
                    $success['message'] = "Login";
                    $params = [];
                    $success['params'] = $params;
                    $response['response'] = $success;
                    return \Response::json($response, 401);
                }
            } else {
                $success['statuscode'] = 401;
                $success['message'] = "Please login";
                $params = [];
                $success['params'] = $params;
                $response['response'] = $success;
                return \Response::json($response, 401);
            }
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return \Response::json($response, 401);
        }
    }


    public function user_address(Request $request)
    {
        try {
            $user = Auth::user();
            if (!empty($user)) {
                $data = $request->all();
                //   if($request->is_default==1 || $request->is_default==true  || $request->is_default=="true"){ 
                //       $data['is_default']="true";
                //     }else{
                //       $data['is_default']="false";  
                //     }
                if ($data['is_default'] == "true") {
                    User_address::where('user_id', $user->id)->update(['is_default' => "false"]);
                }
                $data['user_id'] = $user->id;
                $data['full_address'] = $request->door_no . ' ' . $request->address . ' ' . $request->city . ' ' . $request->state . ' ' . $request->zip_code;

                User_address::create($data);
                $success['statuscode'] = 200;
                $success['message'] = "Address added successfully";
                $success['address'] = $data;
                $success['params'] = $data;
                $response['response'] = $success;
                return \Response::json($response, 200);
            } else {
                $success['statuscode'] = 401;
                $success['message'] = "Please login";
                $params = [];
                $success['params'] = $params;
                $response['response'] = $success;
                return \Response::json($response, 401);
            }
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return \Response::json($response, 401);
        }
    }

    public function get_user_address(Request $request)
    {
        try {

            $user = Auth::user();
            if (!empty($user)) {
                $address = User_address::where('user_id', $user->id)->get();
                $selected_address = User_address::where('user_id', $user->id)->where('is_default', 'true')->first();
                if (!empty($selected_address)) {
                    $pincode = Pincode::where('pincode', $selected_address->zip_code)->where('status', 'active')->first();

                    $success['address'] = $address;

                    if (!empty($pincode)) {
                        $selected_address->isServiceAvailable = true;
                    } else {
                        $selected_address->isServiceAvailable = false;
                    }


                    foreach ($address as $a) {
                        $pincde = Pincode::where('pincode', $a->zip_code)->first();
                        if (!empty($pincde)) {
                            $a->isServiceAvailable = true;
                        } else {
                            $a->isServiceAvailable = false;
                        }
                    }


                    if (empty($selected_address)) {
                        $selected_address = (object) [];
                    } else {
                        $selected_address->is_default == "true" ? $selected_address->is_default = true : $selected_address->is_default = false;
                    }
                    $success['statuscode'] = 200;
                    $success['message'] = "Address lists";
                    $success['selected_address'] = $selected_address;
                    $params = [];
                    $response['response'] = $success;
                    return \Response::json($response, 200);
                } else {
                    $success['address'] = [];
                    $success['statuscode'] = 200;
                    $success['message'] = "Address lists empty";
                    $success['selected_address'] = (object) [];
                    $params = [];
                    $response['response'] = $success;
                    return \Response::json($response, 200);
                }
            } else {

                $success['statuscode'] = 401;
                $success['message'] = "Please login";
                $params = [];
                $success['params'] = $params;
                $response['response'] = $success;
                return \Response::json($response, 401);
            }
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return \Response::json($response, 401);
        }
    }

    public function update_defaultaddress(Request $request)
    {
        try {
            $user = Auth::user();
            $data = $request->all();
            if ($request->is_default == 1 || $request->is_default == "true") {

                $default_address = "true";
            } else {
                $default_address = "false";
            }

            if (!empty($user)) {
                $Dselected_address = User_address::where('user_id', $user->id)->where('is_default', 'true')->first();
                User_address::where('user_id', $user->id)->where('id', '!=', $request->address_id)->update(['is_default' => "false"]);


                $address = User_address::where('id', $request->address_id)->update(['is_default' => $default_address, 'full_name' => $request->name, 'door_no' => $request->door_no, 'floor_no' => $request->floor_no, 'flat_no' => $request->flat_no, 'phone_number' => $request->phone_number, 'is_lift' => $request->is_lift, 'address' => $request->address, 'city' => $request->city, 'state' => $request->state, 'zip_code' => $request->zip_code, 'lat' => $request->lat, 'lang' => $request->lang, 'address_type' => $request->address_type, 'full_address' => $request->door_no . ' ' . $request->address . ' ' . $request->city . ' ' . $request->state . ' ' . $request->zip_code]);


                $user_address = User_address::where('user_id', $user->id)->get();
                if (count($user_address) == 1) {

                    User_address::where('user_id', $user->id)->update(['is_default' => "true"]);
                }

                $selected_address = User_address::where('user_id', $user->id)->where('is_default', 'true')->first();

                if (empty($selected_address)) {
                    $address_id = User_address::select('user_id', 'id')->where('id', '!=', $request->address_id)->where('user_id', $user->id)->first();
                    if (!empty($address_id)) {
                        User_address::where('user_id', $user->id)->where('id', $Dselected_address->id)->update(['is_default' => "true"]);
                    }
                    $selected_address = User_address::where('user_id', $user->id)->where('is_default', 'true')->first();
                } else {
                    $selected_address->is_default == "true" ? $selected_address->is_default = true : $selected_address->is_default = false;
                }



                $user_address = User_address::where('user_id', $user->id)->where('is_default', 'true')->first();
                if (!empty($user_address)) {
                    $charges = DeliveryCharges::where('floor_no', $user_address->floor_no)
                        ->where('status', 'active')
                        ->selectRaw("IF(is_discount = 'true', 0, amount) as amount")
                        ->first();
                } else {
                    $charges = [];
                }

                Carts::where('customer_id', $user->id)->update(['delivery_charges' => ((!empty($charges) && $charges->is_discount == 'false') ? $charges->amount : '0.00')]);

                $success['statuscode'] = 200;
                $success['message'] = "Default address updated";

                $params['address_id'] = $request->address_id;
                $params['is_default'] = $request->is_default;
                $params['name'] = $request->name;
                $params['door_no'] = $request->door_no;
                $params['is_lift'] = $request->is_lift;

                $params['address'] = $request->address;
                $params['city'] = $request->city;
                $params['state'] = $request->state;
                $params['zip_code'] = $request->zip_code;
                $params['lat'] = $request->lat;
                $params['lang'] = $request->lang;
                $params['address_type'] = $request->address_type;


                $success['params'] = $params;
                $success['selected_address'] = $selected_address;
                $response['response'] = $success;
                return \Response::json($response, 200);
            } else {
                $success['statuscode'] = 401;
                $success['message'] = "Please login";
                $params = [];
                $success['params'] = $params;
                $response['response'] = $success;
                return \Response::json($response, 401);
            }
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return \Response::json($response, 401);
        }
    }

    public function delete_user_address(Request $request)
    {
        try {

            $user = Auth::user();
            if (!empty($user)) {
                $check_address = User_address::where('id', $request->id)->where('user_id', $user->id)->first();
                $address = User_address::where('id', $request->id)->where('user_id', $user->id)->delete();
                if ($check_address->is_default == "true") {
                    $address_id = User_address::select('user_id', 'id')->where('user_id', $user->id)->first();
                    if (!empty($address_id)) {
                        User_address::where('user_id', $user->id)->where('id', $address_id->id)->update(['is_default' => "true"]);
                    }
                }
                $success['statuscode'] = 200;
                $success['message'] = "Address deleted successfully";
                $params['id'] = $request->id;
                $success['params'] = $params;
                $response['response'] = $success;
                return \Response::json($response, 200);
            } else {
                $success['statuscode'] = 401;
                $success['message'] = "Please login";
                $params = [];
                $success['params'] = $params;
                $response['response'] = $success;
                return \Response::json($response, 401);
            }
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return \Response::json($response, 401);
        }
    }

    public function notifications(Request $request)
    {
        $user = Auth::user();

        try {
            $orders = array();
            if (!empty($user)) {
                $notifications = Mobile_notifications::where('user_id', $user->id)->orderBy('id', 'desc')->whereRaw('NOT FIND_IN_SET(' . $user->id . ',removed_user)')->get();

                $delivery_distributor_notification = Mobile_notifications::orderBy('id', 'desc')->whereRaw('NOT FIND_IN_SET(' . $user->id . ',removed_user)')->groupBy('order_id')->get();

                if (!empty($notifications)) {


                    foreach ($notifications as $notification) {
                        $order = Order::where('id', $notification->order_id)->first();
                        if (!empty($order)) {
                            $msg_replace = str_replace(" ", "_", $notification->message);
                            if (strtolower($msg_replace) == "order_placed") {
                                $msg = "Your " . $order->order_id . " order has been placed";
                            } else if (strtolower($msg_replace) == "on_the_way") {
                                $msg = "Your " . $order->order_id . " order has been accepted,your item is on the way";
                            } else if (strtolower($msg_replace) == "delivery") {
                                $msg = "Your " . $order->order_id . " order has been delivered";
                            } else if (strtolower($msg_replace) == "cancelled") {
                                $msg = "Your " . $order->order_id . " order has been cancelled";
                            } else if (strtolower($msg_replace) == "reschedule") {
                                $msg = "Your " . $order->order_id . " order has been reschedule";
                            }
                        } else {
                            $msg = "";
                        }

                        if (!empty($notification->order_id)) {

                            $order = Order::select('id', 'created_at', 'order_id', 'status')->where('id', $notification->order_id)->orderBy('id', 'desc')->first();

                            $ord['id'] = $notification->id;
                            $ord['ord_id'] = (!empty($order) ? $order->id : '');
                            $ord['order_id'] = (!empty($order) ? $order->order_id : '');
                            if (!(empty($order)) && $order->status == "Delivery") {
                                $order->o_status = "Delivered";
                            } else {
                                if (!(empty($order))) {
                                    $order->o_status = (!empty($order) ? $order->status : '');
                                }
                                // $order->o_status=(!empty($order)?$order->status:'');
                            }
                            $ord['title'] = (!empty($order) ? $order->o_status : '');
                            $ord['msg'] = $msg;
                            $ord['date'] = (!empty($order) ? $order->created_at->format('Y-m-d') : '');
                            $ord['time'] = (!empty($order) ? $order->created_at->format('g:i a') : '');
                            array_push($orders, $ord);
                        }
                    }
                }

                //delivery
                if (!empty($delivery_distributor_notification)) {

                    foreach ($delivery_distributor_notification as $notification) {
                        if ($user->user_type == "delivery_agent") {
                            if (!empty($notification->order_id)) {
                                $delivery_address = User_address::select('lat', 'lang')->where('user_id', $user->id)->where('is_default', 'true')->first();
                                if (!empty($delivery_address)) {
                                    $lat = $delivery_address->lat;
                                    $lang = $delivery_address->lang;
                                } else {
                                    $lat = "";
                                    $lang = "";
                                }
                                if (!empty($lat) && !empty($lang)) {
                                    $order = Order::join('shipping_address', 'orders.id', '=', 'shipping_address.order_id')->join('user_addresses', 'shipping_address.address_id', '=', 'user_addresses.id')->select(
                                        "orders.id",
                                        "orders.order_id as ord_id",
                                        "user_addresses.lat as customer_lat",
                                        "user_addresses.lang as customer_lang",
                                        "orders.id as o_id",
                                        "orders.created_at as ord_created_at",
                                        "orders.total",
                                        "orders.status as order_status",
                                        'user_addresses.*',
                                        'shipping_address.*',
                                        DB::raw("COALESCE(6371 * acos(cos(radians(" . $lat . ")) 
                                        * cos(radians(user_addresses.lat)) 
                                        * cos(radians(user_addresses.lang) 
                                        - radians(" . $lang . ")) 
                                        + sin(radians(" . $lat . ")) 
                                        * sin(radians(user_addresses.lat))),0) AS distance")
                                    )->where('orders.user_type', 'customer')->where('orders.status', 'Order placed')->where('orders.id', $notification->order_id)->orderBy('orders.id', 'desc')->first();
                                } else {
                                    $order = [];
                                }

                                if (!empty($order)) {

                                    $dist = $this->map($lat, $lang, $order->customer_lat, $order->customer_lang);
                                    $kms = str_replace(',', '.', $dist);
                                    $whatIWant = substr($kms, strpos($kms, " ") + 1);
                                    if ($whatIWant == "km") {
                                        $kms = str_replace('km', '', $kms);
                                    } else {
                                        $kms = str_replace('m', '', $kms);
                                        $kms = $kms / 1000;
                                    }


                                    if ((number_format($kms, 2)) <= 5.0) {
                                        $ord['id'] = $notification->id;
                                        $ord['ord_id'] = $order->o_id;
                                        if ($order->order_status == "Delivery") {
                                            $order->o_status = "Delivered";
                                        } else {

                                            $order->o_status = $order->order_status;
                                        }
                                        $ord['title'] = (!empty($order) ? $order->o_status : '');
                                        $ord['order_id'] = $order->ord_id;

                                        if ($notification->message == "reschedule") {
                                            $ord['msg'] = "Order placed from " . $order->full_name . " has been rescheduled";
                                        } else {
                                            $ord['msg'] = "Order placed from " . $order->full_name;
                                        }
                                        $ord['date'] = $order->created_at->format('Y-m-d');
                                        $ord['time'] = $order->created_at->format('g:i a');
                                        array_push($orders, $ord);
                                    }
                                }
                            }
                        }
                    }
                }


                //distributor
                if (!empty($delivery_distributor_notification)) {
                    foreach ($delivery_distributor_notification as $notification) {
                        if ($user->user_type == "distributor") {
                            if (!empty($notification->order_id)) {

                                $order = Order::
                                    // ->join('user_addresses','shipping_address.address_id','=','user_addresses.id')
                                    join('shipping_address', 'orders.id', '=', 'shipping_address.order_id')->join('owners_meta_data', 'owners_meta_data.user_id', '=', 'orders.customer_id')
                                    ->select("orders.id", "orders.order_id as ord_id", "orders.assigned_distributor", "orders.created_at as ord_created_at", "orders.id as o_id", "orders.total", "orders.status as order_status", 'shipping_address.*', "owners_meta_data.name_of_owner as full_name")->where('owners_meta_data.assigned_distributor', $user->id)->where('orders.status', "Order placed")->where('orders.id', $notification->order_id)->orderBy('orders.id', 'desc')->first();


                                if (!empty($order)) {
                                    $ord['id'] = $notification->id;
                                    $ord['ord_id'] = $order->o_id;
                                    $ord['order_id'] = $order->ord_id;
                                    if ($order->order_status == "Delivery") {
                                        $order->o_status = "Delivered";
                                    } else {
                                        $order->o_status = $order->order_status;
                                    }
                                    $ord['title'] = $order->o_status;
                                    $ord['msg'] = "Order placed from " . $order->full_name;

                                    $ord['date'] = $order->created_at->format('Y-m-d');
                                    $ord['time'] = $order->created_at->format('g:i a');
                                    array_push($orders, $ord);
                                }
                            }
                        }
                    }
                }

                $success['statuscode'] = 200;
                $success['message'] = "Notification list";
                $params = [];
                $success['params'] = $params;
                $success['notifications'] = $orders;
                $response['response'] = $success;
                return \Response::json($response, 200);
            }
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return \Response::json($response, 401);
        }
    }


    public function remove_notification(Request $request)
    {
        $user = Auth::user();
        try {
            if ($request->type == "single") {
                $notification = Mobile_notifications::where('id', $request->id)->first();
                // if(empty($notification->removed_user)){
                //   $notification=Notifications::where('id',$request->id)->update(["removed_user"=>$user->id]);
                // }else{
                $notification = Mobile_notifications::where('id', $request->id)->update(["removed_user" => $notification->removed_user . "," . $user->id]);
                //}
                $success['statuscode'] = 200;
                $success['message'] = "Notification deleted";
                $params['id'] = $request->id;
                $params['type'] = $request->type;
                $success['params'] = $params;
                $response['response'] = $success;
                return \Response::json($response, 200);
            } else {
                $notification = Mobile_notifications::all();
                foreach ($notification as $n) {
                    Mobile_notifications::where('id', '=', $n->id)->update(["removed_user" => $n->removed_user . "," . $user->id]);
                }
                //}
                $success['statuscode'] = 200;
                $success['message'] = "Notification deleted";
                $params['id'] = $request->id;
                $params['type'] = $request->type;
                $success['params'] = $params;
                $response['response'] = $success;
                return \Response::json($response, 200);
            }
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return \Response::json($response, 401);
        }
    }

    public function unread_notification()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'response' => [
                    'statuscode' => 401,
                    'message' => 'Unauthorized. Please log in.',
                ],
            ], 401);
        }


        try {

            Mobile_notifications::where('user_id', $user->id)->update(['user_status' => 'read']);

            return response()->json([
                'response' => [
                    'statuscode' => 200,
                    'message' => "All the notification have been read",
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'response' => [
                    'statuscode' => 500,
                    'message' => 'Something went wrong. Please try again later.',
                ],
            ], 500);
        }
    }

    public function notification_count()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'response' => [
                    'statuscode' => 401,
                    'message' => 'Unauthorized. Please log in.',
                ],
            ], 401);
        }


        try {

            $notification_count = Mobile_notifications::where('user_id', $user->id)->whereNull('user_status')->count();

            return response()->json([
                'response' => [
                    'statuscode' => 200,
                    'count' => $notification_count,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'response' => [
                    'statuscode' => 500,
                    'message' => 'Something went wrong. Please try again later.',
                ],
            ], 500);
        }
    }

    public function check_order(Request $request)
    {
        $user = Auth::user();
        try {
            if (!empty($user)) {
                $carts = Carts::where('customer_id', $user->id)->get();
                $is_jarCnt = 0;
                $is_toresheduleCnt = 0;
                $a = 0;
                foreach ($carts as $cart) {
                    $product = Product::find($cart->product_id);
                    if ($product->type == "jar") {
                        $is_jarCnt += 1;
                    }
                }


                if ($is_jarCnt > 0) {

                    $orders = Order::where('customer_id', $user->id)->where('status', 'Order placed')->get();

                    foreach ($orders as $order) {
                        $ordDate = Carbon::createFromFormat('d-m-Y', $order->delivery_date)->format('Y-m-d');
                        //echo $ordDate;


                        if ($ordDate > $request->order_date) {

                            $ord = Order::find($order->id);
                            $ordProducts = Orderproducts::where('order_id', $order->id)->get();


                            foreach ($ordProducts as $ordProduct) {
                                if (!empty($ordProducts)) {
                                    $product = Product::find($ordProduct->product_id);
                                }
                                if (isset($product)) {
                                    if ($product->type == "jar") {
                                        $is_toresheduleCnt += 1;
                                    }
                                }
                            }
                        }
                    }
                }

                if ($is_toresheduleCnt == 0) {
                    $to_reschedule = false;
                } else {
                    $to_reschedule = true;
                }

                $success['statuscode'] = 200;
                $success['to_reschedule'] = $to_reschedule;
                $success['message'] = "Check orders";
                // $success['ordDate']=$orders;
                $params['order_date'] = $request->order_date;
                $response['params'] = $params;
                $response['response'] = $success;
                return \Response::json($response, 200);
            } else {
                $success['statuscode'] = 401;
                $success['message'] = "Something went wrong";
                /**
                 * params value (user_id,otp,token)
                 **/
                $params = [];
                $success['params'] = $params;
                $response['response'] = $success;
                return \Response::json($response, 401);
            }
        } catch (Exception $e) {
            $success['statuscode'] = 401;
            $success['message'] = "Something went wrong";
            /**
             * params value (user_id,otp,token)
             **/
            $params = [];
            $success['params'] = $params;
            $response['response'] = $success;
            return \Response::json($response, 401);
        }
    }
}
