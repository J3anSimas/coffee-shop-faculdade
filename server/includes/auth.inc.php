<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../login.php");
    die();
} else {
    require_once "dbh.inc.php";
    $username = $_POST["username"];
    $password = $_POST["password"];
    if (empty($username) || empty($password)) {
        header("Location: ../login.php?error=emptyfields");
        die();
    } else {
        session_start();
        $query = "select ID, USERNAME, PASSWORD, LVL from USERS where UPPER(USERNAME) = (?);";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($row)) {
            header("Location: ../login.php?error=wrongcredentials");
            die();
        } else {
            $passwords_match = password_verify($password, $row["PASSWORD"]);
            if ($passwords_match == true) {
                $_SESSION["USER"] = $row;
                $_SESSION["USER"]["PASSWORD"] = "";
                header("Location: ../index.php");
                die();
            } else {
                header("Location: ../login.php?error=wrongcredentials");
                die();
            }
        }
    }
}
