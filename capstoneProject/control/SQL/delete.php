<?php
    require_once("../../config/config.php");
    if(isset($_POST["del_id"])){
      try {
        $del_id = $_POST["del_id"];
        /** save to temp DB  and delete later */
        $sth = $connection->prepare("
        INSERT temp_patient_details(
          temp_patient_details.P_id,
          temp_patient_details.illness,
          temp_patient_details.date,
          temp_patient_details.status, 
          temp_patient_details.second_status,
          temp_patient_details.timestamp
          )
          SELECT 
          patient_details.P_id,
          patient_details.illness,
          patient_details.date,
          patient_details.status,
          patient_details.second_status,
          CURDATE()
          FROM patient_details
          WHERE patient_details.id = ?
        ");
        $sth->bindParam( 1 , $del_id, PDO::PARAM_INT);
        $sth->execute();
        $sth->nextRowset();
        /***************/
        $prep = $connection->prepare("DELETE FROM patient_details WHERE id=?");
        $prep->bindParam( 1 , $del_id, PDO::PARAM_INT);
        $prep_result = $prep->execute();
      } catch (PDOException $e) {
          exit("Error ako: " . $e->getMessage());
      }  
    }

    $prep = $connection = null;
?>