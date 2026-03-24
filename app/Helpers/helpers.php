<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Order;
use App\Models\Owner_meta_data;
use App\Models\User_address;
use Pusher\Pusher;

class Helper
{
    // ---------------------------------------
    // GOOGLE MAP DISTANCE
    // ---------------------------------------
    public static function map($delivery_lat, $delivery_lang, $distributor_lat, $distributor_lang)
    {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$delivery_lat},{$delivery_lang}&destinations={$distributor_lat},{$distributor_lang}&mode=driving&key=YOUR_GOOGLE_API_KEY";

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        return $data['rows'][0]['elements'][0]['distance']['text'] ?? 0;
    }

    // ---------------------------------------
    // FCM ACCESS TOKEN
    // ---------------------------------------
    public static function getFcmAccessToken($serviceAccountPath)
    {
        if (!file_exists($serviceAccountPath)) {
            Log::error("FCM file missing: $serviceAccountPath");
            return null;
        }

        $serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);

        if (!$serviceAccount) {
            Log::error("Invalid JSON: $serviceAccountPath");
            return null;
        }

        $now = time();

        $jwtHeader = base64_encode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
        $jwtClaims = base64_encode(json_encode([
            'iss' => $serviceAccount['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => $serviceAccount['token_uri'],
            'iat' => $now,
            'exp' => $now + 3600,
        ]));

        $jwtHeader = str_replace(['+', '/', '='], ['-', '_', ''], $jwtHeader);
        $jwtClaims = str_replace(['+', '/', '='], ['-', '_', ''], $jwtClaims);

        $signatureInput = $jwtHeader . '.' . $jwtClaims;

        openssl_sign($signatureInput, $signature, $serviceAccount['private_key'], 'SHA256');

        $jwt = $signatureInput . '.' . str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        $ch = curl_init($serviceAccount['token_uri']);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_POSTFIELDS => http_build_query([
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ])
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $token = json_decode($response, true);

        return $token['access_token'] ?? null;
    }

    // ---------------------------------------
    // MAIN NOTIFICATION FUNCTION
    // ---------------------------------------
    public static function SendNotification($title, $body, $type, $val, $user_id)
    {
        $customerTokens = [];
        $deliveryTokens = [];

        // -----------------------------
        // LOGIN
        // -----------------------------
        if ($type == "login") {
            $user = User::find($user_id);
            if ($user && ($user->user_type == 'distributor' || $user->user_type == 'delivery_agent')) {
                $deliveryTokens[] = $val;
            } else {
                $customerTokens[] = $val;
            }
        }

        // -----------------------------
        // ORDER → DISTRIBUTOR + AGENTS
        // -----------------------------
        else if ($type == "checkout_customer") {

            $order = Order::find($val);

            if (!$order) {
                Log::error("Order not found: " . $val);
                return;
            }

            $assignedDistributorIds = [];

            // CASE 1: DIRECT ASSIGN
            if (!empty($order->assigned_distributor)) {
                $assignedDistributorIds[] = $order->assigned_distributor;
            }

            // CASE 2: ZIP MATCH
            else {
                $zip = User_address::where('id', $order->selected_address_id)->value('zip_code');

                if (empty($zip)) {
                    Log::warning("ZIP not found for order: " . $val);
                }
                else {
                    $assignedDistributorIds = Owner_meta_data::join('users', 'users.id', '=', 'owners_meta_data.user_id')
                        ->where('users.user_type', 'distributor')
                        ->where('owners_meta_data.pincode', $zip)
                        ->pluck('owners_meta_data.user_id')
                        ->toArray();
                }
            }

            Log::info("Assigned Distributor IDs:", $assignedDistributorIds);

            // -----------------------------
            // GET TOKENS
            // -----------------------------
            if (!empty($assignedDistributorIds)) {

                // DISTRIBUTOR TOKENS
                $distributorTokens = User::whereIn('id', $assignedDistributorIds)
                    ->whereNotNull('device_key')
                    ->where('device_key', '!=', '')
                    ->pluck('device_key')
                    ->toArray();

                // DELIVERY AGENT TOKENS
                $agentTokens = User::whereIn('id', function ($q) use ($assignedDistributorIds) {
                    $q->select('user_id')
                        ->from('owners_meta_data')
                        ->whereIn('assigned_distributor', $assignedDistributorIds);
                })
                    ->whereNotNull('device_key')
                    ->where('device_key', '!=', '')
                    ->pluck('device_key')
                    ->toArray();

                Log::info("Distributor Tokens:", $distributorTokens);
                Log::info("Agent Tokens:", $agentTokens);

                $deliveryTokens = array_merge($distributorTokens, $agentTokens);
            }
            else {
                Log::warning("No distributors found for order: " . $val);
            }
        }

        // -----------------------------
        // CUSTOMER CONFIRMATION
        // -----------------------------
        else if ($type == "checkout_customernoty") {

            $order = Order::find($val);

            if ($order) {
                $customerTokens = User::where('id', $order->customer_id)
                    ->whereNotNull('device_key')
                    ->pluck('device_key')
                    ->toArray();

                $body = "Your order has been placed";
            }
        }

        // -----------------------------
        // CLEAN TOKENS
        // -----------------------------
        $customerTokens = self::cleanTokens($customerTokens);
        $deliveryTokens = self::cleanTokens($deliveryTokens);

        Log::info("Customer Tokens Count: " . count($customerTokens));
        Log::info("Delivery Tokens Count: " . count($deliveryTokens));

        // -----------------------------
        // SEND FCM
        // -----------------------------
        if (!empty($customerTokens)) {
            self::sendFcm($customerTokens, $title, $body, 'lavenjal-user', 'customer-service-account.json');
        }

        if (!empty($deliveryTokens)) {
            self::sendFcm($deliveryTokens, $title, $body, 'lavenjal-delivery', 'distributor-service-account.json');
        }
    }
    // ---------------------------------------
    // TOKEN CLEANER
    // ---------------------------------------
    private static function cleanTokens($tokens)
    {
        $final = [];

        foreach ($tokens as $t) {

            if (empty($t))
                continue;

            if (str_starts_with($t, '[')) {
                $decoded = json_decode($t, true);

                if (is_array($decoded)) {
                    foreach ($decoded as $d) {
                        if (self::isValidToken($d)) {
                            $final[] = $d;
                        }
                    }
                }
            }
            else {
                if (self::isValidToken($t)) {
                    $final[] = $t;
                }
            }
        }

        return array_values(array_unique($final));
    }

    private static function isValidToken($token)
    {
        return !empty($token) && strlen($token) > 100;
    }

    // ---------------------------------------
    // FCM SENDER
    // ---------------------------------------
    private static function sendFcm($tokens, $title, $body, $projectId, $jsonFile)
    {
        if (empty($tokens)) {
            Log::warning("No tokens for $projectId");
            return;
        }

        $accessToken = self::getFcmAccessToken(storage_path("app/firebase/" . $jsonFile));

        if (!$accessToken) {
            Log::error("FCM Auth failed for $projectId");
            return;
        }

        $url = "https://fcm.googleapis.com/v1/projects/$projectId/messages:send";

        foreach ($tokens as $token) {

            $payload = [
                "message" => [
                    "token" => $token,
                    "notification" => [
                        "title" => $title,
                        "body" => $body,
                    ]
                ]
            ];

            $ch = curl_init($url);

            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer $accessToken",
                    "Content-Type: application/json"
                ],
                CURLOPT_POSTFIELDS => json_encode($payload),
            ]);

            $res = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($res === false) {
                Log::error("Curl Error: " . curl_error($ch));
            }
            else {
                Log::info("FCM [$projectId][$code]: $res");
            }

            curl_close($ch);
        }
    }

    // ---------------------------------------
    // LOGIN HELPER
    // ---------------------------------------
    public static function Notification($token, $user_id)
    {
        self::SendNotification("Welcome", "Successfully Logged in", "login", $token, $user_id);
    }

    // ---------------------------------------
    // PUSHER LIVE
    // ---------------------------------------
    public static function live_notification()
    {
        $pusher = new Pusher(
            '3cb8fd24827957fe7f59',
            '90125215be51dcb483ef',
            '1594049',
            ['cluster' => 'ap2', 'useTLS' => true]
        );

        $pusher->trigger('my-channel', 'my-event', []);
    }
}