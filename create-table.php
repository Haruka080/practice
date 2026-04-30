<?php
    $dsn = 'mysql:dbname=tb270560db;host=localhost';
    $user = 'tb-270560';
    $password = 'u7bf9T85g8';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = "CREATE TABLE IF NOT EXISTS tb5_4"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name CHAR(32),"
        . "comment TEXT,"
        . "date DATETIME,"
        . "passward CHAR(32)"
        .");";
 
    $stmt = $pdo->query($sql);
?>
