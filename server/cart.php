<?php
session_start();
if (!isset($_SESSION['USER'])) {
    header('Location: login.php');
    exit();
}
require_once 'includes/dbh.inc.php';
$query = "SELECT ID FROM CARTS WHERE USER_ID = ? AND STATUS = 'O';";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['USER']['ID']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (empty($row)) {
    header("Location: index.php");
    exit();
} else {
    $cart_id = $row['ID'];
    $query = "SELECT COFFEES.ID, COFFEES.NAME, COFFEES.PRICE, COFFEES.IMAGE, CARTS_COFFEES.QUANTITY FROM CARTS_COFFEES INNER JOIN COFFEES ON CARTS_COFFEES.COFFEE_ID = COFFEES.ID WHERE CART_ID = ?;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$cart_id]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
$head_title = "Carrinho";
$head_styles = array("cart.css");
include "templates/head.php";
?>

<body>
    <?php
    include "templates/header.php";
    ?>
    <main>
        <form class="cart-form" method="post" action="includes/closeorder.inc.php">
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
                        <input type="text" required placeholder="CEP" maxlength="9" pattern="\d{5,5}-\d{3,3}" name="zipcode">
                        <input type="text" required placeholder="Rua" maxlength="255" name="street">
                        <input type="text" required placeholder="Número" maxlength="255" name="number">
                        <input type="text" required placeholder="Complemento" maxlength="255" name="complement">
                        <input type="text" required placeholder="Bairro" maxlength="255" name="neighborhood">
                        <input type="text" required placeholder="Cidade" maxlength="255" name="city">
                        <input type="text" required placeholder="UF" maxlength="2" name="uf">
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
                    <span class="payment-method">
                        <input type="hidden" name="payment_method" required id="payment-method" pattern="^(CC|CD|D)$">
                        <button type="button" data-type="CC"><img src="images/icons/credit-card.svg" alt=""> Cartão de Crédito</button>
                        <button type="button" data-type="CD"><img src="images/icons/bank.svg" alt=""> Cartão de Débito</button>
                        <button type="button" data-type="D"><img src="images/icons/cash.svg" alt=""> Dinheiro</button>
                    </span>
                    <?php
                    if (isset($_GET['error'])) {
                    ?>
                        <span class="error-message"><?php echo $_GET['error']; ?></span>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="coffees-list-info-container">
                <h2>Cafés selecionados</h2>
                <div>
                    <ul>
                        <?php
                        foreach ($results as $row) {
                        ?>
                            <li data-id="<?php echo $row["ID"] ?>">
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
                                            <button type="button" class="button-decrease-one" <?php echo $row["QUANTITY"] == 1 ? "disabled" : ""; ?>><img src="images/icons/minus.svg" alt=""></button>
                                            <span><?php echo $row["QUANTITY"]; ?></span>
                                            <button type="button" class="button-increase-one"><img src="images/icons/plus.svg" alt=""></button>
                                        </span>
                                        <button class="button-remove-item" type="button"><img src="images/icons/trash.svg" alt=""> Remover</button>
                                    </span>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                    <div class="price-info">
                        <span>
                            <span>Total de itens</span>
                            <span class="total-items">R$
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
                            <span>R$ 3.50</span>
                        </span>
                        <span>
                            <strong>Total</strong>
                            <strong>R$ <?php echo sprintf('%0.2f', $row["TOTAL"] + 3.5); ?></strong>
                        </span>
                    </div>
                    <button class="button-confirm">CONFIRMAR PEDIDO</button>
                </div>
            </div>
        </form>
    </main>
    <script>
        document.querySelectorAll('.payment-method > button').forEach(currentButton => {
            currentButton.addEventListener('click', () => {
                document.querySelectorAll('.payment-method > button').forEach(button => {
                    button.classList.remove('active');
                });
                currentButton.classList.add('active');
                document.querySelector('#payment-method').value = currentButton.getAttribute('data-type');
            });
        });
        document.querySelectorAll('.button-remove-item').forEach(currentButton => {
            currentButton.addEventListener('click', () => {
                const coffeeId = currentButton.closest('li').getAttribute('data-id');
                fetch(`includes/removefromcart.inc.php?id=${coffeeId}&remove_all=true`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data.redirect)
                        if (data.redirect) {
                            window.location.href = 'index.php';
                        } else {
                            if (data.success) {
                                currentButton.closest('li').remove();
                                getTotalPrice();
                            } else {
                                alert(data.message);
                            }
                        }
                    });
            });
        });
        document.querySelectorAll('.quantity-handler .button-increase-one').forEach(currentButton => {
            currentButton.addEventListener('click', () => {
                const coffeeId = currentButton.closest('li').getAttribute('data-id');
                fetch(`includes/addtocart.inc.php?id=${coffeeId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            currentButton.closest('li').querySelector('.quantity-handler > span:nth-child(2)').innerText = parseInt(currentButton.closest('li').querySelector('.quantity-handler > span:nth-child(2)').innerText) + 1;
                            currentButton.closest('li').querySelector('.button-decrease-one').removeAttribute('disabled');
                            getTotalPrice();
                        }
                    });
            });
        });
        document.querySelectorAll('.quantity-handler .button-decrease-one').forEach(currentButton => {
            currentButton.addEventListener('click', () => {
                const coffeeId = currentButton.closest('li').getAttribute('data-id');
                fetch(`includes/removefromcart.inc.php?id=${coffeeId}&remove_all=false`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            currentButton.closest('li').querySelector('.quantity-handler > span:nth-child(2)').innerText = parseInt(currentButton.closest('li').querySelector('.quantity-handler > span:nth-child(2)').innerText) - 1;
                            currentButton.closest('li').querySelector('.quantity-handler > span:nth-child(2)').innerText == 1 ? currentButton.setAttribute('disabled', true) : currentButton.removeAttribute('disabled');
                            getTotalPrice();
                        }
                    });
            });
        });

        function getTotalPrice() {
            fetch(`includes/get_total_price_cart.inc.php?cart_id=${<?php echo $cart_id; ?>}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector('.total-items').innerText = `R$ ${Number(data.total).toFixed(2)}`;
                        document.querySelector('.price-info > span:nth-child(3) > strong:nth-child(2)').innerText = `R$ ${(3.5 + Number(data.total)).toFixed(2)}`;
                    }
                });
        }
    </script>
</body>

</html>