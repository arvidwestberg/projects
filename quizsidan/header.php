<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the theme is already set in the session
if (isset($_SESSION['theme'])) {
    $theme = $_SESSION['theme'];

    echo "<script> document.documentElement.setAttribute('data-bs-theme', '$theme');</script>";
}else{
    $theme = "light";
    echo "<script> document.documentElement.setAttribute('data-bs-theme', '$theme');</script>";

}

?>
<nav class="navbar navbar-expand-sm bg-body-tertiary fixed-top border-bottom">
    <div class="container-fluid m-1">
        <a class="navbar-brand" href="index.php"> <span class="display-6">Quizsidan</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Quizsidan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Hem</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="create_quiz.php">Gör en quiz</a>
                    </li>
                    <li class="nav-item d-none d-sm-block">
                        <div class="btn-group">
                            <button type="button" class="btn bg-light-subtle m-0" onclick="window.location.href='profile.php'">Profil</button>
                            <button type="button" class="btn bg-light-subtle m-0 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="w-100"><a class="dropdown-item" href="login.php">Byt konto</a></li>
                                <li class="w-100"><a class="dropdown-item" href="register.php">Registrera nytt konto</a></li>
                                <hr class="dropdown-divider">
                                <li class="w-100"><a class="dropdown-item" href="logout.php">Logga ut</a></li>
                            </ul>
                        </div>
                    </li>

                    <div class="nav-item d-block my-2 d-sm-none">
                        <li class="nav-item"><a class="nav-link" href="login.php">Byt konto</a></li><br>
                        <li class="nav-item"><a class="nav-link" href="register.php">Registrera nytt konto</a></li>
                        <hr class="nav-divider">
                        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logga ut</a></li>
                    </div>
                    <div class="position-fixed bottom-0 end-0 mb-2 me-3" onclick="changeTheme('<?php echo $theme; ?>')">
                        <button class=" btn btn-primary py-2 px-3"><span class="bi bi-brightness-high m-0 h4"></span></button>
                    </div>
                </ul>
            </div>
        </div>
    </div>
    </div>
</nav>
<br>
<br>
<br>
<br>