<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;

$user = User::first();
if (!$user) {
    die("No user found\n");
}

$token = $user->createToken('Test')->accessToken;
echo "GENERATED TOKEN: " . $token . "\n\n";

// Try to authenticate manually with this token
$request = Illuminate\Http\Request::create('/api/v1/test', 'GET');
$request->headers->set('Authorization', 'Bearer ' . $token);
$request->headers->set('Accept', 'application/json');

try {
    $response = $app->handle($request);
    echo "RESPONSE STATUS: " . $response->getStatusCode() . "\n";
    echo "RESPONSE BODY: " . $response->getContent() . "\n";
} catch (\Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}
