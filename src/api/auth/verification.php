<?php

require_once __DIR__ . '/../../utils/sql_queries.php';
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../utils/utils.php';

function verify_user(string $token)
{
    if (!sql_exists(USER_TABLE, [TOKEN_HASH])) {
        error_response(404, EXPIRED_TOKEN); #TODO make exit more readable, rn in error_response thats shit
    }
    $tokenHash = hash('sha256', $token);
    sql_update(USER_TABLE, [TOKEN_HASH => null, TOKEN_CREATION_TIME => null, TOKEN_EXPIRES_AT => null, IS_VERIFIED => 1], TOKEN_HASH, $tokenHash);
    header("Location: /login?verification-success");
    exit;
}


$token = $_GET['token'] ?? NULL;
if (!$token) exit;
else verify_user($token);
