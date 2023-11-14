<?php
session_start();
if ($_SESSION["level"] != "A") {
    header("Location: login.php");
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
    <title>Admin</title>
</head>

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