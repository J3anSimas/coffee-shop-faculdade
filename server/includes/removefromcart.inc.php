<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'dbh.inc.php';
session_start();
if (!isset($_SESSION['USER'])) {
    header('Location: ../login.php');
    exit();
}
header('Content-Type: application/json');

try {
    $remove_all = $_GET['remove_all'];
    $coffee_id = $_GET['id'];
    $response = array();
    $query = "SELECT ID FROM CARTS WHERE STATUS = 'O' AND USER_ID = ?;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['USER']['ID']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $cart_id = $row['ID'];
    if (empty($row)) {
        throw new Exception("Carrinho não encontrado!");
    }
    if ($remove_all == 'true') {
        $query = "DELETE FROM CARTS_COFFEES WHERE CART_ID = ? AND COFFEE_ID = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$cart_id, $coffee_id]);
        $query = "SELECT COUNT(*) AS COUNT FROM CARTS_COFFEES WHERE CART_ID = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$cart_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['COUNT'] == 0) {
            $query = "DELETE FROM CARTS WHERE ID = ?;";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$cart_id]);
            $response['redirect'] = true;
        }
    } else {

        $query = "SELECT QUANTITY FROM CARTS_COFFEES WHERE CART_ID = ? AND COFFEE_ID = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$cart_id, $coffee_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['QUANTITY'] == 1) {
            throw new Exception("Item não pode ser removido do carrinho!");
        } else {
            $query = "UPDATE CARTS_COFFEES SET QUANTITY = QUANTITY - 1 WHERE CART_ID = ? AND COFFEE_ID = ?;";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$cart_id, $coffee_id]);
        }
    }
    header('Location: ../index.php');
} catch (PDOException $e) {
    $response = array();
    $response['success'] = false;
    $response['message'] = "Falha ao remover do carrinho\n" . $e->getMessage() . "";
    echo json_encode($response);
    exit();
}
