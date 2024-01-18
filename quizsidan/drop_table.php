<?php
$onlyAdmin = true;
include('dbconnection.php');
include('check_login.php');

// drop table
try {
    $sql = "DROP TABLE " . $_POST['table'];
    $stmt = $dbconn->prepare($sql);
    $stmt->execute();

    // create table
    include('quiz_table.php');
} catch (PDOException $e) {
    echo $e->getMessage();
}

