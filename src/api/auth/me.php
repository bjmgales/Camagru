<?php
require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../utils/utils.php";

session_start();
header('Content-type: application/json');

if (isset($_SESSION[USERNAME])) {
    success_response([
        'authenticated' => true,
        'email' => $_SESSION[EMAIL],
        'user_id' => $_SESSION[USERNAME]
    ]);
    error_log('success');
} else {
    error_response(500, [ERROR => false]);
    error_log('failure');
};
