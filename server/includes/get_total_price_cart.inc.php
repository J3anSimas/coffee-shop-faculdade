<?php
session_start();
require_once "dbh.inc.php";
if (!isset($_SESSION["USER"])) {
    header("Location: ../login.php");
    die();
}
try {
    $cart_id = $_GET['cart_id'];
    $query = "SELECT SUM(COFFEES.PRICE * CARTS_COFFEES.QUANTITY) AS TOTAL FROM CARTS_COFFEES INNER JOIN COFFEES ON CARTS_COFFEES.COFFEE_ID = COFFEES.ID WHERE CART_ID = ?;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$cart_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $response = array();
    $response["success"] = true;
    $response["total"] = $row["TOTAL"];
    echo json_encode($response);
} catch (PDOException $e) {
    $response = array();
    $response["success"] = false;
    $response["message"] = 'Erro ao calcular total do carrinho! ' . $e->getMessage();
    echo json_encode($response);
    die();
}
