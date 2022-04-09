<?php
    require_once("../../../config/config.php");
    try {
      $del_id = $_POST["delete_id"];
      $prep = $connection->prepare("DELETE FROM users WHERE user_id=:del_id");
      $prep->bindParam(":del_id", $del_id, PDO::PARAM_INT);
      $prep_result = $prep->execute();
      $data = $del_id;
      echo $data;
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }
    $prep = $connection = null;
?>