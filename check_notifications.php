<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\Mobile_notifications;
use App\Models\User;

$agents = User::where('user_type', 'delivery_agent')->get();
foreach ($agents as $agent) {
    echo "Agent: " . $agent->id . " (" . $agent->name . ")\n";
    $notifications = Mobile_notifications::where('user_id', $agent->id)->get();
    echo "Count: " . $notifications->count() . "\n";
    foreach ($notifications as $n) {
        echo "  - Order: " . $n->order_id . ", Msg: " . $n->message . ", Created: " . $n->created_at . "\n";
    }
}
