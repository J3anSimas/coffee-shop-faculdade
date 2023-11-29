<header>
    <div class="content">
        <a href="/" class="logo">Simas Café</a>
        <nav>
            <?php
            if (isset($_SESSION['USER'])) {
            ?>
                <a class='cart-link' href="cart.php">
                    <?php
                    require_once 'includes/dbh.inc.php';
                    $query = "SELECT ID FROM CARTS WHERE USER_ID = ? AND STATUS = 'O';";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$_SESSION['USER']['ID']]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $cart_indicator_show_class = "";
                    if (empty($row)) {
                    ?>
                        <div id="cart-indicator"></div>
                    <?php
                    } else {
                    ?>
                        <div id="cart-indicator" class="show"></div>
                    <?php
                    }
                    ?>
                    <img style="width: 28px; height: auto;" src='images/icons/cart.svg' />
                </a>
                <div class="user-menu-container">
                    <button class="user-menu">
                        <img src='images/icons/user.svg' />
                        <span><?php echo explode('@', $_SESSION['USER']['EMAIL'])[0]; ?></span>
                    </button>
                    <ul class="user-menu-list">
                        <?php
                        if ($_SESSION['USER']['LVL'] == 'A') {
                        ?>
                            <a href="admin.php">Painel Admin</a>
                        <?php
                        }
                        ?>
                        <a href='change_password.php'>Alterar senha</a>
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