<?php
$onlyAdmin = true;
include('dbconnection.php');
include('check_login.php');

// drop table
try {
    if (isset($_POST['droptable']) && $_POST['droptable'] == 'true') {
        $sql = "DROP TABLE " . $_POST['table'];
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        // create table
        include('quiz_table.php');
    }else{
        header("Location: index.php");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
