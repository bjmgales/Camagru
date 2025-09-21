<?php

function error_response($code, $message)
{
    http_response_code($code);
    $result = json_encode(['error' => $message]);

    echo $result;
    exit;
}

function success_response($payload)
{
    http_response_code(200);
    $result = json_encode($payload);
    echo $result;
    exit;
}
