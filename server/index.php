<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700&family=Inter:wght@300;400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Simas Café</title>
</head>

<body>
    <div class="container">
        <?php
        include "templates/header.php";
        ?>
        <main>
            <div class="cover">
                <div class="first-column">
                    <h1>Encontre o café perfeito para qualquer hora do dia</h1>
                    <p>No Simas Café você recebe seu café onde estiver, a qualquer hora</p>
                    <ul class="grid-list">
                        <li>
                            <span class="img-container" style="background-color: #C47F17;"><img src="images/icons/cart.svg" alt=""></span>
                            <p>Compra simples e segura</p>
                        </li>
                        <li class="">
                            <span class="img-container" style="background-color: #DBAC2C;"><img src="images/icons/timer.svg" alt=""></span>
                            <p>Entrega rápida e rastreada</p>
                        </li>
                        <li class="">
                            <span class="img-container" style="background-color: #574F4D;"><img src="images/icons/package.svg" alt=""></span>
                            <p>Embalagem mantém o café intacto</p>
                        </li>
                        <li class="">
                            <span class="img-container" style="background-color: #8047F8;"><img src="images/icons/coffee.svg" alt=""></span>
                            <p>O café chega fresquinho até você</p>
                        </li>
                    </ul>
                </div>
                <div class="image-container">
                    <img src="images/cover.png" alt="" class="image-cover">
                </div>
            </div>
            <div class="coffees-list-container">
                <h2>Nossos cafés auto</h2>
                <ul class="coffees-list">
                    <?php
                    try {
                        require_once "includes/dbh.inc.php";
                        $query = "select ID, NAME, DESCRIPTION, PRICE, CATEGORY, IMAGE from COFFEES;";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($results as $row) {
                    ?>
                            <li>
                                <img src="<?php echo $row["IMAGE"]; ?>  " alt=''>
                                <span class='coffee-category'>"<?php echo $row["CATEGORY"]; ?> "</span>
                                <h2><?php echo $row["NAME"]; ?></h2>
                                <p class='coffee-description'><?php echo $row["DESCRIPTION"]; ?></p>
                                <span class='add-to-cart-container'>
                                    <span class='price-container'>
                                        <span>R$</span>
                                        <span><?php echo sprintf('%0.2f', $row["PRICE"]); ?></span>
                                    </span>
                                    <button class='add-to-cart-button' data-id="<?php echo $row["ID"]; ?>"><img src='images/icons/cart.svg' /></button>
                                </span>
                            </li>
                    <?php
                        }
                        $pdo = null;
                        $stmt = null;
                        // die();
                    } catch (PDOException $e) {
                        echo "Failed to fetch coffees: " . $e->getMessage() . "";
                    }
                    ?>
                </ul>
            </div>
        </main>
    </div>
    <script>
        const addToCartButtons = document.querySelectorAll(".add-to-cart-button");
        addToCartButtons.forEach((button) => {
            button.addEventListener("click", () => {
                try {
                    const id = button.getAttribute("data-id");
                    console.log(id);
                    const url = `includes/addtocart.inc.php?id=${id}`;
                    fetch(url)
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                const cart_indicator = document.querySelector('#cart-indicator');
                                cart_indicator.classList.add('show');
                            } else {
                                alert(data.message);
                            }
                        });
                } catch (error) {
                    console.log(error);
                }
            });
        });
    </script>
</body>

</html>