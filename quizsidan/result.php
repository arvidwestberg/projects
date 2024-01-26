<?php
$dontShowConnectionMsg = true;
include('dbconnection.php');
include('check_login.php');
?>

<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="index.js"></script>
</head>

<body class="d-flex h-100 align-items-center py-5 my-4">

    <?php
    include('header.php');

    // check answers
    $q_nr = $_SESSION['quiz'];
    $sql = "SELECT * FROM questions WHERE quiz_nr = $q_nr";
    $stmt = $dbconn->prepare($sql);
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $Qamount = count($questions);
    $correct = 0;
    for ($i = 1; $i <= $Qamount; $i++) {
        if ($_SESSION['answer' . $i] == $questions[$i - 1]['correct']) {
            $correct++;
        }
    }
    ?>
    <div class='container m-auto p-4' id='resultTable'>
        <div class='row align-items-center rounded-top-3 bg-primary text-light text-center'>
            <div class='col m-auto py-2 rounded-top-3 rounded-end-0 h5'>
                Fråga </div>
            <div class='col m-auto py-2 rounded-top-3 rounded-end-0 h5'>
                Svar </div>
        </div>
        <?php
        $counter = 0;
        $rows = count($questions);
        foreach ($questions as $index => $question) {
            echo "<div id='row" . $counter . "' class='row text-center align-items-center border border-top-0'>";
            if ($counter % 2 == 0) {
                // add bg color to the row
                echo "<script>document.getElementById('row" . $counter . "').classList.add('bg-secondary-subtle');</script>";
            }
            if ($counter == $rows - 1) {
                // add border radius to the last row
                echo "<script>document.getElementById('row" . $counter . "').classList.add('rounded-bottom-3');</script>";
            }
            echo "<div class='col'>" . $question['question'] . "</div>";


            echo "<div class='col p-0'>";
            echo "<ul class='m-2'>";
            for ($i = 1; $i <= 3; $i++) {
                if ($question['correct'] == $i) {
                    echo "<li class='bg-success rounded-2 mb-1'>" . $question['answer' . $i] . "</li>";
                } elseif ($_SESSION['answer' . ($index + 1)] == $i) {
                    echo "<li class='bg-danger rounded-2  mb-1'>" . $question['answer' . $i] . "</li>";
                } else {
                    echo "<li class=' mb-1'>" . $question['answer' . $i] . "</li>";
                }
            }
            echo "</ul>";
            echo "</div>";
            echo "</div>";
            $counter++;
        }
        echo "<div class='text-center mt-3'>Du fick $correct / $Qamount rätt</div>";
        echo "</div>";
        echo "<script>console.log('" . $_SESSION['quizTime'] . "');</script>";
        // Insert into history
        if (isset($_SESSION['quizFinished']) && $_SESSION['quizFinished']) {

            $sql = "SELECT name FROM quiz WHERE id = $q_nr";
            $stmt = $dbconn->prepare($sql);
            $stmt->execute();
            $quiz_name = $stmt->fetch(PDO::FETCH_ASSOC);

            $sql = "INSERT INTO history (user_id, quiz_name, quiz_id, score, q_amount, time)
    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $dbconn->prepare($sql);
            $stmt->execute([$_SESSION['id'], $quiz_name['name'], $q_nr, $correct, $Qamount, $_SESSION['quizTime']]);
        }
        $_SESSION["quizFinished"] = false;
        ?>

</body>

</html>