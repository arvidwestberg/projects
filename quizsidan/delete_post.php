<?php
include('dbconnection.php');

if (isset($_POST['table']) && isset($_POST['row']) && isset($_POST['website']) && isset($_POST['deletePost'])) {
    $table = $_POST['table'];
    $row = $_POST['row'];
    $website = $_POST['website'];

    try {
        $sql = "DELETE FROM $table WHERE id = $row";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        header("Location: $website");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    header("Location: index.php");
}
