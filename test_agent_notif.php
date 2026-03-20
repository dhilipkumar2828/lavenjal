<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;
use App\Models\Owner_meta_data;
use App\Models\User;
use App\Models\User_address;
use App\Models\Mobile_notifications;

echo "=== CHECKOUT SAVE TEST ===\n\n";

// Get latest order
$order = Order::orderBy('id', 'desc')->first();
echo "Order: " . $order->order_id . " | assigned_distributor=" . $order->assigned_distributor . " | addr_id=" . $order->selected_address_id . "\n";

// Simulate checkout notification save logic
$distributor_ids = [];
if (!empty($order->assigned_distributor) && $order->assigned_distributor != 0) {
    $distributor_ids[] = $order->assigned_distributor;
    echo "Path 1: direct distributor " . $order->assigned_distributor . "\n";
} else {
    $zip = User_address::where('id', $order->selected_address_id)->value('zip_code');
    echo "Path 2: zip=" . $zip . "\n";
    if (!empty($zip)) {
        $distributor_ids = Owner_meta_data::join('users', 'users.id', '=', 'owners_meta_data.user_id')
            ->where('users.user_type', 'distributor')
            ->where('owners_meta_data.pincode', $zip)
            ->pluck('owners_meta_data.user_id')->all();
        echo "Distributors from zip: [" . implode(', ', $distributor_ids) . "]\n";
    }
}

echo "\n--- Processing " . count($distributor_ids) . " distributor(s):\n";
foreach ($distributor_ids as $dist_id) {
    $agent_ids = Owner_meta_data::where('assigned_distributor', $dist_id)->pluck('user_id')->all();
    echo "Dist $dist_id => agents: [" . implode(', ', $agent_ids) . "]\n";
    if (!empty($agent_ids)) {
        $users = User::whereIn('id', $agent_ids)->get(['id', 'name', 'user_type']);
        foreach ($users as $u) {
            echo "  Agent: " . $u->name . " (ID=" . $u->id . ", type=" . $u->user_type . ")\n";
        }
    }
}

// Now manually insert a notification for agent linked to dist 2289
$test_agent_id = Owner_meta_data::where('assigned_distributor', 2289)->value('user_id');
echo "\n--- Test: Inserting notification for agent_id=$test_agent_id for order " . $order->id . "\n";
if (!empty($test_agent_id)) {
    $n = new Mobile_notifications;
    $n->user_id = $test_agent_id;
    $n->order_id = $order->id;
    $n->message = "order_placed";
    $n->type = "orders";
    $n->created_at = now();
    $n->save();
    echo "Saved! notification id=" . $n->id . "\n";
}

echo "\n=== DONE ===\n";
