<?php


require_once __DIR__ . "/../../utils/utils.php";
require_once __DIR__ . "/../../controllers/UserController.php";

header("Content-Type: application/json");

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!$data) {
    error_response(400, "Invalid JSON.");
}
$email = $data['email'] ?? null;
$password = $data['password'] ?? null;

if (!$password || !$email) {
    error_response(420, "Missing ressources to create user.");
}

$user = new User($email, $password);

$user_controller = new UserController($user);

$user_info = $user_controller->retrieve();
