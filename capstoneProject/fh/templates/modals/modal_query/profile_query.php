<?php
    try { 
        $id=$_SESSION['admin'];
        $profile_query = $connection->query("SELECT * FROM `admin` inner join `admin_activity` on admin.user_id=admin_activity.user_id where admin.user_id='$id' LIMIT 5");
        $profile_sql    = "SELECT * FROM `admin` WHERE user_id = :user_id";
        $profile_stmt   = $connection->prepare($profile_sql);
        $profile_result = $profile_stmt->execute(array(":user_id" => $id));
        $profile_urow   = $profile_stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }
    
?>