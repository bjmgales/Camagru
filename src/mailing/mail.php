<?php
function send_verification_email(string $user, string $toEmail)
{
    $subject = "Welcome to camagru {$user}!";
    $rawToken = bin2hex(random_bytes(25));
    $verifyUrl = "http://localhost:8080/api/verification?token={$rawToken}";

    $message = <<<EOT
Hello $user,

Thanks for signing up! Please click the link below to verify your email address:

{$verifyUrl}

This link expires in 30 minutes.

If you didn’t request this, you can ignore this message.
EOT;

    $headers = [
        'From' => getenv('GMAIL_USER'),
        'Reply-To' => getenv('GMAIL_USER'),
        'X-Mailer' => 'PHP/' . phpversion()
    ];
    $headersStr = '';
    foreach ($headers as $key => $value) {
        $headersStr .= $key . ': ' . $value . "\r\n";
    }

    mail($toEmail, $subject, $message, $headersStr);
    return hash('sha256', $rawToken);
}
