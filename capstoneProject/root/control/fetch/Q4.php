<?php
    include_once('../../config/config.php');
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
            WHERE QUARTER(pt.date) = 4 AND YEAR(pt.date) = YEAR(CURRENT_DATE())
            GROUP BY pp.name, pp.middle,pp.last, pp.age, pp.address, pp.gender");
    $sql_sth -> execute();
    $table_assoc = $sql_sth->fetchAll(PDO::FETCH_ASSOC);
    $info['data'] = $table_assoc;
    echo json_encode($info);
    $sql_sth->nextRowset();
?>