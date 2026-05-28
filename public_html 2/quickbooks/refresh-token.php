<?php

function refreshQuickBooksToken() {
    $config = require __DIR__ . '/config.php';

    $tokenPath = __DIR__ . '/token.json';

    if (!file_exists($tokenPath)) {
        die("Error: token.json no existe. Primero conectá QuickBooks desde auth.php");
    }

    $token = json_decode(file_get_contents($tokenPath), true);

    if (!isset($token['refresh_token'])) {
        die("Error: no existe refresh_token en token.json");
    }

    $refreshToken = $token['refresh_token'];

    $ch = curl_init("https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Basic " . base64_encode($config['client_id'] . ":" . $config['client_secret']),
        "Content-Type: application/x-www-form-urlencoded",
        "Accept: application/json"
    ]);

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        "grant_type" => "refresh_token",
        "refresh_token" => $refreshToken
    ]));

    $response = curl_exec($ch);

    if ($response === false) {
        die("Error CURL al renovar token: " . curl_error($ch));
    }

    $data = json_decode($response, true);

    if (!isset($data['access_token'])) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die("Error: QuickBooks no renovó el access_token.");
    }

    $newToken = [
        "access_token" => $data["access_token"],
        "refresh_token" => $data["refresh_token"],
        "realmId" => $token["realmId"],
        "created_at" => time()
    ];

    file_put_contents($tokenPath, json_encode($newToken, JSON_PRETTY_PRINT));

    return $newToken;
}