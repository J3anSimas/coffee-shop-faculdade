<?php
session_start();
if ($_SESSION["level"] != null) {
    if ($_SESSION["level"] == "admin") {
        header("Location: admin.php");
    } else {
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700&family=Inter:wght@300;400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <header>
            <div class="content">
                <a href="/" class="logo">Simas Café</a>
                <nav>
                    <?php
                    if ($_SESSION["user"] == null) {
                        echo "<a href='login.php'>Faça Login</a>";
                    } else {
                        echo "<a class='cart-link'><img src='images/icons/cart.svg' /></a><a href='logout.php'>Sair</a>";
                    }
                    ?>
                </nav>
            </div>
        </header>
        <main>
            <form class="login-form" method="post" action="auth.php">
                <h2>Login</h2>
                <input type="text" placeholder="Nome de usuário" name="username">
                <input type="password" placeholder="Senha" name="password">
                <button type="submit">Entrar</button>
                <?php
                    if ($_GET["error"] == "wrongcredentials") {
                        echo "<span class='login-error'>Credenciais inválidas</p>";
                    }
                    ?>
            </form>
        </main>
</body>

</html>