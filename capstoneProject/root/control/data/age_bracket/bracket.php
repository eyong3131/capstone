<?php
    $sql_sth = $connection->prepare("
    SELECT COUNT(DISTINCT patient_details.P_id) AS count FROM `patient_details`
    LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
    WHERE patient_profile.gender ='Female' ");
?>