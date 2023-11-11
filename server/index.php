<?php
session_start();
class coffee
{
    public $name;
    public $category;
    public $description;
    public $price;
    public $image;
    function __construct($name, $category, $description, $price, $image)
    {
        $this->name = $name;
        $this->category = $category;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;
    }
}
$coffees = array();
$coffees[0] = new coffee("Expresso Americano", "TRADICIONAL", "Expresso diluído, menos intenso que o tradicional", 9.90, "images/coffees/Americano.png");
$coffees[1] = new coffee("Árabe", "ESPECIAL", "Bebida preparada com grãos de café árabe e especiarias", 9.90, "images/coffees/Arabe.png");
$coffees[2] = new coffee("Café com Leite", "COM LEITE", "Meio a meio de expresso tradicional com leite vaporizado", 9.90, "images/coffees/CafeComLeite.png");
$coffees[3] = new coffee("Expresso Gelado", "GELADO", "Bebida preparada com café expresso e cubos de gelo", 9.90, "images/coffees/CafeGelado.png");
$coffees[4] = new coffee("Capuccino", "COM LEITE", "Bebida com canela feita de doses iguais de café, leite e espuma", 9.90, "images/coffees/Capuccino.png");
$coffees[5] = new coffee("Chocolate Quente", "COM LEITE", "Bebida feita com chocolate dissolvido no leite quente e café", 9.90, "images/coffees/ChocolateQuente.png");
$coffees[6] = new coffee("Cubano", "ALCOÓLICO", "Drink gelado de café expresso com rum, creme de leite e hortelã", 9.90, "images/coffees/Cubano.png");
$coffees[7] = new coffee("Expresso Cremoso", "TRADICIONAL", "Café expresso tradicional com espuma cremosa", 9.90, "images/coffees/ExpressoCremoso.png");
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
        <header>
            <div class="content">
                <a href="/" class="logo">Simas Café</a>
                <nav>
                    <?php
                    if (isset($_SESSION['user'])) {
                        ?>
                        <a class='cart-link'><img src='images/icons/cart.svg' /></a><a href='logout.php'>Sair</a>
                    <?php
                    } else {
                    ?>
                        <a href='login.php'>Faça Login</a>
                    <?php
                    }
                    ?>
                </nav>
            </div>
        </header>
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
                <div>
                    <img src="images/cover.png" alt="" class="image-cover">
                </div>
            </div>
            <div class="coffees-list-container">
                <h2>Nossos cafés</h2>
                <ul class="coffees-list">
                    <?php
                    for ($i = 0; $i < count($coffees); $i++) {
                        echo "<li>
                        <img src='" . $coffees[$i]->image . "' alt=''>
                        <span class='coffee-category'>" . $coffees[$i]->category . "</span>
                        <h2>" . $coffees[$i]->name . "</h2>
                        <p class='coffee-description'>" . $coffees[$i]->description . "</p>
                        <span class='add-to-cart-container'>
                            <span class='price-container'>
                                <span>R$</span>
                                <span>" . sprintf('%0.2f', $coffees[$i]->price) . "</span>
                            </span>
                            <button><img src='images/icons/cart.svg' /></button>
                        </span>
                        </li>";
                    }
                    ?>
                    <!-- <li>
                        <img src="images/coffees/Arabe.png" alt="">
                        <span class="coffee-category">ESPECIAL</span>
                        <h2>Árabe</h2>
                        <p class="coffee-description">Bebida preparada com grãos de café árabe e especiarias</p>
                        <span class="add-to-cart-container">
                            <span class="price-container">
                                <span>R$</span>
                                <span>9,90</span>
                            </span>
                            <button><img src="images/icons/cart.svg" /></button>
                        </span>
                    </li>
                    <li>
                        <img src="images/coffees/CafeComLeite.png" alt="">
                        <span class="coffee-category">COM LEITE</span>
                        <h2>Café com Leite</h2>
                        <p class="coffee-description">Meio a meio de expresso tradicional com leite vaporizado</p>
                        <span class="add-to-cart-container">
                            <span class="price-container">
                                <span>R$</span>
                                <span>9,90</span>
                            </span>
                            <button><img src="images/icons/cart.svg" /></button>
                        </span>
                    </li>
                    <li>
                        <img src="images/coffees/CafeGelado.png" alt="">
                        <span class="coffee-category">GELADO</span>
                        <h2>Expresso Gelado</h2>
                        <p class="coffee-description">Bebida preparada com café expresso e cubos de gelo</p>
                        <span class="add-to-cart-container">
                            <span class="price-container">
                                <span>R$</span>
                                <span>9,90</span>
                            </span>
                            <button><img src="images/icons/cart.svg" /></button>
                        </span>
                    </li>
                    <li> <img src="images/coffees/Capuccino.png" alt="">
                        <span class="coffee-category">COM LEITE</span>
                        <h2>Capuccino</h2>
                        <p class="coffee-description">Bebida com canela feita de doses iguais de café, leite e espuma
                        </p>
                        <span class="add-to-cart-container">
                            <span class="price-container">
                                <span>R$</span>
                                <span>9,90</span>
                            </span>
                            <button><img src="images/icons/cart.svg" /></button>
                        </span>
                    </li>
                    <li> <img src="images/coffees/ChocolateQuente.png" alt="">
                        <span class="coffee-category">COM LEITE</span>
                        <h2>Chocolate Quente</h2>
                        <p class="coffee-description">Bebida feita com chocolate dissolvido no leite quente e café</p>
                        <span class="add-to-cart-container">
                            <span class="price-container">
                                <span>R$</span>
                                <span>9,90</span>
                            </span>
                            <button><img src="images/icons/cart.svg" /></button>
                        </span>
                    </li>
                    <li> <img src="images/coffees/Cubano.png" alt="">
                        <span class="coffee-category">ALCOÓLICO</span>
                        <h2>Cubano</h2>
                        <p class="coffee-description">Drink gelado de café expresso com rum, creme de leite e hortelã
                        </p>
                        <span class="add-to-cart-container">
                            <span class="price-container">
                                <span>R$</span>
                                <span>9,90</span>
                            </span>
                            <button><img src="images/icons/cart.svg" /></button>
                        </span>
                    </li>
                    <li> <img src="images/coffees/ExpressoCremoso.png" alt="">
                        <span class="coffee-category">TRADICIONAL</span>
                        <h2>Expresso Cremoso</h2>
                        <p class="coffee-description">Café expresso tradicional com espuma cremosa</p>
                        <span class="add-to-cart-container">
                            <span class="price-container">
                                <span>R$</span>
                                <span>9,90</span>
                            </span>
                            <button><img src="images/icons/cart.svg" /></button>
                        </span>
                    </li> -->
                </ul>
            </div>
        </main>
    </div>
</body>

</html>