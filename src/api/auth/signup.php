<?php
require_once __DIR__ . "/../../bootstrap.php";
require_once __DIR__ . "/../../controllers/UserController.php";

header("Content-Type: application/json");

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!$data) {
    error_response(400, "Invalid JSON.");
}

$username = $data['username'] ?? null;
$email = $data['email'] ?? null;
$password = $data['password'] ?? null;

if (!$username || !$password || !$email) {
    error_response(420, "Missing ressources to create user.");
}

$user = new User($email, $password, $username);
$userController = new UserController($user);

$response = $userController->register();
echo $response;
exit;
