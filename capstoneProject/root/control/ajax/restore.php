<?php 
include('../../config/config.php');
    if(isset($_POST["details_id"])){
        $di = $_POST['details_id'];
        $sth = $connection ->prepare("
            INSERT patient_details(
                patient_details.P_id,
                patient_details.illness,
                patient_details.date,
                patient_details.status, 
                patient_details.second_status
                )
                SELECT 
                temp_patient_details.P_id,
                temp_patient_details.illness,
                temp_patient_details.date,
                temp_patient_details.status,
                temp_patient_details.second_status
                FROM temp_patient_details
                WHERE temp_patient_details.id = ?
            ");
        $sth->bindParam( 1 , $di, PDO::PARAM_INT);
        $sth->execute();
        $sth->nextRowset();
        $sth = $connection ->prepare("DELETE  FROM `temp_patient_details` WHERE temp_patient_details.id = ?");
        $sth->bindParam( 1 , $di, PDO::PARAM_INT);
        $sth->execute();
        $sth->nextRowset();
        echo "Data Has Been Restored";
        $connection = NULL;
    }
?>