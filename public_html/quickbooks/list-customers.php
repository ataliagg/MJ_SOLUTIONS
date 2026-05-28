<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$token = json_decode(file_get_contents(__DIR__ . "/token.json"), true);

$accessToken = $token['access_token'];
$realmId = $token['realmId'];

echo "<h3>Realm ID conectado: $realmId</h3>";

$query = urlencode("SELECT Id, DisplayName, Active FROM Customer MAXRESULTS 50");

$url = "https://sandbox-quickbooks.api.intuit.com/v3/company/$realmId/query?query=$query";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $accessToken",
    "Accept: application/json"
]);

$response = curl_exec($ch);

if ($response === false) {
    die("Error CURL: " . curl_error($ch));
}

$data = json_decode($response, true);

echo "<pre>";
print_r($data);
echo "</pre>";