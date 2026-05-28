<?php
$tokenPath = __DIR__ . "/token.json";

if (file_exists($tokenPath)) {
    unlink($tokenPath);
}

echo "QuickBooks connection disconnected successfully.";