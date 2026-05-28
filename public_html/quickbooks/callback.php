<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$config = require 'config.php';

if (!isset($_GET['code']) || !isset($_GET['realmId'])) {
    die("Error: no llegó code o realmId desde QuickBooks.");
}

$code = $_GET['code'];
$realmId = $_GET['realmId'];

$ch = curl_init("https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer");

/*
|--------------------------------------------------------------------------
| Capturar headers de respuesta, incluyendo intuit_tid
|--------------------------------------------------------------------------
*/
$responseHeaders = [];

curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($curl, $header) use (&$responseHeaders) {
    $len = strlen($header);

    $headerParts = explode(':', $header, 2);

    if (count($headerParts) < 2) {
        return $len;
    }

    $name = strtolower(trim($headerParts[0]));
    $value = trim($headerParts[1]);

    $responseHeaders[$name] = $value;

    return $len;
});

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Basic " . base64_encode($config['client_id'] . ":" . $config['client_secret']),
    "Content-Type: application/x-www-form-urlencoded",
    "Accept: application/json"
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    "grant_type" => "authorization_code",
    "code" => $code,
    "redirect_uri" => $config['redirect_uri']
]));

$response = curl_exec($ch);

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);

curl_close($ch);

$intuitTid = $responseHeaders['intuit_tid'] ?? null;

if ($response === false) {
    error_log("QuickBooks CURL Error | intuit_tid: " . ($intuitTid ?? 'not available') . " | Error: " . $curlError);
    die("Error CURL: " . $curlError);
}

$data = json_decode($response, true);

if ($httpCode >= 400 || !isset($data['access_token'])) {
    error_log(
        "QuickBooks OAuth Error | HTTP: " . $httpCode .
        " | intuit_tid: " . ($intuitTid ?? 'not available') .
        " | Response: " . $response
    );

    echo "<pre>";
    echo "HTTP Code: " . $httpCode . "\n";
    echo "intuit_tid: " . ($intuitTid ?? 'not available') . "\n\n";
    print_r($data);
    echo "</pre>";

    die("Error: QuickBooks no devolvió access_token.");
}

$tokenData = [
    "access_token" => $data["access_token"],
    "refresh_token" => $data["refresh_token"],
    "realmId" => $realmId,
    "created_at" => time(),
    "intuit_tid" => $intuitTid
];

$saved = file_put_contents(__DIR__ . "/token.json", json_encode($tokenData, JSON_PRETTY_PRINT));

if ($saved === false) {
    error_log("QuickBooks Token Save Error | intuit_tid: " . ($intuitTid ?? 'not available'));
    die("Error: no se pudo crear token.json. Revisá permisos de la carpeta quickbooks.");
}

echo "✅ Conectado a QuickBooks y token.json creado correctamente.";