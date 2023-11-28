<?php
session_start();
if ($_SESSION["USER"]["LVL"] != "A") {
    header("Location: login.php");
}
if (!isset($_GET["order_id"])) {
    header("Location: admin.php");
}
$head_title = "Admin Dashboard";
$head_styles = array("admin.css", "admin_order.css");
include "templates/head.php";
$order_id = $_GET["order_id"];
?>

<div class="container">
    <?php
    include "templates/header.php";
    ?>

    <main>
        <?php include "templates/admin_aside.php"; ?>
        <div class="main">
            <h2>Pedido #<?php echo $order_id ?></h2>

            <ul class="info-client">
                <li>
                    <span>
                        Nome do cliente
                    </span>
                    <span>Jean da Silva Simas</span>
                </li>
                <li>
                    <span>
                        Email do cliente
                    </span>
                    <span>jean@gmail.com</span>
                </li>
                <li>
                    <span>
                        Data
                    </span>
                    <span>25/11/2023</span>
                </li>
                <li>
                    <span>
                        Status
                    </span>
                    <span>Pendente</span>
                </li>
            </ul>
            <a href="/" class="complete-order">Concluir Pedido</a>

            <table class="order-table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once "includes/dbh.inc.php";
                    $query = "SELECT C.NAME, C.IMAGE, CC.QUANTITY, CC.PRICE FROM CARTS_COFFEES CC INNER JOIN COFFEES C ON CC.COFFEE_ID = C.ID WHERE CC.CART_ID = (SELECT CART_ID FROM ORDERS WHERE ID = ?);";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$order_id]);
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                    ?>
                        <tr>
                            <td class="prod-cell">
                                <img src="<?php echo $row["IMAGE"] ?>" alt="">
                                <span><?php echo $row["NAME"] ?> </span>
                            </td>
                            <td><?php echo $row["QUANTITY"] ?></td>
                            <td>R$ <?php echo $row["PRICE"] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
            </table>
        </div>
    </main>