<?php
session_start();
if ($_SESSION["USER"]["LVL"] != "A") {
    header("Location: login.php");
}
if (!isset($_GET["order_id"])) {
    header("Location: admin.php");
}
$order_id = $_GET["order_id"];

try {
    require_once "dbh.inc.php";
    $query = "SELECT STATUS FROM ORDERS WHERE ID = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$order_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($result["STATUS"]) && $result["STATUS"] != "P") {
        header("Location: ../admin.php");
        die();
    }
    $query = "UPDATE ORDERS SET STATUS = 'X' WHERE ID = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$order_id]);
    header("Location: ../admin_order.php?order_id=$order_id");
} catch (PDOException $e) {
    echo $e->getMessage();
}
