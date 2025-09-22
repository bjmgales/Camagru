<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($path, '/api/') === 0) {
    header("Content-Type: application/json");

    switch ($path) {
        case '/api/login':
            require __DIR__ . '/../api/auth/login.php';
            exit;
        case '/api/logout':
            require __DIR__ . '/../api/auth/logout.php';
            exit;
        case '/api/me':
            require __DIR__ . '/../api/auth/me.php';
            exit;
        case '/api/signup':
            require __DIR__ . '/../api/auth/signup.php';
            exit;
        case '/api/verification':
            require __DIR__ . '/../api/auth/verification.php';
            exit;
        default:
            error_response(404, "Not found");
            exit;
    }
    exit;
}

// For non-API routes, just stop here → Apache serves the static file
