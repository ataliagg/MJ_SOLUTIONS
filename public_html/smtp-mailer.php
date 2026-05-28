<?php

function smtpReadResponse($socket) {
    $lines = [];
    $code = null;

    while (!feof($socket)) {
        $line = fgets($socket, 515);
        if ($line === false) {
            break;
        }

        $lines[] = trim($line);

        if (preg_match('/^(\d{3})([ -])/', $line, $matches)) {
            $code = (int) $matches[1];
            if ($matches[2] === ' ') {
                break;
            }
        }
    }

    return [$code, implode("\n", $lines)];
}

function smtpSendCommand($socket, $command, array $expectedCodes) {
    fwrite($socket, $command . "\r\n");
    [$code, $response] = smtpReadResponse($socket);

    if (!in_array($code, $expectedCodes, true)) {
        throw new RuntimeException("SMTP error after '{$command}': {$response}");
    }

    return $response;
}

function smtpSendEmail(array $config, array $message) {
    $host = $config['smtp_host'] ?? 'smtp.hostinger.com';
    $port = (int) ($config['smtp_port'] ?? 465);
    $encryption = strtolower((string) ($config['smtp_encryption'] ?? 'ssl'));
    $username = $config['smtp_username'] ?? '';
    $password = $config['smtp_password'] ?? '';
    $fromEmail = $config['from_email'] ?? $username;
    $fromName = $config['from_name'] ?? 'MJ Cleaning Solutions';
    $toEmail = $config['to_email'] ?? $fromEmail;

    if ($username === '' || $password === '') {
        throw new RuntimeException('Faltan las credenciales SMTP en email-config.php.');
    }

    $remote = ($encryption === 'ssl' ? 'ssl://' : '') . $host . ':' . $port;
    $socket = stream_socket_client($remote, $errno, $errstr, 30, STREAM_CLIENT_CONNECT);

    if (!$socket) {
        throw new RuntimeException("No se pudo conectar al SMTP: {$errstr} ({$errno})");
    }

    stream_set_timeout($socket, 30);

    try {
        [$code, $response] = smtpReadResponse($socket);
        if ($code !== 220) {
            throw new RuntimeException("SMTP no respondió correctamente al iniciar: {$response}");
        }

        $hostname = gethostname() ?: 'localhost';
        smtpSendCommand($socket, "EHLO {$hostname}", [250]);

        if ($encryption !== 'ssl' && $encryption !== 'none') {
            smtpSendCommand($socket, 'STARTTLS', [220]);
            if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                throw new RuntimeException('No se pudo iniciar TLS sobre SMTP.');
            }
            smtpSendCommand($socket, "EHLO {$hostname}", [250]);
        }

        smtpSendCommand($socket, 'AUTH LOGIN', [334]);
        smtpSendCommand($socket, base64_encode($username), [334]);
        smtpSendCommand($socket, base64_encode($password), [235]);

        smtpSendCommand($socket, "MAIL FROM:<{$fromEmail}>", [250]);
        smtpSendCommand($socket, "RCPT TO:<{$toEmail}>", [250, 251]);
        smtpSendCommand($socket, 'DATA', [354]);

        $headers = [];
        $headers[] = 'From: ' . $fromName . ' <' . $fromEmail . '>';
        $headers[] = 'Reply-To: ' . $message['replyToName'] . ' <' . $message['replyToEmail'] . '>';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: text/plain; charset=UTF-8';
        $headers[] = 'Content-Transfer-Encoding: 8bit';
        $headers[] = 'Subject: ' . $message['subject'];
        $headers[] = 'Date: ' . date(DATE_RFC2822);

        $payload = implode("\r\n", $headers) . "\r\n\r\n" . $message['body'];
        $payload = preg_replace('/^\./m', '..', $payload);
        fwrite($socket, $payload . "\r\n.\r\n");

        [$code, $response] = smtpReadResponse($socket);
        if ($code !== 250) {
            throw new RuntimeException("SMTP falló al enviar DATA: {$response}");
        }

        smtpSendCommand($socket, 'QUIT', [221]);
    } finally {
        fclose($socket);
    }

    return true;
}
