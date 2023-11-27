<?php
session_start();
if ($_SESSION["USER"]["LVL"] != "A") {
    header("Location: login.php");
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
                    $sql = "SELECT * FROM ORDERS ORDER BY ID DESC";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $query = "SELECT SUM(COFFEES.PRICE * CARTS_COFFEES.QUANTITY) AS TOTAL FROM CARTS_COFFEES INNER JOIN COFFEES ON CARTS_COFFEES.COFFEE_ID = COFFEES.ID WHERE CART_ID = ?;";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$row["CART_ID"]]);
                        $price = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                        <li>
                            <a href="<?php echo "admin_order.php?order_id=" . $row["ID"] ?>">
                                <div class="address-info">
                                    <span><?php echo $row["NEIGHBORHOOD"] ?></span>
                                    <span><?php echo $row['CITY'] . " - " . $row["UF"]  ?></span>
                                </div>
                                <div class="price-container">
                                    <span>R$ <?php echo $price["TOTAL"] ?></span>
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