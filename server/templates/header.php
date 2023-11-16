<header>
    <div class="content">
        <a href="/" class="logo">Simas Café</a>
        <nav>
            <?php
            if (isset($_SESSION['USER'])) {
            ?>
                <a class='cart-link'><img src='images/icons/cart.svg' /></a>
                <div class="user-menu-container">
                    <button class="user-menu">
                        <img src='images/icons/user.svg' />
                        <span><?php echo $_SESSION['USER']['USERNAME']; ?></span>
                    </button>
                    <ul class="user-menu-list">
                        <a href="admin.php">Painel Admin</a>
                        <a href='logout.php'>Alterar senha</a>
                        <a href='logout.php'>Sair</a>
                    </ul>
                </div>
            <?php
            } else {
            ?>
                <a href='login.php'>Faça Login</a>
            <?php
            }
            ?>
        </nav>
    </div>
    <script src="js/header.js"></script>
</header>