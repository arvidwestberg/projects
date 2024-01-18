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
    <title>Result</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    include('header.php');

    // check answers
    $q_nr = $_COOKIE['quiz'];
    $sql = "SELECT * FROM questions WHERE quiz_nr = $q_nr";
    $stmt = $dbconn->prepare($sql);
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $Qamount = count($questions);
    $correct = 0;
    for ($i = 1; $i <= $Qamount; $i++) {
        if ($_COOKIE['answer' . $i] == $questions[$i - 1]['correct']) {
            $correct++;
        }
    }

    // Display all questions and answers in a table
    echo "<table class='styled-table' id='resultTable'>";
    echo "<tr><thead><td>Question</td><td>Answer</td></thead></tr>";
    foreach ($questions as $index => $question) {
        // itterate through all answers and highlight the correct one green and if the user answered wrong highlight it red
        echo "<tr>";
        echo "<td>" . $question['question'] . "</td>";
        echo "<td>";
        echo "<ul>";
        for ($i = 1; $i <= 3; $i++) {
            if ($question['correct'] == $i) {
                echo "<li><span class='correct'>" . $question['answer' . $i] . "</span></li>";
            } elseif ($_COOKIE['answer' . ($index + 1)] == $i) {
                echo "<li><span class='wrong'>" . $question['answer' . $i] . "</span></li>";
            } else {
                echo "<li>" . $question['answer' . $i] . "</li>";
            }
        }
        echo "</ul>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table> <br>";
    echo "<div style='width:fit-content; margin: auto;'>Du fick $correct / $Qamount rätt</div>";

    // Insert into history
    // make sure that it is inserted only once

    if (isset($_COOKIE['quizFinished']) && $_COOKIE['quizFinished']) {

        $sql = "SELECT name FROM quiz WHERE id = $q_nr";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $quiz_name = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "INSERT INTO history (user_id, quiz_name, quiz_id, score, q_amount, time)
    VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute([$_SESSION['id'], $quiz_name['name'], $q_nr, $correct, $Qamount, $_COOKIE['quizTime']]);
    }
    setcookie("quizFinished", false, time() + 3600);
    ?>

</body>

</html>