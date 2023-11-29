<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../admin_create_user.php");
    die();
} else {
    require_once "dbh.inc.php";
    $name = $_POST["name"];
    $email = $_POST["email"];
    $lvl = $_POST["lvl"];
    $password = $_POST["password"];
    if (empty($name) || empty($email) || empty($password) || empty($lvl)) {
        header("Location: ../admin_create_user.php?error=emptyfields");
        die();
    } else {
        session_start();
        $query = "select ID from USERS where UPPER(EMAIL) = (?);";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($row)) {
            header("Location: ../admin_create_user.php?error='Email já utilizado");
            die();
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $query = "insert into USERS (NAME, EMAIL, PASSWORD, LVL) values (?, ?, ?, ?);";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$name, $email, $hash, $lvl]);
            header("Location: ../admin_create_user.php?success=true");
        }
    }
}
