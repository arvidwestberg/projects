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

<table id="totalScore" class='styled-table'>
    <thead>
        <tr>
            <td class="topTenHead" colspan='2'>
                <table class="w100">
                    <tr>
                        <td class="ta-left topTenShiftBtn" onclick="minus()">
                            < </td>
                        <td class="ta-center">
                            Top 10 (total score)
                        </td>
                        <td class="ta-right topTenShiftBtn" onclick="plus()">
                            >
                        </td>
                    </tr>
                </table>


            </td>
        </tr>
    </thead>
    <tr>
        <th>Username</th>
        <th>Total score</th>
    </tr>


    <?php
    foreach ($users as $user) {
        echo "<tr class=''>";
        echo "<td class=''>";
        echo $user['username'];
        if (isset($_SESSION['username']) && $user['username'] == $_SESSION['username']) {
            echo " (you)";
        }
        if ($numberOne == 0) {
            echo "&#128081;";
            $numberOne++;
        }
        echo "</td>";
        echo "<td class='' id='userScore'>" . $user['total_score'] . "</td>";
        echo "</tr>";
    }

    ?>

</table>
<?php
// make a table with the users with the best avrage score
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

<!-- top ten with best avrage score -->
<table style="display: none;" id="avrageScore" class='styled-table'>
    <thead>
        <tr>
            <td class="topTenHead" colspan='2'>
                <table class="w100">
                    <tr>
                        <td onclick="minus()" class="ta-left topTenShiftBtn">
                            < </td>
                        <td class="ta-center">
                            Top 10 (best avrage score)

                        </td>
                        <td onclick="plus()" class="ta-right topTenShiftBtn">
                            >

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tr>
        <th>Username</th>
        <th>Avrage score</th>
    </tr>

    <?php
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>";
        echo $user['username'];
        if (isset($_SESSION['username']) && $user['username'] == $_SESSION['username']) {
            echo " (you)";
        }
        if ($numberOne == 0) {
            echo "&#128081;";
            $numberOne++;
        }
        echo "</td>";
        echo "<td id='userScore'>" . 100 * round($user['avrage_score'], 2) . "%</td>";
        echo "</tr>";
    }
    ?>

</table>

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

<table style="display: none;" id="fastestTime" class='styled-table'>
    <thead>
        <tr>
            <td class="topTenHead" colspan='2'>
                <table class="w100">
                    <tr>
                        <td class="ta-left topTenShiftBtn" onclick="minus()">
                            < </td>
                        <td class="ta-center">
                            Top 10 (fastest per question)
                        </td>
                        <td class="ta-right topTenShiftBtn" onclick="plus()">
                            >
                        </td>
            </td>
        </tr>
</table>
</tr>
</thead>
<tr>
    <th>Username</th>
    <th>Avrage time</th>
</tr>

<?php
foreach ($users as $user) {
    echo "<tr>";
    echo "<td>";
    echo $user['username'];
    if (isset($_SESSION['username']) && $user['username'] == $_SESSION['username']) {
        echo " (you)";
    }
    if ($numberOne == 0) {
        echo "&#128081;";
        $numberOne++;
    }
    echo "</td>";
    echo "<td id='userScore'>" . round($user['avrage_time'], 2) . " seconds</td>";
    echo "</tr>";
}
?>

</table>

<script src="toptenJS.js?"></script>
