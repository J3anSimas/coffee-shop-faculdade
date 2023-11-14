<?php
$host = "db";
$port = 3306;
$user = "user";
$password = "secret";
$dbname = "coffeeshop";

$dsn = "mysql:host=$host;port=$port;dbname=$dbname";
try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "";
    die();
}
