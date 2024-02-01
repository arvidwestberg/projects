<?php
$dontShowConnectionMsg = true;
include('dbconnection.php');
include('check_login.php');
?>
<!DOCTYPE html>
<html class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
</head>
<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="index.js"></script>

<body class="d-flex h-100 align-items-center py-4">
    <?php
    include("header.php");
    echo "<main class='m-auto my-auto col-md-5 col-lg-4 col-sm-6 rounded-5 shadow-sm text-center border-0 p-5 bg-body-tertiary'>";
    if (isset($_GET['answer'])) {
        $answer = $_GET['answer'];
        $_SESSION["answer" . $_GET['prevQ']] = $answer;
    }
    if (isset($_GET['finish'])) {
        $_SESSION["quiz"] = $_GET['quiz'];
        $_SESSION["quizFinished"] = true;
        $_SESSION["quizTime"] = time() - $_SESSION['quizTime'];
        // header("Location: result.php");
        echo "<script>window.location.href = 'result.php';</script>";
    } elseif (!isset($_GET['whatQ'])) {
        echo "<script>window.location.href = 'index.php';></script>";
        // header("Location: index.php");
    }
    if (isset($_GET['whatQ'])) {
        $whatQ = $_GET["whatQ"];
        $q_nr = $_GET['quiz'];

        if ($whatQ == 1) {
            $_SESSION["quizTime"] = time();
        }

        // get quiz name
        $sql = "SELECT name FROM quiz WHERE id = $q_nr";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $name = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<h1>" . $name['name'] . "</h1>";

        // get questions and answers
        $sql = "SELECT * FROM questions WHERE quiz_nr = $q_nr";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $Qamount = count($questions);

        echo "<h3>Fråga " . $whatQ . " av " . $Qamount . "</h3> <hr>";
    }
    ?>

    <form action="" method="GET">

        <?php
        // display question
        echo "<div>";
        echo "<h2>" . $questions[$whatQ - 1]['question'] . "</h2>";
        // display answers 
        echo "<input type='radio' name='answer' value='1' required>" . $questions[$whatQ - 1]['answer1'] . "<br>";
        echo "<input type='radio' name='answer' value='2' required>" . $questions[$whatQ - 1]['answer2'] . "<br>";
        echo "<input type='radio' name='answer' value='3' required>" . $questions[$whatQ - 1]['answer3'] . "<br>";
        echo "</div> <br>";

        echo "<div>";
        if ($whatQ > 0 && $whatQ < $Qamount) {
            // prev btn
            // next btn
            echo "<button class='btn btn-lg btn-primary' type='submit' name='whatQ' value=" . ($whatQ + 1) . "> Nästa </button>";
        } elseif ($whatQ >= $Qamount) {
            // finish btn
            echo "<button class='btn btn-lg btn-success' type='submit' name='finish'> Klar </button>";
        }
        echo "<input type='hidden' name='quiz' value='" . $q_nr . "'>";
        echo "<input type='hidden' name='prevQ' value='" . $whatQ . "'>";
        echo "</div>";
        ?>
    </form>
    </main>
</body>

</html>