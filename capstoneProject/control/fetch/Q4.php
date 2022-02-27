<?php
    include_once('../../config/config.php');
    $sql_sth = $connection->prepare("
    SELECT
    pp.id, 
    CONCAT(pp.name,\" \", pp.middle, \" \", pp.last) AS name, 
    pp.address, 
    pp.age, pp.gender, 
    pt.id AS person_id, 
    pt.illness AS illness, 
    max(DATE_FORMAT(pt.date,'%b/%d/%y')) AS date,
    pt.status AS status, 
    DATE_FORMAT( pt.second_status,'%b/%d/%y') AS second_status 
    FROM patient_profile AS pp INNER JOIN patient_details as pt ON pp.id = pt.P_id
            WHERE QUARTER(pt.date) = 4 AND YEAR(pt.date) = YEAR(CURRENT_DATE())
            GROUP BY pp.name, pp.middle,pp.last, pp.age, pp.address, pp.gender");
    $sql_sth -> execute();
    $table_assoc = $sql_sth->fetchAll(PDO::FETCH_ASSOC);
    $info['data'] = $table_assoc;
    echo json_encode($info);
    $sql_sth->nextRowset();
?>