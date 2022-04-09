<?php
session_start();
if(isset($_SESSION['admin'])){
    include_once('../../../config/config.php');
    $admin_address = $_SESSION['admin_address'];
    $sql_table = $connection->prepare("
    SELECT 
    users.user_id,
    users.name,
    users.middle,
    users.last,
    users.age,
    users.gender,
    users.address,
    users.email,
    users.time_joined,
    users.date_joined,
    users.user_status
    FROM `users`
    ");
    $sql_table -> execute();
    $table_assoc = $sql_table->fetchAll(PDO::FETCH_ASSOC);
    $info['data'] = $table_assoc;
    echo json_encode($info);
}
?>