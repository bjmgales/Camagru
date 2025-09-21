<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($path, '/api/') === 0) {
    header("Content-Type: application/json");

    switch ($path) {
        case '/api/login':
            require __DIR__ . '/../api/auth/login.php';
            break;
        case '/api/logout':
            require __DIR__ . '/../api/auth/logout.php';
            break;
        case '/api/me':
            require __DIR__ . '/../api/auth/me.php';
            break;
        case '/api/signup':
            require __DIR__ . '/../api/auth/signup.php';
            break;
        case '/api/verification':
            require __DIR__ . '/../api/auth/verification.php';
            break;
        default:
            http_response_code(404);
            echo json_encode(["error" => "Not found"]);
    }
    exit;
}

// For non-API routes, just stop here → Apache serves the static file
