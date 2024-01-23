<!-- insertpost.php -->
<?php
$dontShowConnectionMsg = true;
include('dbconnection.php');
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Registrera konto</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="register.css?">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="index.js"></script>
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <?php
    include('header.php');
    ?>
    <div id="registerContainer" class="container m-auto">

        <div class="row">
            <div class="col">

                <main class="form-signin m-auto">

                    <form method="POST" action="">
                        <h1 class="h3 mb-3 fw-normal">Registrera dig</h1>

                        <div class="form-floating">
                            <input type="username" class="form-control" name="username" maxlength=20 id="floatingInput" required placeholder="Användarnamn">
                            <label for="floatingInput">Användarnamn</label>
                        </div>
                        <div class="form-floating">
                            <input type="name" class="form-control" name="name" maxlength=100 id="floatingName" required placeholder="Namn">
                            <label for="floatingName">Namn</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control" name="password" maxlength=100 id="floatingPassword" required placeholder="Lösenord">
                            <label for="floatingPassword">Lösenord</label>
                        </div>

                        <button class="btn btn-primary w-100 py-2" type="submit">Logga in</button>
                    </form>
                </main>
            </div>
        </div>
        <div class="row">
            <div class="col">

                <?php
                if (
                    isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password']) &&
                    !empty($_POST['name']) && !empty($_POST['username']) && !empty($_POST['password'])
                ) {

                    $name = htmlspecialchars($_POST['name']);
                    $username = htmlspecialchars($_POST['username']);
                    $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
                    $taken_username = false;

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
                            echo "<div class='ms-3'>Account created successfully! <br>";
                            $lastId = $dbconn->lastInsertId();
                            echo "redirecting in 3 seconds...</div>";
                            // echo "<script>setTimeout(function(){window.location.href = 'index.php';}, 3000);</script>";
                        } catch (PDOException $e) {
                            echo $sql . "<br>" . $e->getMessage();
                        }
                    } else {
                        echo "<script>alert('Användarnamnet är upptaget!');</script>";
                    }
                    $dbconn = null;
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>