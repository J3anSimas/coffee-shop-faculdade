<?php
require_once "includes/dbh.inc.php";
session_start();
if (!isset($_SESSION["USER"])) {
    header("Location: login.php");
    exit();
}
if (!isset($_GET['order_id'])) {
    header('Location: index.php');
    exit();
}
$query = "SELECT O.STREET AS STREET, O.NUMBER AS NUMBER, O.CITY AS CITY, O.UF AS UF, O.PAYMENT_METHOD AS PAYMENT_METHOD FROM ORDERS O JOIN CARTS C ON C.ID = O.CART_ID WHERE O.ID = ? AND C.USER_ID = ?;";
$stmt = $pdo->prepare($query);
$stmt->execute([$_GET['order_id'], $_SESSION['USER']['ID']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!is_array($row) || empty($row)) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
$head_title = "Pedido Confirmado";
$head_styles = array("order_success.css");
include "./templates/head.php";
?>

<body>
    <?php
    include './templates/header.php';
    ?>
    <main>
        <div class="message-success">
            <h2>Uhu! Pedido Confirmado</h2>
            <p>Agora é só aguardar que logo o café chegará até você</p>
        </div>
        <div class="container">
            <div class="info">
                <ul>
                    <?php
                    $query = "SELECT 
                        O.STREET AS STREET, 
                        O.NUMBER AS NUMBER, 
                        O.CITY AS CITY, 
                        O.UF AS UF, 
                        CASE O.PAYMENT_METHOD
                            WHEN 'D' THEN 'Dinheiro'
                            WHEN 'CC' THEN 'Cartão de Crédito'
                            WHEN 'CD' THEN 'Cartão de Débito'
                        END AS PAYMENT_METHOD
                    FROM 
                        ORDERS O 
                    JOIN CARTS C 
                        ON C.ID = O.CART_ID 
                    WHERE 
                        O.ID = ? AND C.USER_ID = ?;";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$_GET['order_id'], $_SESSION['USER']['ID']]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <li>
                        <div style="background-color: #8047F8" class="image-container"><img src="images/icons/location-filled.svg" alt=""></div>
                        <span>
                            <?php
                            ?>
                            <span>Entrega em <strong><?php echo $row["STREET"] . ", " . $row["NUMBER"]; ?></strong></span>
                            <span><?php echo $row["CITY"] . " - " . $row["UF"]; ?></span>
                        </span>
                    </li>
                    <li>
                        <div class="image-container" style="background-color: #DBAC2C;"><img src="images/icons/timer.svg" alt=""></div>
                        <span>
                            <span>Previsão de entrega</span>
                            <strong>20 min - 30 min</strong>
                        </span>
                    </li>
                    <li>
                        <div class="image-container" style="background-color: #C47F17;"><img src="images/icons/currency.svg" alt=""></div>
                        <span>
                            <span>Pagamento na entrega</span>
                            <strong>
                                <?php
                                echo $row["PAYMENT_METHOD"];
                                ?>
                            </strong>
                        </span>
                    </li>
                </ul>
            </div>
            <img class="cover-image" src="images/order-success-image.svg" alt="">
        </div>
    </main>
</body>

</html>