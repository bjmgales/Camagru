<?php


require_once __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../controllers/UserController.php";

header("Content-Type: application/json");

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!$data) {
    error_response(400, "Invalid JSON.");
}
$user_id = $data['id'] ?? null;
$password = $data['password'] ?? null;

if (!$password || !$user_id) {
    error_response(420, "Missing ressources to login.");
    exit;
}

$user = new User($user_id, $password, $user_id);

$user_controller = new UserController($user);

$user_info = $user_controller->retrieve();
