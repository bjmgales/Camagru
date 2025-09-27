<?php
require_once __DIR__ . "/../../bootstrap.php";

$_SESSION = [];

session_destroy();
success_response(200, 'LOGOUT');