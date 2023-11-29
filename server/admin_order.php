<?php
session_start();

if (!isset($_SESSION["USER"]["LVL"]) || $_SESSION["USER"]["LVL"] != "A") {
    header("Location: index.php");
}

if (!isset($_GET["order_id"])) {
    header("Location: admin.php");
}
$head_title = "Admin - Pedidos";
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
            <?php
            $query =
                "SELECT 
                U.NAME, 
                U.EMAIL, 
                O.CREATED_AT DATE,
                CASE O.STATUS 
                    WHEN 'P' THEN 'Pendente' 
                    WHEN 'C' THEN 'Concluído' 
                    WHEN 'X' THEN 'Cancelado' 
                END STATUS, 
                O.STREET, 
                O.NEIGHBORHOOD, 
                O.CITY, 
                O.NUMBER, 
                O.COMPLEMENT 
            FROM ORDERS O 
            INNER JOIN CARTS C
                ON O.CART_ID = C.ID
            INNER JOIN USERS U 
                ON C.USER_ID = U.ID 
            WHERE O.ID = ?;
            ";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$order_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <span class="header-info">
                <ul class="info-client">
                    <li>
                        <span>
                            Nome do cliente:
                        </span>
                        <span><?php echo ucwords($result["NAME"]) ?></span>
                    </li>
                    <li>
                        <span>
                            Email do cliente:
                        </span>
                        <span><?php echo $result["EMAIL"] ?></span>
                    </li>
                    <li>
                        <span>
                            Data:
                        </span>
                        <span><?php echo date_format(date_create($result["DATE"]), 'd/m/Y') ?></span>
                    </li>
                    <li>
                        <span>
                            Status:
                        </span>
                        <span style="font-weight: bold"><?php echo $result["STATUS"] ?></span>

                    </li>
                </ul>
                <span class="order-actions">
                    <?php
                    if ($result["STATUS"] == "Pendente") {
                    ?>
                        <a href="/includes/complete_order.inc.php?order_id=<?php echo $order_id ?>" class="complete-order">Concluir Pedido</a>
                        <a href="/cancel_order.inc.php?order_id=<?php echo $order_id ?>" class="cancel-order">Cancelar Pedido</a>
                    <?php
                    }
                    ?>
                </span>
            </span>
            <span class="header-info">
                <ul class="info-address">
                    <li>
                        <span>
                            Endereço:
                        </span>
                        <span><?php echo ucwords($result["STREET"]) . ", " . $result["NUMBER"] ?></span>
                    </li>
                    <li>
                        <span>
                            Bairro:
                        </span>
                        <span><?php echo ucwords($result["NEIGHBORHOOD"]) ?></span>
                    </li>
                    <li>
                        <span>
                            Cidade:
                        </span>
                        <span><?php echo ucwords($result["CITY"]) ?></span>
                    </li>
                    <li>
                        <span>
                            Complemento:
                        </span>
                        <span><?php echo ucwords($result["COMPLEMENT"]) ?></span>
                    </li>
                </ul>
            </span>

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
                            <td class="price-cell">R$ <?php echo sprintf("%0.2f", $row["PRICE"]) ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <?php
                    $query =
                        "SELECT 
                        SUM(TOTAL) AS SOMA 
                    FROM (
                        SELECT 
                            PRICE * QUANTITY AS TOTAL 
                        FROM 
                            CARTS_COFFEES 
                        WHERE 
                            CART_ID = (SELECT CART_ID FROM ORDERS WHERE ID = ?)
                        ) AS GET_PRICE_TIMES_QUANTITY;";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$order_id]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <tr class="total-row">
                        <td>Total</td>
                        <td></td>
                        <td class="price-cell">
                            <?php
                            echo "R$ " . sprintf("%0.2f", $result["SOMA"]);
                            ?>
                        </td>
                    </tr>
            </table>
        </div>
    </main>