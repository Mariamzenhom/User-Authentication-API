<?php
require 'db.php';
require 'vendor/autoload.php';

use Firebase\JWT\JWT;

$key = "12345*"; 

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode(["message" => "Email and Password are required"]);
    exit;
}

$email = $data['email'];
$password = $data['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $payload = [
        "iss" => "localhost",
        "iat" => time(),
        "exp" => time() + (60 * 60), 
        "sub" => $user['id']
    ];

    $jwt = JWT::encode($payload, $key, 'HS256');
    echo json_encode(["token" => $jwt]);
} else {
    echo json_encode(["message" => "Invalid email or password"]);
}
