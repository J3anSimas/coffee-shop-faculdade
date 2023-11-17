<?php
session_start();
if (!isset($_SESSION['USER'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/cart.css">
    <title>Simas Café | Carrinho</title>
</head>

<body>
    <?php
    include "templates/header.php";
    ?>
    <main>
        <form class="cart-form">
            <div class="additional-info-container">
                <h2>Complete seu pedido</h2>
                <div>
                    <span>
                        <img src="images/icons/location.svg" alt="">
                        <span>
                            <span>Endereço de Entrega</span>
                            <span>Informe o endereço onde deseja receber seu pedido</span>
                        </span>
                    </span>
                    <div class="fields-container">
                        <input type="text" placeholder="CEP">
                        <input type="text" placeholder="Rua">
                        <input type="text" placeholder="Número">
                        <input type="text" placeholder="Complemento">
                        <input type="text" placeholder="Bairro">
                        <input type="text" placeholder="Cidade">
                        <input type="text" placeholder="UF">
                    </div>
                </div>
                <div>
                    <span>
                        <img src="images/icons/currency.svg" alt="">
                        <span>
                            <span>Pagamento</span>
                            <span>O pagamento é feito na entrega. Escolha a forma que deseja pagar</span>
                        </span>
                    </span>
                    <button><img src="images/icons/credit-card.svg" alt=""> Cartão de Crédito</button>
                    <button><img src="images/icons/bank.svg" alt=""> Cartão de Débito</button>
                    <button><img src="images/icons/cash.svg" alt=""> Dinheiro</button>
                </div>
            </div>
            <div class="coffees-list-info-container">
                <h2>Cafés selecionados</h2>
                <div>
                    <ul>
                        <?php
                        require_once 'includes/dbh.inc.php';
                        $query = "SELECT ID FROM CARTS WHERE USER_ID = ? AND STATUS = 'O';";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$_SESSION['USER']['ID']]);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (!empty($row)) {
                            $cart_id = $row['ID'];
                            $query = "SELECT COFFEES.ID, COFFEES.NAME, COFFEES.PRICE, COFFEES.IMAGE, CARTS_COFFEES.QUANTITY FROM CARTS_COFFEES INNER JOIN COFFEES ON CARTS_COFFEES.COFFEE_ID = COFFEES.ID WHERE CART_ID = ?;";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute([$cart_id]);
                            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($results as $row) {
                        ?>
                                <li>
                                    <div class="cart-item-image-container">
                                        <img src="<?php echo $row["IMAGE"]; ?>" alt="">
                                    </div>
                                    <div>
                                        <div class="cart-item-info-name-price">
                                            <h2><?php echo $row["NAME"]; ?></h2>
                                            <p>R$ <?php echo $row["PRICE"]; ?></p>
                                        </div>
                                        <span class="item-handler">
                                            <span class="quantity-handler">
                                                <button type="button"><img src="images/icons/minus.svg" alt=""></button>
                                                <span><?php echo $row["QUANTITY"]; ?></span>
                                                <button type="button"><img src="images/icons/plus.svg" alt=""></button>
                                            </span>
                                            <button><img src="images/icons/trash.svg" alt=""> Remover</button>
                                        </span>
                                    </div>
                                </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                    <div class="price-info">
                        <span>
                            <span>Total de itens</span>
                            <span>R$
                                <?php
                                $query = "SELECT SUM(COFFEES.PRICE * CARTS_COFFEES.QUANTITY) AS TOTAL FROM CARTS_COFFEES INNER JOIN COFFEES ON CARTS_COFFEES.COFFEE_ID = COFFEES.ID WHERE CART_ID = ?;";
                                $stmt = $pdo->prepare($query);
                                $stmt->execute([$cart_id]);
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo sprintf('%0.2f', $row['TOTAL']);
                                ?>
                            </span>
                        </span>
                        <span>
                            <span>Entrega</span>
                            <span>R$ 3,50</span>
                        </span>
                        <span>
                            <span>Total</span>
                            <span>R$ <?php echo sprintf('%0.2f', $row["TOTAL"] + 3.5); ?></span>
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </main>
</body>

</html>