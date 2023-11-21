<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<?php
$head_title = "Alterar senha";
$head_styles = array("change_password.css");
include 'templates/head.php';
?>

<body>
    <?php
    include 'templates/header.php';
    ?>
    <main>
        <form class="login-form" method="post" action="includes/change_password.inc.php">
            <h2>Alterar senha</h2>
            <input type="password" placeholder="Senha atual" required name="current_password">
            <input type="password" placeholder="Nova Senha" required name="password">
            <input type="password" placeholder="Confirmar nova senha" required name="password_confirm">
            <button type="submit">Alterar</button>
            <?php
            if (isset($_GET['error'])) {
            ?>
                <span class="error-message"><?php echo $_GET['error']; ?></span>
            <?php
            }
            ?>
        </form>
    </main>
</body>

</html>