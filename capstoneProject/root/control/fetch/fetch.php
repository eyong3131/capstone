<?php
    include_once('../../config/config.php');
    
    $sql_sth = $connection->prepare("
    UPDATE `patient_details`
    SET patient_details.status = 'CURED', patient_details.second_status =(patient_details.date + INTERVAL 14 DAY)
    WHERE patient_details.date <= CURRENT_DATE() - INTERVAL 14 DAY AND patient_details.second_status IS NULL");
    $sql_sth->execute();
    $sql_sth->nextRowset();

    $sql_sth = $connection->prepare("
        SELECT 
        pp.id,
        CONCAT(pp.name,\" \", pp.middle, \" \", pp.last) AS name,
        pp.address,
        pp.age,
        pp.gender,
        GROUP_CONCAT(pt.id SEPARATOR ' ') AS person_id,
        GROUP_CONCAT(pt.illness SEPARATOR ',<br>') AS illness,
        GROUP_CONCAT(DATE_FORMAT(pt.date,'%b/%d/%y') SEPARATOR ',<br>') AS date,
        GROUP_CONCAT(pt.status SEPARATOR ',<br>') AS status,
        GROUP_CONCAT(DATE_FORMAT( pt.second_status,'%b/%d/%y') SEPARATOR ',<br>') AS second_status
        FROM patient_profile AS pp
            INNER JOIN 
            patient_details as pt   
            ON pp.id = pt.P_id 
            GROUP BY pp.name, pp.middle,pp.last, pp.age, pp.address, pp.gender");
    $sql_sth -> execute();
    $table_assoc = $sql_sth->fetchAll(PDO::FETCH_ASSOC);
    $info['data'] = $table_assoc;
    echo json_encode($info);
    $sql_sth->nextRowset();
?>