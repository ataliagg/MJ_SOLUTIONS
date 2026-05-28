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

$to = 'MJG@mjcleaningsolution.com';
$subject = 'Nuevo mensaje desde el formulario de contacto';

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

$headers = [];
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-Type: text/plain; charset=UTF-8';
$headers[] = 'From: MJ Cleaning Solutions <no-reply@mjcleaningsolution.com>';
$headers[] = 'Reply-To: ' . cleanHeaderValue($name) . ' <' . cleanHeaderValue($email) . '>';

$sent = mail($to, $subject, implode("\r\n", $body), implode("\r\n", $headers));

if (!$sent) {
    http_response_code(500);
    exit('Error: no se pudo enviar el mensaje. Revisá la configuración de correo del servidor.');
}

header('Location: /thanks.php');
exit;
