<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid m-1">
        <a class="navbar-brand" href="index.php"> <span class="display-6">Quizsidan</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 justify-content-end">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Hem</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create_quiz.php">Gör en quiz</a>
                </li>
                <li class="nav-item">
                    <div class="btn-group">
                            <button type="button" class="btn bg-light-subtle rounded-end-0" onclick="window.location.href='profile.php'">Profil</button>
                        <button type="button" class="btn bg-light-subtle dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="login.php">Byt konto</a></li>
                            <li><a class="dropdown-item" href="register.php">Registrera nytt konto</a></li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="logout.php">Logga ut</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item"><button class="btn bg-light-subtle mb-auto" onclick="change_theme()">Dark/Light</button></li>
                </li>
            </ul>
        </div>
    </div>
</nav>