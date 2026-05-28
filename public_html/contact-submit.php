<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /contact.html');
    exit;
}

function cleanText($value) {
    return trim((string) $value);
}

function cleanHeaderValue($value) {
    $value = trim((string) $value);
    return preg_replace("/[\r\n]+/", ' ', $value);
}

$emailConfig = require __DIR__ . '/email-config.php';

$name = cleanText($_POST['name'] ?? '');
$email = cleanText($_POST['email'] ?? '');
$phone = cleanText($_POST['phone'] ?? '');
$service = cleanText($_POST['service'] ?? '');
$message = cleanText($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    http_response_code(400);
    exit('Error: faltan campos obligatorios.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit('Error: el email no es válido.');
}

$subject = 'Nuevo mensaje desde el formulario de contacto';

require_once __DIR__ . '/smtp-mailer.php';

$body = [];
$body[] = "Nuevo mensaje recibido desde el sitio web:";
$body[] = "";
$body[] = "Nombre: {$name}";
$body[] = "Email: {$email}";
$body[] = "Teléfono: " . ($phone !== '' ? $phone : 'No proporcionado');
$body[] = "Servicio: " . ($service !== '' ? $service : 'No proporcionado');
$body[] = "";
$body[] = "Mensaje:";
$body[] = $message;
$body[] = "";
$body[] = '---';
$body[] = 'Enviado desde mjcleaningsolutions.com';

try {
    smtpSendEmail($emailConfig, [
        'subject' => $subject,
        'body' => implode("\r\n", $body),
        'replyToName' => cleanHeaderValue($name),
        'replyToEmail' => cleanHeaderValue($email),
    ]);
} catch (Throwable $e) {
    error_log('Contact form SMTP error: ' . $e->getMessage());
    http_response_code(500);
    exit('Error: no se pudo enviar el mensaje. ' . $e->getMessage());
}

header('Location: /thanks.php');
exit;
