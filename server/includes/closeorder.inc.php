<?php
require_once 'dbh.inc.php';
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['USER'])) {
    header('Location: ../login.php');
    exit();
}
try {
    $zipcode = $_POST['zipcode'];
    $street = $_POST['street'];
    $number = $_POST['number'];
    $complement = $_POST['complement'];
    $neighborhood = $_POST['neighborhood'];
    $city = $_POST['city'];
    $uf = $_POST['uf'];
    $payment_method = $_POST['payment_method'];
    if (empty($zipcode) || empty($street) || empty($number) || empty($neighborhood) || empty($city) || empty($uf) || empty($payment_method)) {
        header('Location: ../cart.php?error=Preencha todos os campos!');
        die();
    }
    $query = "SELECT ID FROM CARTS WHERE STATUS = 'O' AND USER_ID = ?;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['USER']['ID']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $cart_id = $row['ID'];
    if (empty($row)) {
        throw new Exception("Carrinho não encontrado!");
    }
    $query = "SELECT CC.ID, C.PRICE FROM CARTS_COFFEES CC JOIN COFFEES C ON C.ID = CC.COFFEE_ID WHERE CC.CART_ID = ?;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$cart_id]);
    $coffees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($coffees as $coffee) {
        $query = "UPDATE CARTS_COFFEES SET PRICE = ? WHERE ID = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$coffee['PRICE'], $coffee['ID']]);
    }
    $query = "UPDATE CARTS SET STATUS = 'C' WHERE ID = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$cart_id]);
    $query = "INSERT INTO ORDERS (CART_ID, ZIPCODE, STREET, NUMBER, COMPLEMENT, NEIGHBORHOOD, CITY, UF, PAYMENT_METHOD) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$cart_id, $zipcode, $street, $number, $complement, $neighborhood, $city, $uf, $payment_method]);
    header('Location: ../orders.php');
    exit();
} catch (PDOException $e) {
    header('Location: ../cart.php?error=Erro ao fechar pedido!\n' . $e->getMessage() . '');
    exit();
}
