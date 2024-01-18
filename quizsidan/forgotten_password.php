<?php
$dontShowConnectionMsg = true;
include('dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgotten Password</title>
    <link rel="stylesheet" href="style.css?">
</head>

<body>
    <?php
    include('header.php');

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute([$email]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($res !== false) {
            $newPassword = uniqid();
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = ? WHERE email = ?";
            $stmt = $dbconn->prepare($sql);
            $stmt->execute([$hashedPassword, $email]);

            $to = $email;
            $subject = "Password reset";
            $txt = "Your new password is: " . $newPassword . "\n\nYou can change it under your profile.";
            $headers = "From: arvidwg@varmdogymnasium.se";
            if (mail($to, $subject, $txt, $headers)) {
                $_SESSION['code_time'] = time();
                // alert
                echo "<script>alert('Password resetted successfully. Check your inbox for confirmation code.');</script>";
                // redirect after 3 seconds
                header("refresh:0.01;url=login.php");
            } else {
                echo "Something went wrong, email not sent. <br><br>";
            }
        } else {
            echo "<script>alert('Your email is not in the system');</script>";
        }
    }


    ?>
    <div class="absolute_centered w30 min-w-200">
        <div class="userInput inputLarge w100">
            <form action="" method="POST">
                <input type="email" name="email" placeholder="Email" required><br>
                <button class="btn blue-btn mb-0" type="submit">Reset password</button>
            </form>
        </div>
    </div>
</body>

</html>