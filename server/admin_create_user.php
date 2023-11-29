<?php
session_start();
if (!isset($_SESSION["USER"]["LVL"]) || $_SESSION["USER"]["LVL"] != "A") {
    header("Location: index.php");
}
$head_title = "Admin - Novo Usuário";
$head_styles = array("admin.css", "admin_create_user.css");
include "templates/head.php";
?>

<div class="container">
    <?php
    include "templates/header.php";
    ?>

    <main>
        <?php include "templates/admin_aside.php"; ?>
        <div class="main">
            <form action="includes/create_user.inc.php" method="post" class="new-user-form">
                <h2>Novo usuário</h2>
                <input type="text" name="name" placeholder="Nome">
                <input type="text" name="email" placeholder="Email">
                <span class="radio-input-container lvl_user">
                    <input type="hidden" name="lvl" id="lvl_user">
                    <button type="button" data-lvl="A">Admin</button>
                    <button type="button" data-lvl="C">Cliente</button>
                </span>
                <input type="password" name="password" placeholder="Senha">
                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </main>
    <script>
        document.querySelectorAll('.lvl_user > button').forEach(currentButton => {
            currentButton.addEventListener('click', () => {
                document.querySelectorAll('.lvl_user > button').forEach(button => {
                    button.classList.remove('active');
                });
                currentButton.classList.add('active');
                document.querySelector('#lvl_user').value = currentButton.getAttribute('data-lvl');
            });
        });
    </script>