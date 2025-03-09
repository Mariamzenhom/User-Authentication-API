<?php
require 'db.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode(["message" => "Email and Password are required"]);
    exit;
}

$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);


try {
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->execute([$email, $password]);
    echo json_encode(["message" => "User registered successfully"]);
} catch (PDOException $e) {
    echo json_encode(["message" => "Error: " . $e->getMessage()]);
}



