<?php

/**
 * Lavenjal API Documentation
 * Base URL: http://192.168.1.17:8000/api/
 * Google Maps API Key: AIzaSyAMWBCScrGIa5WPe9VB39Kiz_ER7M363uM
 */

$google_maps_config = [
    'api_key'     => 'AIzaSyAMWBCScrGIa5WPe9VB39Kiz_ER7M363uM',
    'map_type'    => 'Google Maps (Distance Matrix API)',
    'usage'       => 'Used to calculate distance between delivery location and distributor location',
    'endpoint'    => 'https://maps.googleapis.com/maps/api/distancematrix/json',
    'params'      => 'origins: "lat,lang" | destinations: "lat,lang" | mode: "driving" | key: "AIzaSyAMWBCScrGIa5WPe9VB39Kiz_ER7M363uM"',
    'app_usage'   => 'Use this same key in the mobile app for Google Maps SDK (Android & iOS)',
];

$api_list = [
    'Authenticated Routes (Requires Bearer Token)' => [
        [
            'name' => 'All Users',
            'url' => 'v1/all-user',
            'method' => 'POST',
            'payload' => 'None',
            'description' => 'List all users (Admin/Testing)'
        ],
        [
            'name' => 'Store Device Token',
            'url' => 'v1/store_token',
            'method' => 'POST',
            'payload' => 'token: "fcm_device_token_here"',
            'description' => 'Store FCM device token for notifications'
        ],
        [
            'name' => 'User Details',
            'url' => 'v1/user_details',
            'method' => 'GET',
            'payload' => 'None',
            'description' => 'Get profile details of the logged-in user'
        ],
        [
            'name' => 'Update User Profile',
            'url' => 'v1/update_user',
            'method' => 'POST',
            'payload' => 'name: "Richard", email: "user@example.com", phone: "9876543210"',
            'description' => 'Update profile information'
        ],
        [
            'name' => 'Add to Cart',
            'url' => 'v1/add_to_cart',
            'method' => 'POST',
            'payload' => 'product_id: "1", product_qty: "2", returnable_jarqty: "0", type: "" (optional: "return_jar")',
            'description' => 'Add item to shopping cart'
        ],
        [
            'name' => 'Delete Cart Item',
            'url' => 'v1/delete_cart',
            'method' => 'DELETE',
            'payload' => 'product_id: "1"',
            'description' => 'Remove item from cart'
        ],
        [
            'name' => 'Cart List',
            'url' => 'v1/cart_lists',
            'method' => 'GET',
            'payload' => 'None',
            'description' => 'Get items in the current cart'
        ],
        [
            'name' => 'Add to Wishlist',
            'url' => 'v1/add_to_wishlist',
            'method' => 'POST',
            'payload' => 'product_id: "1"',
            'description' => 'Toggle item in wishlist'
        ],
        [
            'name' => 'Wishlist List',
            'url' => 'v1/wishlist_lists',
            'method' => 'GET',
            'payload' => 'None',
            'description' => 'Get all wishlist items'
        ],
        [
            'name' => 'Delete Wishlist Item',
            'url' => 'v1/delete_wishlist',
            'method' => 'POST',
            'payload' => 'product_id: "1"',
            'description' => 'Remove item from wishlist'
        ],
        [
            'name' => 'Initiate Payment',
            'url' => 'v1/payment/init',
            'method' => 'POST',
            'payload' => 'userId: "5", order_id: "LVJ-AB1234", amount: "500.00", productinfo: "Water Jar", firstname: "Richard", email: "user@example.com", phone: "9876543210", delivery_date: "2024-12-31", delivery_time: "2" (1=Any time, 2=8am-12pm, 3=12pm-8pm)',
            'description' => 'Start payment process with Easebuzz'
        ],
        [
            'name' => 'Payment API Summary',
            'url' => 'v1/payment/api',
            'method' => 'GET',
            'payload' => 'None',
            'description' => 'Get cost breakdown before payment'
        ],
        [
            'name' => 'Checkout',
            'url' => 'v1/checkout',
            'method' => 'POST',
            'payload' => 'order_id: "LVJ-AB1234", address_id: "3", payment_response: "{...easebuzz_response...}", delivery_date: "2024-12-31", delivery_time: "2", is_reschedule: false',
            'description' => 'Complete order after successful payment'
        ],
        [
            'name' => 'My Orders',
            'url' => 'v1/order_lists',
            'method' => 'GET',
            'payload' => 'None',
            'description' => 'List of user\'s past orders'
        ],
        [
            'name' => 'Order Details',
            'url' => 'v1/order_details',
            'method' => 'POST',
            'payload' => 'order_id: "3"',
            'description' => 'Detailed view of a single order'
        ],
        [
            'name' => 'Add Address',
            'url' => 'v1/user_address',
            'method' => 'POST',
            'payload' => 'full_name: "Richard", phone_number: "9876543210", door_no: "20", flat_no: "A1", floor_no: "2", address: "Main Street", city: "Bengaluru", state: "Karnataka", zip_code: "560034", lat: "12.9716", lang: "77.5946", address_type: "Home", is_default: "true", is_lift: "0"',
            'description' => 'Add new user address'
        ],
        [
            'name' => 'Get Addresses',
            'url' => 'v1/get_user_address',
            'method' => 'GET',
            'payload' => 'None',
            'description' => 'List all saved addresses'
        ],
        [
            'name' => 'Update Default Address',
            'url' => 'v1/update_defaultaddress',
            'method' => 'POST',
            'payload' => 'address_id: "3", is_default: "true", name: "Richard", phone_number: "9876543210", door_no: "20", flat_no: "A1", floor_no: "2", address: "Main Street", city: "Bengaluru", state: "Karnataka", zip_code: "560034", lat: "12.9716", lang: "77.5946", address_type: "Home", is_lift: "0"',
            'description' => 'Edit or set an address as default'
        ],
        [
            'name' => 'Delete Address',
            'url' => 'v1/delete_user_address',
            'method' => 'POST',
            'payload' => 'id: "3"',
            'description' => 'Remove an address'
        ],
        [
            'name' => 'Products (Featured)',
            'url' => 'v1/products',
            'method' => 'GET',
            'payload' => 'None',
            'description' => 'Get featured product list'
        ],
        [
            'name' => 'All Products',
            'url' => 'v1/all_products',
            'method' => 'GET',
            'payload' => 'None',
            'description' => 'Get all active products'
        ],
        [
            'name' => 'Product Details',
            'url' => 'v1/product_details/{slug}',
            'method' => 'POST',
            'payload' => 'No body needed. Pass product slug in URL only. user_id is taken from Bearer Token automatically. Example: product_details/lavenjal-20ltr-jar',
            'description' => 'Get full details of a single product. Returns: id, name, image, size, description, type, customer_price, retailer_price, deposit_amount, isProductJar, order_count, user_type, cart_status, cart_qty, wishlist_status.'
        ],
        [
            'name' => 'Most Like Items',
            'url' => 'v1/most_like',
            'method' => 'GET',
            'payload' => 'None',
            'description' => 'List for feedback selection'
        ],
        [
            'name' => 'Submit Feedback',
            'url' => 'v1/feedback',
            'method' => 'POST',
            'payload' => 'rating: "4", most_like: ["taste","quality"], explore_next: "more products"',
            'description' => 'Submit user rating'
        ],
        [
            'name' => 'Notifications',
            'url' => 'v1/notifications',
            'method' => 'GET',
            'payload' => 'None',
            'description' => 'List of mobile notifications'
        ],
        [
            'name' => 'Notification Count',
            'url' => 'v1/notification_count',
            'method' => 'GET',
            'payload' => 'None',
            'description' => 'Number of unread notifications'
        ],
        [
            'name' => 'Distributor Orders',
            'url' => 'v1/distributor_orderLists',
            'method' => 'POST',
            'payload' => 'status: "Order placed", count: "10"',
            'description' => 'Orders assigned to distributor'
        ],
        [
            'name' => 'Delivery Orders',
            'url' => 'v1/delivery_orderLists',
            'method' => 'POST',
            'payload' => 'status: "Order placed"',
            'description' => 'Orders available for delivery agent'
        ],
        [
            'name' => 'Update Order Status',
            'url' => 'v1/deliveryboy_orderstatus',
            'method' => 'POST',
            'payload' => 'order_id: "3", status: "On the way" (options: On the way / Delivery / Cancelled)',
            'description' => 'Change order status by agent'
        ],
    ],
    'Public Routes (No Token)' => [
        [
            'name' => 'User Register',
            'url' => 'v1/user-register',
            'method' => 'POST',
            'payload' => 'name: "Richard", email: "user@example.com", phone: "9876543210", password: "Test@1234", user_type: "customer" (customer/retailer/distributor/delivery_agent), address(string/JSON): {"door_no":"20","flat_no":"A1","floor_no":"2","phone_number":"9876543210","is_lift":"0","address":"Main Street","city":"Bengaluru","state":"Karnataka","zip_code":"560034","lat":"12.9716","lang":"77.5946","address_type":"Home"}',
            'description' => 'Register new user — Send as form-data, address field must be a JSON string'
        ],
        [
            'name' => 'User Login',
            'url' => 'v1/user-login',
            'method' => 'POST',
            'payload' => 'email: "user@example.com", password: "Test@1234", user_type: "customer" (customer/retailer/distributor/delivery_agent/admin)',
            'description' => 'Standard login'
        ],
        [
            'name' => 'Send OTP',
            'url' => 'v1/send_otp',
            'method' => 'POST',
            'payload' => 'phone: "9876543210", user_type: "customer" (customer/retailer/distributor/delivery_agent)',
            'description' => 'OTP for mobile verify'
        ],
        [
            'name' => 'Verify OTP',
            'url' => 'v1/verify_otp',
            'method' => 'POST',
            'payload' => 'user_id: "5", otp: "45321", token: "fcm_device_token_here"',
            'description' => 'Completes OTP login'
        ],
        [
            'name' => 'Banner Slider',
            'url' => 'v1/banner_view',
            'method' => 'GET',
            'payload' => 'None',
            'description' => 'Homepage banners'
        ],
        [
            'name' => 'Service Availability',
            'url' => 'v1/is_service_available',
            'method' => 'POST',
            'payload' => 'pincode: "560034"',
            'description' => 'Check if area is serviceable'
        ],
        [
            'name' => 'Delivery Charge List',
            'url' => 'v1/delivery_chargelist',
            'method' => 'GET',
            'payload' => 'None',
            'description' => 'List of delivery fees per floor'
        ],
        [
            'name' => 'List Pincodes',
            'url' => 'v1/list_pincode',
            'method' => 'GET',
            'payload' => 'None',
            'description' => 'Get all active pincodes'
        ],
    ]
];

// Display Logic (Browser View)
echo "<!DOCTYPE html>
<html>
<head>
<title>Lavenjal API Documentation</title>
<style>
  body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
  h1 { color: #2c3e50; }
  h2 { color: #16a085; margin-top: 30px; }
  table { width: 100%; border-collapse: collapse; margin-bottom: 30px; background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
  th { background: #2c3e50; color: #fff; padding: 10px; text-align: left; }
  td { padding: 10px; border-bottom: 1px solid #ddd; vertical-align: top; }
  tr:hover { background: #f0f0f0; }
  code { background: #eaf4fb; padding: 2px 6px; border-radius: 3px; font-size: 12px; word-break: break-all; }
  .method-GET  { background: #27ae60; color:#fff; padding:2px 8px; border-radius:4px; font-weight:bold; }
  .method-POST { background: #2980b9; color:#fff; padding:2px 8px; border-radius:4px; font-weight:bold; }
  .method-DELETE { background: #c0392b; color:#fff; padding:2px 8px; border-radius:4px; font-weight:bold; }
</style>
</head>
<body>";

echo "<h1>Lavenjal API Documentation</h1>";
echo "<p><strong>Base URL:</strong> <code>http://192.168.1.17:8000/api/</code></p>";

// Google Maps Section
echo "<div style='background:#fff;border-left:5px solid #4285F4;padding:16px 20px;margin-bottom:30px;box-shadow:0 1px 4px rgba(0,0,0,0.1);border-radius:4px;'>";
echo "<h2 style='color:#4285F4;margin-top:0;'>🗺️ Google Maps Configuration (App Use)</h2>";
echo "<table style='width:100%;border-collapse:collapse;'>";
echo "<tr><th style='background:#4285F4;color:#fff;padding:10px;text-align:left;width:200px;'>Field</th><th style='background:#4285F4;color:#fff;padding:10px;text-align:left;'>Value</th></tr>";
foreach ($google_maps_config as $key => $value) {
    $label = ucwords(str_replace('_', ' ', $key));
    echo "<tr><td style='padding:10px;border-bottom:1px solid #ddd;font-weight:bold;'>{$label}</td><td style='padding:10px;border-bottom:1px solid #ddd;'><code style='background:#eaf4fb;padding:3px 8px;border-radius:3px;word-break:break-all;'>{$value}</code></td></tr>";
}
echo "</table>";
echo "<p style='margin:10px 0 0;color:#555;font-size:13px;'>⚠️ <strong>Mobile App Developers:</strong> Use the above API Key in your <code>AndroidManifest.xml</code> (Android) or <code>AppDelegate.swift</code> (iOS) for Google Maps SDK.</p>";
echo "</div>";

foreach ($api_list as $category => $routes) {
    echo "<h2>$category</h2>";
    echo "<table>";
    echo "<tr><th>#</th><th>Name</th><th>Method</th><th>URL</th><th>Payload (Key: Value)</th><th>Description</th></tr>";
    $i = 1;
    foreach ($routes as $route) {
        $method_class = 'method-' . $route['method'];
        echo "<tr>";
        echo "<td>{$i}</td>";
        echo "<td><strong>{$route['name']}</strong></td>";
        echo "<td><span class='{$method_class}'>{$route['method']}</span></td>";
        echo "<td><code>http://192.168.1.17:8000/api/{$route['url']}</code></td>";
        echo "<td><small><code>{$route['payload']}</code></small></td>";
        echo "<td>{$route['description']}</td>";
        echo "</tr>";
        $i++;
    }
    echo "</table>";
}

echo "</body></html>";
