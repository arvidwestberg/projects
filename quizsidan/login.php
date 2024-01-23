<?php
$dontShowConnectionMsg = true;
include('dbconnection.php');
?>
<!DOCTYPE html>
<html data-bs-theme="dark" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logga in</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="index.js"></script>
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <?php
    include('header.php');

    try {

        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $dbconn->prepare($sql);
            $stmt->execute([$username]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($res !== false && password_verify($password, $res['password'])) {
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
                echo "<script>window.location.href = 'index.php';</script>";
            } else {
                echo "<script>alert('Fel användarnamn eller lösenord!')</script>";
            }
        }
    } catch (PDOException $e) {
        echo $sql . "<br />" . $e->getMessage();
    }
    ?>
    <main class="form-signin w-100 m-auto">

        <div class="container">
            <div class="row g-5">
                <div class="col-sm">
                    <form method="POST" action="">
                        <h1 class="h3 mb-3 fw-normal">Logga in</h1>

                        <div class="form-floating">
                            <input type="username" class="form-control" name="username" id="floatingInput" required placeholder="Användarnamn">
                            <label for="floatingInput">Användarnamn</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control" name="password" id="floatingPassword" required placeholder="Lösenord">
                            <label for="floatingPassword">Lösenord</label>
                        </div>

                        <div class="">

                            <p><a class="link-opacity-75-hover" href="register.php">Registrera ett konto</a></p>
                        </div>
                        <button class="btn btn-primary w-100 py-2" type="submit">Logga in</button>
                    </form>
                </div>
                <div class="col-sm-7">
                    <h1 class="h3 mb-3 fw-normal d-none d-sm-block" style="visibility: hidden;">Logga in</h1>
                    <?php

                    include('topTen.php')
                    ?>

                </div>
            </div>
        </div>
    </main>
</body>

</html>