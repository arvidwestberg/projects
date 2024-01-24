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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="index.js"></script>
</head>

<body>
    <?php
    include("header.php");
    ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-7">
                <p class="lead">Välkommen tillbaka <?php echo $_SESSION['name']; ?>!</p>
                <div class="row">

                    <div class="col-8">
                        <h1>Alla Quizer</h1>
                    </div>
                    <div class="col m-auto">
                        <a href="create_quiz.php">
                            <button type="button" class="btn btn-primary m-0">
                                Gör en quiz
                            </button>
                        </a>
                    </div>
                </div>
                <hr>

                <div class="container">

                    <form action="quiz.php" method="get">
                        <div class="row">
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
                                echo "<div class='col p-2'>";
                                echo "<div class='card p-5 w-100 h-100 bg-body-tertiary' type='submit' name='quiz' value='" . $rows[$i]['id'] . "'>";
                                // echo "<img src='#' class='card-img-top' alt='#'>";
                                // echo "<div style='width: 100%; height: 100px; background-color: #000000;'></div>";
                                // echo "<hr>";
                                echo "<div class='m-auto'>";
                                echo "<h4 class='card-title mb-0'>" . $rows[$i]['name'] . "</h4>";
                                echo "</div>";
                                if ($websettings['showCreatorName'] == 1) {
                                    echo "<div class='small text-body-secondary'>Skapad av: " . $rows[$i]['creator'] . "</div>";
                                }
                                echo "</div>";
                                echo "</div>";
                            }
                            ?>
                            <input type="hidden" name="whatQ" value="1">
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div>
                <?php
                include('topTen.php');
                ?>
            </div>
        </div>
    </div>
</body>

</html>