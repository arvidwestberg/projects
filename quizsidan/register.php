<!-- insertpost.php -->
<?php
session_start();
$dontShowConnectionMsg = true;
include('dbconnection.php');
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Registrera konto</title>
    <link rel="stylesheet" href="style.css?">
</head>

<body>
    <?php
    include('header.php');
    if (
        isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password']) &&
        !empty($_POST['name']) && !empty($_POST['username']) && !empty($_POST['password'])
    ) {

        $name = htmlspecialchars($_POST['name']);
        $username = htmlspecialchars($_POST['username']);
        $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
        $taken_username = false;
        echo "name1: $name <br>";
        echo "username1: $username <br><br>";

        $_SESSION['name'] = $name;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['code'] = null;
        $_SESSION['code_time'] = null;
        $code = &$_SESSION['code'];

        # select all usernames
        $sql = "SELECT username FROM users";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $usernames = $stmt->fetchAll(PDO::FETCH_COLUMN);

        # loop through the usernames
        foreach ($usernames as $u_name) {
            if ($u_name == $username) {
                $taken_username = true;
            }
        }
        if (!$taken_username) {

            try {
                $sql = "INSERT INTO users (name, username, password, admin, latest_login) 
      VALUES (?, ?, ?, ?, now())";
                $stmt = $dbconn->prepare($sql);
                echo "name2: $name <br>";
                echo "username2: $username <br>";
                $data = array($name, $username, $password, 0);
                $stmt->execute($data);

                $_SESSION['admin'] = 0;
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                $_SESSION['name'] = $name;

                if ($username == "Tobias@admin") {
                    $sql = "UPDATE users SET admin = 1 WHERE username = ?";
                    $stmt = $dbconn->prepare($sql);
                    $data = array($username);
                    $stmt->execute($data);
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
            echo "<script>alert('Användarnamnet är upptaget!');</script>";
        }
        $dbconn = null;
    }
    echo "<br><br>";
    echo "<div class='userInput inputLarge w20 min-w-200'>";
    echo "<h2>Registrera dig</h2>";
    ?>

    <form method="post" action="">
        <input type="text" name="name" placeholder="Förnamn" size=20 maxlength=100 required>
        <input type="text" name="username" placeholder="Användarnamn" size=20 maxlength=20 required>
        <input type="password" name="password" placeholder="Lösenord" size=20 maxlength=100 required>
        <button class="btn blue-btn" type="submit">Skapa konto</button>
    </form>
    <?php
    echo "</div>";
    ?>
</body>

</html>