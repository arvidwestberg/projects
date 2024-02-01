<?php
// reset session
session_start();
// $theme = $_SESSION['theme'];
session_unset();
session_destroy();
session_start();
// $_SESSION['theme'] = $theme;
header("Location: login.php");
