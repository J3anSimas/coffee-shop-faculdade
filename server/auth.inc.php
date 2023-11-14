<?php
$username = $_POST["username"];
$password = $_POST["password"];
if (empty($username) || empty($password)) {
    header("Location: login.php?error=emptyfields");
} else {
    session_start();
    if ($username == "admin" && $password == "admin") {
        $_SESSION["user"] = $username;
        $_SESSION["level"] = "admin";
        header("Location: admin.php");
    } elseif ($username == "user" && $password == "user") {
        $_SESSION["user"] = $username;
        $_SESSION["level"] = "user";
        header("Location: index.php");
    } else {
        header("Location: login.php?error=wrongcredentials");
    }
}
