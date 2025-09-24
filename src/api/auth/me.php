<?php
require_once __DIR__ . "/../../bootstrap.php";


header('Content-type: application/json');
if (isset($_SESSION[USERNAME])) {
    success_response([
        AUTHENTICATED => true,
        EMAIL => $_SESSION[EMAIL],
        USERNAME => $_SESSION[USERNAME]
    ]);
} else {
    error_response(500, [ERROR => false]);
    error_log('failure');
};
