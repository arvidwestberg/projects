<?php
$dontShowConnectionMsg = true;
include('dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logga in</title>
    <link rel="stylesheet" href="style.css?">
</head>

<body>
    <?php
    include('header.php');
    echo "<a href='../index.php'><-- Tillbaka</a>";

    echo "<table class='align-top'><tr><td class='halfScreen'>";
    try {

        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $dbconn->prepare($sql);
            $stmt->execute([$username]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($res !== false && password_verify($password, $res['password'])) {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['admin'] = $res['admin'];
                $_SESSION['password'] = $password;
                $_SESSION['id'] = $res['id'];
                $_SESSION['name'] = $res['name'];
                $_SESSION['latest_login'] = $res['latest_login'];
                $sql = "UPDATE users SET latest_login = now() WHERE username = ?";
                $stmt = $dbconn->prepare($sql);
                $data = array($username);
                $stmt->execute($data);
                header("Location: index.php");
            } else {
                echo "<script>alert('Fel användarnamn eller lösenord!')</script>";
            }
        }
    } catch (PDOException $e) {
        echo $sql . "<br />" . $e->getMessage();
    }
    ?>
    <div class="userInput inputLarge w50">
        <form method="post" action="">
            <input type="text" name="username" placeholder="Användarnamn" required><br>
            <input type="password" name="password" placeholder="Lösenord" required><br>
            <button class="btn blue-btn" type="submit">Logga in </button>
        </form>
        <div class="mb-20">
<!--             <a style="font-size: 14px; text-decoration: none; font-weight:lighter;" href="forgotten_password.php">Glömt lösenord?</a>
 -->        </div>
        <hr class="mb-20">
        <button class="btn green-btn w-fit" onclick="window.location.href='register.php'">Registrera nytt konto</button>
    </div>
    <?php
    echo "</td><td class='halfScreen'>";
    include('topTen.php');
    echo "</td></tr></table>";

    ?>
</body>

</html>