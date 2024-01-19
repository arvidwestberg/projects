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
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
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
    <h1 class="ta-center">Create your quiz</h1>
    <form id="quizForm" method="POST" action="">
        <div class="userInput w15">

            <table>
                <tr>
                    <td>
                        <label for="q_amount">Number of questions:</label>
                        <input type="number" onclick="generateQuizCards()" name="qNumber" value="2" id="q_amount" min="1" max="10">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input placeholder="Quizname" type="text" id="quiz_name" name="quiz_name" required>
                    </td>
                </tr>

            </table>
            <button class="btn green-btn" type="submit">Submit</button>
        </div>
        <br>
        <div id="quizCardsContainer"></div>
    </form>

    <script src="create_quiz.js"></script>
    <script>
        generateQuizCards();
    </script>
</body>

</html>