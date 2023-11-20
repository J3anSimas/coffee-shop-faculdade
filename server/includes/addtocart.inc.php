<?php
require_once 'dbh.inc.php';
session_start();
if (!isset($_SESSION['USER'])) {
    header('Location: ../login.php');
    exit();
}
try {
    $coffee_id = $_GET['id'];
    $cart_id = null;

    $query = "SELECT ID FROM CARTS WHERE USER_ID = ? AND STATUS = 'O';";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['USER']['ID']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (empty($row)) {
        $query = "INSERT INTO CARTS (USER_ID, STATUS) VALUES (?, 'O');";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_SESSION['USER']['ID']]);
        $query = "SELECT ID FROM CARTS WHERE USER_ID = ? AND STATUS = 'O';";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_SESSION['USER']['ID']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    $cart_id = $row['ID'];
    $query = "SELECT QUANTITY FROM CARTS_COFFEES WHERE CART_ID = ? AND COFFEE_ID = ?;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$cart_id, $coffee_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (empty($row)) {
        $query = "INSERT INTO CARTS_COFFEES (CART_ID, COFFEE_ID, QUANTITY) VALUES (?, ?, 1);";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$cart_id, $coffee_id]);
    } else {
        $query = "UPDATE CARTS_COFFEES SET QUANTITY = QUANTITY + 1 WHERE CART_ID = ? AND COFFEE_ID = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$cart_id, $coffee_id]);
    }
    echo "{ \"success\": true, \"message\": \"Item adicionado ao carrinho!\" }";
} catch (PDOException $e) {
    echo "{ \"success\": false, \"message\": \"Erro ao adicionar item ao carrinho!\n" . $e->getMessage() . "\" }";
}
