<?php

$dontShowConnectionMsg = true;
include("dbconnection.php");
// display the users with the most total score
$sql = "SELECT users.username, SUM(history.score) AS total_score FROM users
    INNER JOIN history ON users.id = history.user_id
    GROUP BY users.username
    ORDER BY total_score DESC
    LIMIT 5";
$stmt = $dbconn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$numberOne = 0;
?>

<div class="container" id="totalScore">
    <div class="row align-items-center rounded-top-3 bg-primary text-light text-center">
        <div onclick="minus()" class="col m-auto py-3 rounded-top-3 rounded-end-0 h6 topTenBtn">
            <i class="bi bi-caret-left-fill"></i>
        </div>
        <div class="col-7 m-auto">
            Top 5 (totala poäng)
        </div>
        <div onclick="plus()" class="col m-auto py-3 rounded-top-3 rounded-start-0 h6 topTenBtn">
            <i class="bi bi-caret-right-fill"></i>
        </div>
    </div>
    <!-- new row -->
    <div class="row topTenWhite border border-top-0 text-center">
        <div class="col py-2">
            <strong>Användare</strong>
        </div>
        <div class="col py-2">
            <strong>Poäng</strong>
        </div>
    </div>

    <?php

    $counter = 0;
    $rows = count($users);
    foreach ($users as $user) {
        echo "<div id='row" . $counter . "' class='row text-center align-items-center border border-top-0'>";
        if ($counter % 2 == 0) {
            // add bg color to the row
            echo "<script>document.getElementById('row" . $counter . "').classList.add('bg-secondary-subtle');</script>";
        }
        if ($counter == $rows - 1) {
            // add border radius to the last row
            echo "<script>document.getElementById('row" . $counter . "').classList.add('rounded-bottom-3');</script>";
        }
        echo "<div class='col py-2'>";
        echo $user['username'];
        if (isset($_SESSION['username']) && $user['username'] == $_SESSION['username']) {
            echo " (du)";
        }
        if ($numberOne == 0) {
            echo "&#128081;";
            $numberOne++;
        }
        echo "</div>";
        echo "<div class='col py-2' id='userScore'>" . $user['total_score'] . "</div>";
        echo "</div>";
        $counter++;
    }

    ?>
</div>


<!-- avrage score -->
<?php
$sql = "SELECT users.username, SUM(history.score) / SUM(history.q_amount) AS avrage_score FROM users
    INNER JOIN history ON users.id = history.user_id
    GROUP BY users.username
    ORDER BY avrage_score DESC
    LIMIT 5";
$stmt = $dbconn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$numberOne = 0;

?>

<div class="container" style="display: none;" id="avrageScore">
    <div class="row rounded-top-3 bg-primary text-light text-center">
        <div onclick="minus()" class="col m-auto py-3 rounded-top-3 rounded-end-0 h6 topTenBtn">
            <i class="bi bi-caret-left-fill"></i>
        </div>
        <div class="col-7 m-auto">
            Top 5 (Genomsmittspoäng)
        </div>
        <div onclick="plus()" class="col m-auto py-3 rounded-top-3 rounded-start-0 h6 topTenBtn">
            <i class="bi bi-caret-right-fill"></i>
        </div>
    </div>
    <!-- new row -->
    <div class="row border border-top-0 text-center">
        <div class="col py-2">
            <strong>Användare</strong>
        </div>
        <div class="col py-2">
            <strong>Genomsmitt</strong>
        </div>
    </div>

    <?php
    $counter = 0;
    $rows = count($users);
    foreach ($users as $user) {
        // every other row should have a different background color
        if ($counter % 2 == 0) {
            echo "<div id='rowGenomsnitt" . $counter . "' class='row bg-secondary-subtle align-items-center text-center border border-top-0'>";
        } else {
            echo "<div id='rowGenomsnitt" . $counter . "' class='row text-center border border-top-0'>";
        }
        if ($counter == $rows - 1) {
            // add border radius to the last row
            echo "<script>document.getElementById('rowGenomsnitt" . $counter . "').classList.add('rounded-bottom-3');</script>";
        }
        echo "<div class='col py-2'>";
        echo $user['username'];
        if (isset($_SESSION['username']) && $user['username'] == $_SESSION['username']) {
            echo " (du)";
        }
        if ($numberOne == 0) {
            echo "&#128081;";
            $numberOne++;
        }
        echo "</div>";
        echo "<div class='col py-2' id='userScore'>" . 100 * round($user['avrage_score'], 2) . "%</div>";
        echo "</div>";
        $counter++;
    }
    ?>
</div>


<!-- top ten fastest per question -->
<?php
$sql = "SELECT users.username, SUM(history.time) / SUM(history.q_amount) AS avrage_time FROM users
    INNER JOIN history ON users.id = history.user_id
    GROUP BY users.username
    ORDER BY avrage_time ASC
    LIMIT 5";
$stmt = $dbconn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$numberOne = 0;
?>

<div class="container" style="display: none;" id="fastestTime">
    <div class="row rounded-top-3 bg-primary text-light text-center">
        <div onclick="minus()" class="col m-auto py-3 rounded-top-3 rounded-end-0 h6 topTenBtn">
            <i class="bi bi-caret-left-fill"></i>
        </div>
        <div class="col-7 m-auto">
            Top 5 (Snabbast per fråga)
        </div>
        <div onclick="plus()" class="col m-auto py-3 rounded-top-3 rounded-start-0 h6 topTenBtn">
            <i class="bi bi-caret-right-fill"></i>
        </div>
    </div>
    <!-- new row -->
    <div class="row topTenWhite border border-top-0 text-center">
        <div class="col py-2">
            <strong>Användare</strong>
        </div>
        <div class="col py-2">
            <strong>Tid per fråga</strong>
        </div>
    </div>

    <?php

    $counter = 0;
    $rows = count($users);
    foreach ($users as $user) {
        if ($counter % 2 == 0) {
            echo "<div id='rowsFastest" . $counter . "' class='row bg-secondary-subtle align-items-center text-center border border-top-0'>";
        } else {
            echo "<div id='rowsFastest" . $counter . "' class='row text-center border border-top-0'>";
        }
        if ($counter == $rows - 1) {
            // add border radius to the last row
            echo "<script>document.getElementById('rowsFastest" . $counter . "').classList.add('rounded-bottom-3');</script>";
        }
        echo "<div class='col py-2'>";
        echo $user['username'];
        if (isset($_SESSION['username']) && $user['username'] == $_SESSION['username']) {
            echo " (du)";
        }
        if ($numberOne == 0) {
            echo "&#128081;";
            $numberOne++;
        }
        echo "</div>";
        echo "<div class='col py-2' id='userScore'>" . round($user['avrage_time'], 2) . " s</div>";
        echo "</div>";
        $counter++;
    }

    ?>
</div>

<script src="toptenJS.js"></script>