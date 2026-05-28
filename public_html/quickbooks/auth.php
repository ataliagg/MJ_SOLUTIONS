<?php
$config = require 'config.php';

$url = "https://appcenter.intuit.com/connect/oauth2?" . http_build_query([
    'client_id' => $config['client_id'],
    'redirect_uri' => $config['redirect_uri'],
    'response_type' => 'code',
    'scope' => 'com.intuit.quickbooks.accounting',
    'state' => 'secure123'
]);

header("Location: $url");
exit;