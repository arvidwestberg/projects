<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
} elseif (isset($onlyAdmin) && $_SESSION['admin'] != 1) {
    header("Location: index.php");
} else {
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->execute([$_SESSION['username']]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!password_verify($_SESSION['password'], $res['password'])) {
        header("Location: login.php");
    }
}
