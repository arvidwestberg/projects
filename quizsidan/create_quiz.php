<?php
$dontShowConnectionMsg = true;
include("dbconnection.php");
include('check_login.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gör din quiz</title>
    <link rel="stylesheet" href="style.css?">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="index.js"></script>

</head>

<body>
    <?php
    include('header.php');

    $answers = 3; // Number of answers per question 

    if (isset($_POST['qNumber']) && !empty($_POST['qNumber'])) {
        $questions = $_POST['qNumber'];
    } else {
        $questions = 5;
    }

    if (isset($_POST['q1']) && !empty($_POST['q1'])) {
        try {
            $sql = "INSERT INTO quiz (name, creator) 
        VALUES (?, ?)";
            $stmt = $dbconn->prepare($sql);
            $stmt->execute([$_POST['quiz_name'], $_SESSION['username']]);

            $sql = "SELECT id FROM quiz WHERE name = ?";
            $stmt = $dbconn->prepare($sql);
            $stmt->execute([$_POST['quiz_name']]);
            $quiz_nr = $stmt->fetchColumn();

            for ($i = 1; $i <= $questions; $i++) {
                $sql = "INSERT INTO questions (quiz_nr, question, question_nr, answer1, answer2, answer3, correct) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $dbconn->prepare($sql);
                $stmt->execute([$quiz_nr, $_POST['q' . $i], $i, $_POST['q' . $i . 'a1'], $_POST['q' . $i . 'a2'], $_POST['q' . $i . 'a3'], $_POST['q' . $i . 'correct']]);
            }

            echo "<script>alert('Quiz created!')</script>";
            header("refresh:0 url=create_quiz.php");
        } catch (PDOException $e) {
            echo "<br>";
            echo "Error: " . $e->getMessage();
            echo "<br>";
        }
    }

    ?>
    <h1 class="text-center">Create your quiz</h1>
    <br>
    <form id="quizForm" method="POST" action="">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 col-lg-4 col-sm-7">
                    <div class="mb-3">
                        <div class="input-group row m-auto">
                            <div class="col">
                                <button class="btn btn-outline-secondary" type="button" onclick="decrementQAmount()">&minus;</button>
                            </div>
                            <div class="col floating-form">
                                <input class="form-control text-center" placeholder="Antal frågor" type="text" onclick="generateQuizCards()" readonly name="qNumber" value="2" id="q_amount" min="1" max="10">
                                <p class="text-center" for="q_amount">Antal frågor</p>
                            </div>
                            <div class="col">
                                <button class="btn btn-outline-secondary" type="button" onclick="incrementQAmount()">&plus;</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-2">
                <div class="col-sm-8 col-lg-6">
                    <div class="mb-3">
                        <input class="form-control" placeholder="Quiznamn" type="text" id="quiz_name" name="quiz_name" required>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4 col-sm-5">
                    <button class="btn btn-success" type="submit">Skapa</button>
                </div>
            </div>
            <br>
            <div class="" id="quizCardsContainer"></div>
        </div>
    </form>

    <script src="create_quiz.js?"></script>
    <script>
        generateQuizCards();
    </script>
</body>

</html>