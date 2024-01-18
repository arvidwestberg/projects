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
    <title>Profile</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include('header.php');
    ?>
    <br>
    <table class="align-top w100">
        <tr>
            <td class="">
                <?php
                // change websettings
                if (isset($_POST['changeWebsettings'])) {
                    try {
                        $sql = "SELECT * FROM websettings";
                        $stmt = $dbconn->prepare($sql);
                        $stmt->execute();
                        $res = $stmt->fetch(PDO::FETCH_ASSOC);
                        // loop through all websettings
                        foreach ($res as $key => $value) {
                            if ($key == "id") continue;
                            if (isset($_POST[$key . "_off"])) {
                                $sql = "UPDATE websettings SET $key = 1";
                                $stmt = $dbconn->prepare($sql);
                                $stmt->execute();
                            } elseif (isset($_POST[$key . "_on"])) {
                                $sql = "UPDATE websettings SET $key = 0";
                                $stmt = $dbconn->prepare($sql);
                                $stmt->execute();
                            }
                        }
                        header("refresh:0.01;url=profile.php");
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                }
                /* the users info */
                $userID = $_SESSION['id'];
                $sql = "SELECT * FROM users WHERE id = $userID";
                $stmt = $dbconn->prepare($sql);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                /* vertical table */
                echo "<table class='profileInfoTable styled-table'>";
                echo "<thead><tr><td colspan=2>User Info</td></tr></thead>";
                echo "<tr><th>Username</th><td>" . $user['username'] . "</td></tr>";
                echo "<tr><th>First name</th><td>" . $user['name'] . "</td></tr>";
                echo "<tr><th>Latest login</th><td>" . $user['latest_login'] . "</td></tr>";
                /* avrage time and points per question */
                $sql = "SELECT * FROM history WHERE user_id = $userID";
                $stmt = $dbconn->prepare($sql);
                $stmt->execute();
                $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $totalTime = 0;
                $totalQ = 0;
                $points = 0;
                foreach ($history as $row) {
                    $points += $row['score'];
                    $totalTime += $row['time'];
                    $totalQ += $row['q_amount'];
                }
                if ($totalQ != 0) {
                    $avrageTime = $totalTime / $totalQ;
                    $avragePoints = $points / $totalQ;
                    echo "<tr><th>Avrage time/question</th><td>" . round($avrageTime, 2) . " seconds</td></tr>";
                    echo "<tr><th>Points/questions</th><td>" . 100 * round($avragePoints, 2) . "%</td></tr>";
                }

                echo "</table><br>";
                /* websettings view and change if admin=true as a table */
                if ($_SESSION['admin'] == 1) {
                    $sql = "SELECT * FROM websettings";
                    $stmt = $dbconn->prepare($sql);
                    $stmt->execute();
                    $res = $stmt->fetch(PDO::FETCH_ASSOC);

                    /* vertical table */
                    echo "<table id='websettingsTable' class='styled-table profileInfoTable'>";
                    echo "<thead><tr><td colspan=2> Websettings</td></tr></thead>";
                    foreach ($res as $key => $value) {
                        if ($key == "id") continue;
                        echo "<tr><th>$key</th><td><form method='POST' action=''>";
                        if ($value == 1) {
                            echo '<button id="' . $key . '_on" name="' . $key . '_on" value="' . $key . '_on" class="btn green-btn btn-small" type="submit">On</button>';
                        } else {
                            echo '<button id="' . $key . '_off" name="' . $key . '_off" value="' . $key . '_off" class="btn red-btn btn-small" type="submit">Off</button>';
                        }
                        echo '<input type="hidden" name="changeWebsettings" value="' . 1 . '">';
                        echo '</form></td></tr>';
                    }
                    echo "</table><br>";
                }
                ?>
            </td>
            <td class="">
                <?php
                // dislay user history
                $sql = "SELECT * FROM history WHERE user_id = $userID ORDER BY date DESC";
                $stmt = $dbconn->prepare($sql);
                $stmt->execute();
                $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo "<table id='historyTable' class='styled-table'>";
                echo "<thead><tr><td colspan=3> Historik</td></tr></thead>";
                echo "<tr><th>Quiz</th><th>Score</th><th>Date</th></tr>";
                foreach ($history as $row) {
                    echo "<tr>";
                    echo "<td>";
                    echo $row['quiz_name'];
                    echo "<td>" . $row['score'] . "/" . $row['q_amount'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                ?>
            </td>
            <!-- change password -->
            <td class="">
                <div class="w70 m-auto">

                    <div class='userInput'>
                        <form action='' method='post'>
                            <h2>Change password</h2>
                            <input type='password' name='oldPassword' placeholder="Old password" required><br>
                            <input type='password' name='newPassword' placeholder="New password" required><br>
                            <button class="btn blue-btn" type='submit'>Change password</button>
                        </form>
                    </div>
                    <br>
                    <button class='btn red-btn btn-small' onclick="window.location.href='logout.php'">Log out</button>
                </div>
            </td>
        </tr>
    </table>
    <?php

    // change password
    // get user password
    $sql = "SELECT password FROM users WHERE id = $userID";
    $stmt = $dbconn->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    $userPassword = $res['password'];

    if (isset($_POST['oldPassword']) && isset($_POST['newPassword']) && !empty($_POST['oldPassword']) && !empty($_POST['newPassword'])) {
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        if (password_verify($oldPassword, $userPassword)) {
            $_SESSION['password'] = $newPassword;
            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $dbconn->prepare($sql);
            $data = array($newPassword, $userID);
            $stmt->execute($data);
            echo "<script>alert('Password changed!')</script>";
            header("refresh:0.01;url=profile.php");
        } else {
            echo "<script>alert('Wrong password!')</script>";
        }
    }

    ?>
</body>

</html>