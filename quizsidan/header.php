<header>
    <div class="header-container">
        <h1><a href="index.php">Quizsidan</a></h1>
        <nav>
            <ul>
                <li><a href="index.php">Hem</a></li>
                <li><a href="create_quiz.php">Skapa quiz</a></li>
                <li><a href="login.php">Byt konto/Logga in</a></li>
                <li><a href="register.php">Registrera nytt konto</a></li>
                <?php
                if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                    echo "<li><a href='view_table.php'>Visa tabeller</a></li>";
                }
                ?>
                <li><a href="profile.php">Profil</a></li>
            </ul>
        </nav>
    </div>
</header>