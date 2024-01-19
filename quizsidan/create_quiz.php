<?php
$dontShowConnectionMsg = true;
include("dbconnection.php");
include('check_login.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Create Quiz</title>
</head>
<link rel="stylesheet" href="style.css">

<body>
    <?php
    include('header.php');
    ?>


    <?php

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

            header("Location: create_quiz.php");
        } catch (PDOException $e) {
            echo "<br>";
            echo "Error: " . $e->getMessage();
            echo "<br>";
        }
    }

    ?>

    <!-- html -->
    <table id="createQuizParentTable">
        <tr class="align-top">
            <td class="w-fit">
                <h1 style="text-align: center;">Create your Quiz</h1>
                <div id="createQuizInfo" class="userInput w50">

                    <form action="" method="post">

                        <!-- change number of questions -->
                        <table>
                            <tr>
                                <td colspan="2">
                                    <label for="questions">Number of questions (3-10)</label> <br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input class="m-unset" type="number" name="qNumber" min="3" max="10" value="5">
                                </td>
                                <td>
                                    <button class="btn blue-btn btn-small m-unset w100" type="submit" name="submit">Ändra</button>
                                </td>
                            </tr>
                    </form>
                    <form action="" method="post">

                        <!-- quiz name -->
        <tr>
            <td colspan="2">
                <input class="m-unset" type="text" name="quiz_name" id="quiz_name" max='30' placeholder="Quiz name" required>
                
            </td>
        </tr>
        <tr>
            <td colspan="2">

                <!-- submit -->
                <button class='btn green-btn w100 mb-0' type='submit' name='submit'>Skapa quiz</button>
            </td>

        </tr>
    </table>
    </div>

    </td>
    <td class="w50 min-w-400">

        <div id="questionContainer">
            <br>

            <?php

            /* questions and answers */
            for ($i = 1; $i <= $questions; $i++) {
                echo '<div class="userInput m-auto w50 questionCard">';
                echo '<input type="text" name="q' . $i . '" id="q' . $i . '"placeholder="Question ' . $i . '" maxlength=' . "50" . ' required><br>';
                for ($j = 1; $j <= $answers; $j++) {
                    echo '<input type="text" name="q' . $i . 'a' . $j . '" id="q' . $i . 'a' . $j . '"required placeholder="Answer ' . $j . '" maxlength=' . "30" . '><br>';
                }
                echo '<label for="q' . $i . 'correct">Correct answer</label> <br>';
                echo '<select name="q' . $i . 'correct" id="q' . $i . 'correct">';
                for ($k = 1; $k <= $answers; $k++) {
                    echo '<option value="' . $k . '">' . $k . '</option>';
                }
                echo '</select><br>';
                echo "</div><br><br>";
            }
            echo "<input type='hidden' name='qNumber' value='" . $questions . "'>";
            echo '<br></div>';
            ?>
            </form>
    </td>
    </tr>
    </table>
</body>

</html>