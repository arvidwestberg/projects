<?php
$dontShowConnectionMsg = true;
include('dbconnection.php');
include('check_login.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Quiz</title>
</head>
<link rel="stylesheet" href="style.css">

<body>
    <?php
    include('header.php');
    ?>
    <div class="card">

        <?php
        if (isset($_GET['answer'])) {
            $answer = $_GET['answer'];
            setcookie("answer" . $_GET['prevQ'], $answer, time() + 3600);
        }
        if (isset($_GET['finish'])) {
            setcookie("quiz", $_GET['quiz'], time() + 3600);
            setcookie("quizFinished", true, time() + 3600);
            setcookie("quizTime", time() - $_COOKIE['quizTime'], time() + 3600);
            header("Location: result.php");
        } elseif (!isset($_GET['whatQ'])) {
            header("Location: index.php");
        }
        if (isset($_GET['whatQ'])) {
            $whatQ = $_GET["whatQ"];
            $q_nr = $_GET['quiz'];

            if ($whatQ == 1) {
                setcookie("quizTime", time(), time() + 3600);
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

            echo "<h2>Fråga " . $whatQ . " av " . $Qamount . "</h2> <hr>";
        }
        ?>

        <form action="" method="GET">

            <?php
            // display question
            echo "<div class='question'>";
            echo "<h2 class='question'>" . $questions[$whatQ - 1]['question'] . "</h2>";
            // display answers
            echo "<input type='radio' name='answer' value='1' required>" . $questions[$whatQ - 1]['answer1'] . "<br>";
            echo "<input type='radio' name='answer' value='2' required>" . $questions[$whatQ - 1]['answer2'] . "<br>";
            echo "<input type='radio' name='answer' value='3' required>" . $questions[$whatQ - 1]['answer3'] . "<br>";
            echo "</div> <br>";

            echo "<div class='question'>";
            if ($whatQ > 1 && $whatQ < $Qamount) {
                // prev btn
                // next btn
                echo "<button class='btn blue-btn small' type='submit' name='whatQ' value=" . ($whatQ + 1) . "> Nästa </button>";
            } elseif ($whatQ <= 1) {
                // previous disabled
                // next btn
                echo "<button class='btn blue-btn small' type='submit' name='whatQ' value=" . ($whatQ + 1) . "> Nästa </button>";
            } elseif ($whatQ >= $Qamount) {
                // finish btn
                echo "<button class='btn green-btn small' type='submit' name='finish'> Klar </button>";
            }
            echo "<input type='hidden' name='quiz' value='" . $q_nr . "'>";
            echo "<input type='hidden' name='prevQ' value='" . $whatQ . "'>";
            echo "</div>";
            ?>
        </form>
    </div>
</body>

</html>