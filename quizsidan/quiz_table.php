<?php
include("dbconnection.php");

try {
    if (isset($_POST['newTable'])) {
        if ($_POST['newTable'] == "users") {

            /* users table */
            $sql = "CREATE TABLE users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(20) NOT NULL,
        username VARCHAR(20) NOT NULL,
        password VARCHAR(100) NOT NULL,
        admin INT(1) NOT NULL,
        latest_login TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
            $dbconn->exec($sql);
            // insert admin user as default
            $sql = "INSERT INTO users (name, username, password, admin)
            VALUES ('Arvid', 'ArvidDenBästa', '$2y$10$2Bs8QhDTIksSYyZZmTzhu.4zwbLek2sA90eRqCvvWaa2S625t8nsq', 1)";
            $dbconn->exec($sql);
        }

        if ($_POST['newTable'] == "quiz") {

            /* quiz table */
            $sql = "CREATE TABLE quiz (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        creator varchar(20) NOT NULL,
        name VARCHAR(50) NOT NULL
        )";

            $dbconn->exec($sql);
        }

        if ($_POST['newTable'] == "questions") {
            /* questions table */
            $sql = "CREATE TABLE questions (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        quiz_nr INT(6) UNSIGNED,
        question_nr INT(1),
        question VARCHAR(50),
        answer1 VARCHAR(30),
        answer2 VARCHAR(30),
        answer3 VARCHAR(30),
        correct int(1),
        FOREIGN KEY (quiz_nr) REFERENCES quiz(id) ON DELETE CASCADE
        )";
            $dbconn->exec($sql);
        }

        /* history table */
        if ($_POST['newTable'] == "history") {
            $sql = "CREATE TABLE history (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id int(6) UNSIGNED,
        quiz_name VARCHAR(30),
        quiz_id int(6),
        score int(1),
        q_amount int(1),
        time DECIMAL(5, 1),
        date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )";
            $dbconn->exec($sql);
        }

        if ($_POST['newTable'] == "websettings") {
            $sql = "CREATE TABLE websettings (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30),
                on_off TINYINT(1)
                )";
            $dbconn->exec($sql);

            $sql = "INSERT INTO websettings (name, on_off)
            VALUES (showCreatorName, 1)";
            $dbconn->exec($sql);
        }
    }

    if (isset($_POST['website'])) {
        header("Location:" . $_POST['website']);
    } else {
        header("Location: index.php");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
