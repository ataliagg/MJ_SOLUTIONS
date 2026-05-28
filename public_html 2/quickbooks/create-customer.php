<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/refresh-token.php';

function qbRequest($method, $url, $accessToken, $body = null) {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    $headers = [
        "Authorization: Bearer $accessToken",
        "Accept: application/json",
        "Content-Type: application/json"
    ];

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    if ($body !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    }

    $response = curl_exec($ch);

    if ($response === false) {
        die("Error CURL: " . curl_error($ch));
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    return [
        "httpCode" => $httpCode,
        "body" => json_decode($response, true)
    ];
}

function findCustomerByName($token, $name) {
    $accessToken = $token['access_token'];
    $realmId = $token['realmId'];

    $safeName = str_replace("'", "\\'", $name);

    $query = urlencode("SELECT * FROM Customer WHERE DisplayName = '$safeName'");

    $url = "https://quickbooks.api.intuit.com/v3/company/" . $realmId . "/query?query=" . $query;

    $response = qbRequest("GET", $url, $accessToken);
    $data = $response["body"];

    if (isset($data['QueryResponse']['Customer'][0])) {
        return $data['QueryResponse']['Customer'][0];
    }

    return null;
}

function createCustomer($token) {
    $accessToken = $token['access_token'];
    $realmId = $token['realmId'];

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $service = trim($_POST['service'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!$name) {
        die("Error: falta el nombre del cliente.");
    }

    $existingCustomer = findCustomerByName($token, $name);

    if ($existingCustomer) {
        return [
            "status" => "existing",
            "customer" => $existingCustomer
        ];
    }

    $customerData = [
        "DisplayName" => $name,
        "Notes" => "Service: $service\nMessage: $message"
    ];

    if (!empty($email)) {
        $customerData["PrimaryEmailAddr"] = [
            "Address" => $email
        ];
    }

    if (!empty($phone)) {
        $customerData["PrimaryPhone"] = [
            "FreeFormNumber" => $phone
        ];
    }

    // Endpoint correcto para crear Customer
    $url = "https://quickbooks.api.intuit.com/v3/company/" . $realmId . "/customer";

    $response = qbRequest("POST", $url, $accessToken, $customerData);
    $data = $response["body"];

    if (isset($data['Fault'])) {
        return [
            "status" => "error",
            "error" => $data
        ];
    }

    return [
        "status" => "created",
        "customer" => $data['Customer']
    ];
}

$tokenPath = __DIR__ . '/token.json';

if (!file_exists($tokenPath)) {
    die("Error: token.json no existe. Primero conectá QuickBooks desde auth.php");
}

$token = json_decode(file_get_contents($tokenPath), true);

$result = createCustomer($token);

if (
    isset($result['error']['Fault']['Error'][0]['code']) &&
    $result['error']['Fault']['Error'][0]['code'] == "003200"
) {
    $token = refreshQuickBooksToken();
    $result = createCustomer($token);
}

if ($result['status'] === "error") {
    echo "<pre>";
    print_r($result['error']);
    echo "</pre>";
    die("Error: QuickBooks devolvió un error.");
}

// Si llegó hasta acá, salió bien.
// Redirige a la página de gracias.
header("Location: /thanks.php");
exit;