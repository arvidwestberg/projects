<?php

$dontShowConnectionMsg = true;
include("dbconnection.php");
// display the users with the most total score
$sql = "SELECT users.username, SUM(history.score) AS total_score FROM users
    INNER JOIN history ON users.id = history.user_id
    GROUP BY users.username
    ORDER BY total_score DESC
    LIMIT 10";
$stmt = $dbconn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$numberOne = 0;
?>

<div class="container" id="totalScore">
    <div class="row rounded-top-3 bg-primary text-light text-center">
        <div onclick="minus()" class="col m-auto py-2 rounded-top-3 rounded-end-0 h3 topTenBtn">
            &#x1F890; </div>
        <div class="border-start border-end border-light m-auto col-7">
            <span class="h6"> Top 10 (total score)</span>
        </div>
        <div onclick="plus()" class="col m-auto py-2 rounded-top-3 rounded-start-0 rounded- h3 topTenBtn">
            &#x1F892;
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
    foreach ($users as $user) {
        if ($counter % 2 == 0) {
            echo "<div class='row bg-secondary-subtle text-center border border-top-0'>";
        } else {
            echo "<div class='row text-center border border-top-0'>";
        }
        echo "<div class='col py-2'>";
        echo $user['username'];
        if (isset($_SESSION['username']) && $user['username'] == $_SESSION['username']) {
            echo " (you)";
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
    LIMIT 10";
$stmt = $dbconn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$numberOne = 0;

?>

<div class="container" style="display: none;" id="avrageScore">
    <div class="row rounded-top-3 bg-primary text-light text-center">
        <div onclick="minus()" class="col m-auto py-2 rounded-top-3 rounded-end-0 h3 topTenBtn">
            &#x1F890; </div>
        <div class="border-start border-end border-light m-auto col-7">
            <span class="h6"> Top 10 (Genomsmittspoäng)</span>
        </div>
        <div onclick="plus()" class="col m-auto py-2 rounded-top-3 rounded-start-0 rounded- h3 topTenBtn">
            &#x1F892;
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
    foreach ($users as $user) {
        // every other row should have a different background color
        if ($counter % 2 == 0) {
            echo "<div class='row text-center border border-top-0'>";
        } else {
            echo "<div class='row text-center border border-top-0'>";
        }
        echo "<div class='col py-2'>";
        echo $user['username'];
        if (isset($_SESSION['username']) && $user['username'] == $_SESSION['username']) {
            echo " (you)";
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
    LIMIT 10";
$stmt = $dbconn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$numberOne = 0;
?>

<div class="container" style="display: none;" id="fastestTime">
    <div class="row rounded-top-3 bg-primary text-light text-center">
        <div onclick="minus()" class="col m-auto py-2 rounded-top-3 rounded-end-0 h3 topTenBtn">
            &#x1F890; </div>
        <div class="border-start border-end border-light m-auto col-7">
            <span class="h6"> Top 10 (Snabbast per fråga)</span>
        </div>
        <div onclick="plus()" class="col m-auto py-2 rounded-top-3 rounded-start-0 rounded- h3 topTenBtn">
            &#x1F892;
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
    foreach ($users as $user) {
        if ($counter % 2 == 0) {
            echo "<div class='row bg-secondary-subtle text-center border border-top-0'>";
        } else {
            echo "<div class='row text-center border border-top-0'>";
        }
        echo "<div class='col py-2'>";
        echo $user['username'];
        if (isset($_SESSION['username']) && $user['username'] == $_SESSION['username']) {
            echo " (you)";
        }
        if ($numberOne == 0) {
            echo "&#128081;";
            $numberOne++;
        }
        echo "</div>";
        echo "<div class='col py-2' id='userScore'>" . round($user['avrage_time'], 2) . " seconds</div>";
        echo "</div>";
        $counter++;
    }

    ?>
</div>

<script src="toptenJS.js?"></script>