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