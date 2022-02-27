<?php  
    try {
    $sth = $connection->prepare('
    SELECT 
    COUNT(*) AS count,
    patient_details.illness,
    sum(case WHEN patient_profile.gender = "female" then 1 else 0 end) AS female,
    sum(case WHEN patient_profile.gender ="Male" then 1 else 0 end) AS male,
    sum(case WHEN patient_profile.age = 0 then 1 else 0 end) AS newborn,
    sum(case WHEN patient_profile.age = 1 then 1 else 0 end) AS infant,
    sum(case WHEN patient_profile.age >= 2 AND patient_profile.age <= 5 then 1 else 0 end) AS todler,
    sum(case WHEN patient_profile.age >= 6 AND patient_profile.age <= 13 then 1 else 0 end) AS kid,
    sum(case WHEN patient_profile.age >= 14 then 1 else 0 end) AS adult
    FROM patient_details LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
    WHERE MONTH(patient_details.date) = MONTH(CURRENT_DATE())
    GROUP BY patient_details.illness 
    ORDER BY COUNT(*) ASC LIMIT 20
    ');
    $sth->execute();
    $table_dashboard = $sth->fetchAll(PDO::FETCH_ASSOC);
    $sth->nextRowset();
    }  catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }

?>