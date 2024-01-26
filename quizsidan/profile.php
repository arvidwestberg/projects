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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="index.js"></script>

</head>

<body class="pt-5 mt-5">
    <?php
    include('header.php');
    ?>
    <br>
    <div class="container">
        <div class="row">
            <div class="col border">
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

                echo "<div class='container'>";
                echo "<div class='row border-bottom'>
                                <div class='col bg-primary py-2 text-light rounded-top-3'>Användar info</div>
                            </div>";
                echo "<div class='row border border-top-0'>
                                <div class='col-6 m-auto py-2 bg-body-tertiary'>Användarnamn</div>
                                <div class='col m-auto'>" . $user['username'] . "</div>
                            </div>";
                echo "<div class='row border border-top-0'>
                                <div class='col-6 m-auto py-2 bg-body-tertiary'>Name</div>
                                <div class='col m-auto'>" . $user['name'] . "</div>
                            </div>";
                echo "<div class='row border border-top-0'>
                                <div class='col-6 m-auto py-2 bg-body-tertiary'>Senaste inlogg</div>
                                <div class='col m-auto'>" . $user['latest_login'] . "</div>
                            </div>";
                /* Remaining code... */
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
                    echo "<div class='row border border-top-0'><div class='col-6 m-auto py-2 bg-body-tertiary'>Tid/fråga</div><div class='col m-auto'>" . round($avrageTime, 2) . " seconds</div></div>";
                    echo "<div class='row border rounded-bottom-3 border-top-0'><div class='col-6 m-auto py-2 bg-body-tertiary'>Poäng/fråga</div><div class='col m-auto'>" . 100 * round($avragePoints, 2) . "%</div></div>";
                }

                echo "</div>";
                echo "</div><br>";
                /* websettings view and change if admin=true as a table */
                if ($_SESSION['admin'] == 1) {
                    $sql = "SELECT * FROM websettings";
                    $stmt = $dbconn->prepare($sql);
                    $stmt->execute();
                    $res = $stmt->fetch(PDO::FETCH_ASSOC);

                    /* vertical table */
                    echo "<div class='container'>";
                    echo "<div class='row'><div class='col bg-primary text-light py-2 rounded-top-3'> Websettings</div></div>";
                    foreach ($res as $key => $value) {
                        if ($key == "id") continue;
                        echo "<div class='row border border-top-0'><div class='col bg-body-tertiary'>$key</div><div class='col'><form method='POST' action=''>";
                        if ($value == 1) {
                            echo '<button id="' . $key . '_on" name="' . $key . '_on" value="' . $key . '_on" class="btn green-btn btn-small" type="submit">On</button>';
                        } else {
                            echo '<button id="' . $key . '_off" name="' . $key . '_off" value="' . $key . '_off" class="btn red-btn btn-small" type="submit">Off</button>';
                        }
                        echo '<input type="hidden" name="changeWebsettings" value="' . 1 . '">';
                        echo '</form></div></div>';
                    }
                    echo "</div><br>";
                }
                ?>
            </div>
            <div class="col border">
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
            </div>
            <!-- change password -->
            <div class="col border">
                <div class="m-auto">

                    <div class='bg-body-tertiary rounded-3 shadow-sm p-3'>
                        <form action='' method='post'>
                            <p class="h4">Change password</p>
                            <input class="form-control mb-2" type='password' name='oldPassword' placeholder="Old password" required>
                            <input class="form-control mb-2" type='password' name='newPassword' placeholder="New password" required>
                            <button class="btn btn-primary" type='submit'>Change password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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