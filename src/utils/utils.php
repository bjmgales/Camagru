<?php

function error_response($code, $message)
{
    http_response_code($code);
    $result = json_encode(['error' => $message]);

    echo $result;
}

function success_response($payload)
{
    http_response_code(200);
    $result = json_encode($payload);
    echo $result;
}

function sanitize_user_inputs(array|string $input)
{
    if (is_array(($input))) {
        return array_map(fn($elem) => htmlspecialchars($elem, ENT_QUOTES, 'UTF-8'), $input);
    }
    return htmlspecialchars($input, ENT_QUOTES, "UTF-8");
}
