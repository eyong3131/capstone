<?php
/*
    define('USER', 'id18263676_root');
    define('PASSWORD', '{tBR8{DEEXfCYd+3');
    define('HOST', 'localhost');
    define('DATABASE', 'id18263676_viral_com');
    */
    define('USER', 'root');
    define('PASSWORD', '0505');
    define('HOST', 'localhost');
    define('DATABASE', 'viral.com');
    try {
        $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
    } catch (PDOException $e) {
        exit("Error from database connection: " . $e->getMessage());
    }
?>
