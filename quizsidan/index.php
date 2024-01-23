<?php
$dontShowConnectionMsg = true;
include('dbconnection.php');
include('check_login.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hemsida</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include('header.php');
    ?>
    <br>
    <table class="align-top">
        <tr>
            <td class="halfScreen">
                <p class="lead">Välkommen tillbaka <?php $_SESSION['name'];?>!</p>
                <h1 style="margin-top: 0;">Alla Quizer</h1>
                <hr><br>
                <form action="quiz.php" method="get">
                    <div class="display-ib">
                        <div id="newQuiz" onclick="window.location.href='create_quiz.php'">
                            <span class="plus"> + </span>
                        </div>
                    </div>
                    <?php
                    $sql = "SELECT * FROM quiz";
                    // count rows
                    $result = $dbconn->query($sql);
                    $count = 0;
                    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
                    $rows_nr = count($rows);
                    $sql = "SELECT * FROM websettings";
                    $stmt = $dbconn->prepare($sql);
                    $stmt->execute();
                    $websettings = $stmt->fetch(PDO::FETCH_ASSOC);

                    for ($i = 0; $i < $rows_nr; $i++) {
                        echo "<button class='quizCard' type='submit' name='quiz' value='" . $rows[$i]['id'] . "'>";
                        echo "<h2>" . $rows[$i]['name'] . "</h2>";
                        if ($websettings['showCreatorName'] == 1) {
                            echo "<p style='font-size:13px;'>Skapad av: " . $rows[$i]['creator'] . "</p>";
                        }
                        echo "</button>";
                    }
                    ?>

                    <input type="hidden" name="whatQ" value="1">
                </form>
            </td>
            <td class="halfScreen">
                <div>
                    <?php
                    include('topTen.php');
                    ?>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>