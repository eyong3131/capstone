<?php
try{
    $sth = $connection->prepare("SELECT `id` AS id, `illness_type` AS type,`actions`  FROM `illness_desc` ");
    $sth->execute();
    $config_table = $sth->fetchAll(PDO::FETCH_ASSOC);
    $sth->nextRowset();
    $sth = $connection->prepare("SELECT `code` AS apiCode, `password` AS apiPassword FROM `itexmo`");
    $sth->execute();
    $itextmoapi = $sth->fetchAll(PDO::FETCH_ASSOC);
    $sth->nextRowset();
    }  catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }


?>