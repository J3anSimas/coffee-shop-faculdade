<?php
session_start();
if (isset($_SESSION["level"])) {
    if ($_SESSION["level"] == "admin") {
        header("Location: admin.php");
    } else {
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
$head_title = "Faça seu login";
$head_styles = null;
include "templates/head.php";
?>

<body>
    <div class="container">
        <? include "templates/header.php" ?>
        <main class="login-container">
            <form class="login-form" method="post" action="includes/auth.inc.php">
                <h2>Login</h2>
                <input type="text" placeholder="Nome de usuário" name="username">
                <input type="password" placeholder="Senha" name="password">
                <button type="submit">Entrar</button>
                <?php
                if (isset($_GET["error"]) and $_GET["error"] == "wrongcredentials") {
                ?>
                    <span class='login-error'>Credenciais inválidas</p>
                    <?php
                }
                    ?>
            </form>
        </main>
</body>

</html>