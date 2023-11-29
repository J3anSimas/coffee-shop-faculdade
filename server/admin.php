<?php
session_start();
if (!isset($_SESSION["USER"]["LVL"]) || $_SESSION["USER"]["LVL"] != "A") {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
$head_title = "Admin Dashboard";
$head_styles = array("admin.css");
include "templates/head.php";
?>

<body>
    <div class="container">
        <?php
        include "templates/header.php";
        ?>

        <main>
            <?php include "templates/admin_aside.php"; ?>
            <div class="main">
                <h2>Pedidos</h2>
                <ul>
                    <?php
                    require_once "includes/dbh.inc.php";
                    $query = "SELECT * FROM ORDERS ORDER BY ID DESC";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $query =
                            "SELECT 
                                SUM(TOTAL) AS SOMA 
                            FROM (
                                SELECT 
                                    PRICE * QUANTITY AS TOTAL 
                                FROM 
                                    CARTS_COFFEES 
                                WHERE 
                                    CART_ID = ?
                            ) AS GET_PRICE_TIMES_QUANTITY;";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$row["CART_ID"]]);
                        $price = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                        <li>
                            <a href="<?php echo "admin_order.php?order_id=" . $row["ID"] ?>">
                                <div class="address-info">
                                    <span><?php echo $row["NEIGHBORHOOD"] ?></span>
                                    <span><?php echo $row['CITY'] . " - " . $row["UF"]  ?></span>
                                    <span>
                                        <?php
                                        if ($row["STATUS"] == "P") {
                                            echo "Pendente";
                                        } else if ($row["STATUS"] == "C") {
                                            echo "Concluído";
                                        } else if ($row["STATUS"] == "X") {
                                            echo "Cancelado";
                                        } else {
                                            echo "Erro";
                                        }
                                        ?>
                                    </span>
                                </div>
                                <div class="price-container">
                                    <span>R$ <?php echo $price["SOMA"] ?></span>
                                </div>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </main>
    </div>
</body>

</html>