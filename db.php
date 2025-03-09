<?php

$host = 'localhost';
$database = 'use_auth';
$name = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $name, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}