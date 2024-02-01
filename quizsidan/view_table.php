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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="index.js"></script>
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
            echo "<input type='hidden' name='droptable' value='true'>";
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
            echo "<tr>";

            // echo the column name
            foreach ($content[0] as $key => $value) {
                echo "<th style='border: 1px solid black;'>$key</th>";
            }
            echo "<th style='border: 1px solid black;'>Delete post</th>";
            echo "</tr>";

            // echo the content
            foreach ($content as $row) {
                echo "<tr>";
                foreach ($row as $key => $value) {
                    echo "<td style='border: 1px solid black;'>$value</td>";
                }
                echo "<td style='border: 1px solid black;'>";
                echo "<form action='delete_post.php' method='POST'>";
                echo "<input type='hidden' name='row' value='$row[id]'>";
                echo "<input type='hidden' name='deletePost' value='true'>";
                echo "<input type='hidden' name='website' value='view_table.php'>";
                echo "<button class='btn btn-danger py-0 btn-small m-auto' type='submit' name='table' value='$table'>Delete</button>";
                echo "</td>";
                echo "</tr>";
                echo "</form>";
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