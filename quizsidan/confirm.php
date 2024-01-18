<?php
session_start();
$dontShowConnectionMsg = true;
include('dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <link rel="stylesheet" href="style.css?">
</head>

<body>
    <?php
    include('header.php');

    if (!isset($_SESSION['code'])) {
        header("Location: register.php");
    }

    $name = $_SESSION['name'];
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
    $code = &$_SESSION['code'];

    if (isset($_POST['new_code'])) {
        $code = random_code();
        $to = $email;
        $subject = "Confirmation mail";
        $mail_message = "Code: $code";
        $headers = "From: arvidwg@varmdogymnasium.se";
        if (mail($to, $subject, $mail_message, $headers)) {
            $_SESSION['code_time'] = time();
            echo "Email sent successfully. Check your inbox for confirmation code. <br><br>";
        } else {
            echo "Email not sent. <br><br>";
        }
    } else {
        echo "Email sent successfully. Check your inbox for confirmation code. <br><br>";
    }
    if (isset($_POST['code'])) {
        if ($_POST['code'] == $code && time() - $_SESSION['code_time'] < 30) {
            try {
                $sql = "INSERT INTO users (name, username, password, email, admin, latest_login) 
          VALUES (?, ?, ?, ?, ?, now())";
                $stmt = $dbconn->prepare($sql);
                $data = array($name, $username, $password, $email, 0);
                $stmt->execute($data);

                $_SESSION['admin'] = 0;
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                $_SESSION['name'] = $name;

                if ($dbconn->lastInsertId() == 1) {
                    $sql = "UPDATE users SET admin = 1 WHERE id = 1";
                    $stmt = $dbconn->prepare($sql);
                    $stmt->execute();
                    $_SESSION['admin'] = 1;
                }
                echo "Account created successfully! <br>";
                $lastId = $dbconn->lastInsertId();
                echo "redirecting in 5 seconds...<br>";
                header("refresh:5;url=index.php");
            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
        } else {
            echo "Wrong code! <br>";
        }
    }
    ?>
    <?php
    function random_code($len = 4)
    {
        $code = "";
        for ($i = 0; $i < $len; $i++) {
            $code .= rand(0, 9);
        }
        return $code;
    }
    ?>
    <div class="userInput w20">

        <form action="" method="post">
            <input type="text" name="code" placeholder="Code">
            <button class="btn blue-btn" type="submit">Confirm</button>
        </form>
        <form action="" method="post">
            <button class="btn green-btn" type="submit" name="new_code">Send new code</button>
        </form>
    </div>
</body>

</html>