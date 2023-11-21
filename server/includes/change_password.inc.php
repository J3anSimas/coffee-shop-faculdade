<?php
session_start();
require_once "dbh.inc.php";
if (!isset($_SESSION["USER"])) {
    header("Location: ../login.php");
    die();
}
if (!isset($_POST['current_password']) || !isset($_POST['password']) || !isset($_POST['password_confirm'])) {
    header('Location: ../change_password.php?error=Campos obrigatórios não preenchidos!');
    die();
}
$current_password = $_POST['current_password'];
$password = $_POST['password'];
$confirm_password = $_POST['password_confirm'];
$query = "SELECT PASSWORD FROM USERS WHERE ID = ?;";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['USER']['ID']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$passwords_match = password_verify($password, $row["PASSWORD"]);
if ($passwords_match == true) {
    if ($password == $confirm_password) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $query = "UPDATE USERS SET PASSWORD = ? WHERE ID = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$password_hash, $_SESSION['USER']['ID']]);
        header('Location: ../change_password.php?success=Senha alterada com sucesso!');
        die();
    } else {
        header('Location: ../change_password.php?error=Senhas não conferem!');
        die();
    }
} else {
    header('Location: ../change_password.php?error=Senha atual incorreta!');
    die();
}
