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
// $head_styles = null;
include "templates/head.php";
?>

<body>
    <div class="container">
        <?php
        include "templates/header.php";
        ?>
        <main>
            <h1>Admin Dashboard</h1>
        </main>
    </div>
</body>

</html>