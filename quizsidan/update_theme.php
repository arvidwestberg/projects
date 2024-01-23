<?php
session_start();

if (isset($_GET['theme'])) {
    $_SESSION['theme'] = $_GET['theme'];
}
echo "<script>console.log('theme: " . $_SESSION['theme'] . "')</script>";
?>