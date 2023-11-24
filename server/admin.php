<?php
session_start();
if ($_SESSION["USER"]["LVL"] != "A") {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
$head_title = "Admin Dashboard";
$head_styles = array("admin.css");
include "templates/head.php";
?>

<body>
    <div class="container">
        <?php
        include "templates/header.php";
        ?>

        <main>
            <aside class="aside">
                <ul>
                    <li>
                        <a href="admin.php">
                            <img src="images/icons/dashboard.svg" alt="Dashboard">
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li><a href="admin/users.php">
                            <img src="images/icons/users.svg" alt="Usuários">
                            <span>Usuários</span>
                        </a></li>
                    </a></li>
                    <li><a href="admin/products.php">
                            <img src="images/icons/orders.svg" alt="">
                            <span>Pedidos</span>
                        </a></li>
                </ul>
            </aside>
            <div class="main">
                Todo
            </div>
        </main>
    </div>
</body>

</html>