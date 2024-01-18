<?php
$dontShowConnectionMsg = true;
include('dbconnection.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Startsida</title>
    <link rel="stylesheet" href="style.css">
    <style>
        a {
            display: flex;
            justify-content: center;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <?php
    include('header.php');
    include('topTen.php');
    ?>
    <br>
    
    <a href="login.php"><button>Logga in </button></a>
</body>

</html>