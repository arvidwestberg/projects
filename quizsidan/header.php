<?php
session_start();

// Check if the theme is already set in the session
if (isset($_SESSION['theme'])) {
    $theme = $_SESSION['theme'];

    echo "<script> document.documentElement.setAttribute('data-bs-theme', '$theme');</script>";
}

?>
<nav class="navbar navbar-expand-sm fixed-top border-bottom">
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
                                <li><a class="dropdown-item" href="login.php">Byt konto</a></li><br>
                                <li><a class="dropdown-item" href="register.php">Registrera nytt konto</a></li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="logout.php">Logga ut</a></li>
                            </ul>
                        </div>
                    </li>
                    <ul class="nav-item d-block d-sm-none">
                        <li><a class="nav-item" href="login.php">Byt konto</a></li>
                        <li><a class="nav-item" href="register.php">Registrera nytt konto</a></li>
                        <hr class="nav-divider">
                        <li><a class="nav-item" href="logout.php">Logga ut</a></li>
                    </ul>
                    <li class="nav-item m-0 mt-1 ms-2" id="themeIcon">
                        <i class="bi bi-brightness-high align-bottom h4" onclick="changeTheme('<?php echo $theme; ?>')"></i>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    </div>
</nav>
<br>
<br>
<br>