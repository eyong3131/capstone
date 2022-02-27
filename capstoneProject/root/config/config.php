<?php
    define('USER', 'root');
    define('PASSWORD', '0505');
    define('HOST', '127.0.0.1');
    define('DATABASE', 'viral.com');
    try {
        $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }
?>
