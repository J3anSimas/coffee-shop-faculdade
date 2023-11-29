<?php
session_start();
if (!isset($_SESSION["USER"]["LVL"]) || $_SESSION["USER"]["LVL"] != "A") {
    header("Location: index.php");
}


$head_title = "Admin - Usuários";
$head_styles = array("admin.css", "admin_users.css");
include "templates/head.php";
?>

<div class="container">
    <?php
    include "templates/header.php";
    ?>

    <main>
        <?php include "templates/admin_aside.php"; ?>
        <div class="main">
            <span style="display: flex; justify-content: space-between; align-items: center;">
                <h2>Usuários</h2>
                <a href="/admin_create_user.php" class="new-user">Novo usuário</a>
            </span>
            <ul>
                <?php
                require_once "includes/dbh.inc.php";
                $query = "SELECT ID, EMAIL, CREATED_AT DATE, NAME, LVL FROM USERS ORDER BY ID DESC";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                ?>
                    <li>
                        <a href="<?php echo "admin_order.php?order_id=" . $row["ID"] ?>">
                            <div class="address-info">
                                <span><?php echo $row['EMAIL'] . " - " . $row['NAME'] ?></span>
                                <span><?php echo date_format(date_create($row['DATE']), 'd/m/Y') ?></span>
                            </div>
                            <div class="price-container">
                                <span>
                                    <?php
                                    if ($row["LVL"] == "A") {
                                        echo "Admin";
                                    } else if ($row["LVL"] == "C") {
                                        echo "Cliente";
                                    } else {
                                        echo "Erro";
                                    }
                                    ?>
                                </span>
                            </div>
                        </a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </main>