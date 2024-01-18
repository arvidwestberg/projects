<?php
$dontShowConnectionMsg = true;
$onlyAdmin = true;
include('dbconnection.php');
include('check_login.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View tables</title>
    <link rel="stylesheet" href="style.css?">
</head>

<body>

    <?php
    include('header.php');
    try {
        // Get all tables in the database
        $sql = "SHOW TABLES";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        // Fetch table names
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Display table names and content
        echo "<h2>Existing Tables:</h2>";

        echo "<form action='quiz_table.php' method='POST'>";
        echo "<input type='text' name='newTable' placeholder='create this table'>";
        echo "<input type='hidden' name='website' value='view_table.php'>";
        echo "<input type='submit' value='Create table'>";
        echo "</form>";
        foreach ($tables as $table) {
            echo "<h3>$table</h3>";
            // drop table
            echo "<form action='drop_table.php' method='POST'>";
            echo "<input type='hidden' name='table' value='$table'>";
            echo "<input type='hidden' name='website' value='view_table.php'>";
            echo "<input type='submit' value='Drop $table table'>";
            echo "<input type='checkbox' checked name='newTable' value='$table'>and create new";
            echo "</form>";
            // Retrieve table content
            $contentSql = "SELECT * FROM $table";
            $contentStmt = $dbconn->prepare($contentSql);
            $contentStmt->execute();
            $content = $contentStmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($content)) {
                echo "<p>Table is empty</p>";
                continue;
            }
            // Display table content
            echo "<table style='border-collapse: collapse;'>";
            // echo the column name
            echo "<tr>";
            foreach ($content[0] as $key => $value) {
                echo "<th style='border: 1px solid black;'>$key</th>";
            }
            echo "</tr>";
            // echo the content
            foreach ($content as $row) {
                echo "<tr>";
                foreach ($row as $key => $value) {
                    echo "<td style='border: 1px solid black;'>$value</td>";
                }
            }
            echo "</table>";
        }
    } catch (PDOException $e) {
        echo $sql . "<br />" . $e->getMessage();
    }
    $dbconn = null;
    ?>
</body>

</html>