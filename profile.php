<?php
require 'db.php';
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = "12345*";

header("Content-Type: application/json");

$headers = getallheaders();
if (!isset($headers['Authorization'])) {
    echo json_encode(["message" => "Authorization token required"]);
    exit;
}

$token = str_replace("Bearer ", "", $headers['Authorization']);

try {
    $decoded = JWT::decode($token, new Key($key, 'HS256'));
    $user_id = $decoded->sub;

    $stmt = $conn->prepare("SELECT id, email FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($user);
} catch (Exception $e) {
    echo json_encode(["message" => "Invalid token"]);
}
