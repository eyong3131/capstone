<?php
    function sql_age_gender($sth,$date_select,$loc){
    $sth = "
        #Female
        (SELECT COUNT(DISTINCT patient_details.P_id) AS count,
        (CASE WHEN $date_select IS NOT NULL THEN 'yearFemale' ELSE 'MONTHLY' END) AS dates  
        FROM `patient_details`
        LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
        WHERE patient_profile.gender ='Female' AND YEAR($date_select) = YEAR(CURRENT_DATE())  $loc
        )
        UNION ALL
        (SELECT COUNT(DISTINCT patient_details.P_id) AS count,
        (CASE WHEN $date_select IS NOT NULL THEN 'monthFemale' ELSE 'YEARLY' END) AS dates 
        FROM `patient_details`
        LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
        WHERE patient_profile.gender ='Female' AND MONTH($date_select) = MONTH(CURRENT_DATE()) $loc
        )
        #Male
        UNION ALL
        (SELECT COUNT(DISTINCT patient_details.P_id) AS count,
        (CASE WHEN $date_select IS NOT NULL THEN 'yearMale' ELSE 'MONTHLY' END) AS dates 
        FROM `patient_details`
        LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
        WHERE patient_profile.gender ='Male' AND YEAR($date_select) = YEAR(CURRENT_DATE()) $loc
        )
        UNION ALL
        (SELECT COUNT(DISTINCT patient_details.P_id) AS count,
        (CASE WHEN $date_select IS NOT NULL THEN 'monthMale' ELSE 'YEARLY' END) AS dates 
        FROM `patient_details`
        LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
        WHERE patient_profile.gender ='MALE' AND MONTH($date_select) = MONTH(CURRENT_DATE()) $loc
        )
        #Newborn
        UNION ALL
        (SELECT COUNT(DISTINCT patient_details.P_id) AS count,
        (CASE WHEN $date_select IS NOT NULL THEN 'yearNewborn' ELSE 'yearNewborn' END) AS dates 
        FROM `patient_details`
        LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
        WHERE patient_profile.age = 0 AND YEAR($date_select) = YEAR(CURRENT_DATE()) $loc
        )
        UNION ALL
        (SELECT COUNT(DISTINCT patient_details.P_id) AS count,
        (CASE WHEN $date_select IS NOT NULL THEN 'monthNewborn' ELSE 'monthNewborn' END) AS dates 
        FROM `patient_details`
        LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
        WHERE patient_profile.age = 0 AND MONTH($date_select) = MONTH(CURRENT_DATE()) $loc
        )
        #Infant
        UNION ALL
        (SELECT COUNT(DISTINCT patient_details.P_id) AS count,
        (CASE WHEN $date_select IS NOT NULL THEN 'yearInfant' ELSE 'yearInfant' END) AS dates 
        FROM `patient_details`
        LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
        WHERE patient_profile.age = 1 AND YEAR($date_select) = YEAR(CURRENT_DATE()) $loc
        )
        UNION ALL
        (SELECT COUNT(DISTINCT patient_details.P_id) AS count,
        (CASE WHEN $date_select IS NOT NULL THEN 'monthInfant' ELSE 'monthInfant' END) AS dates 
        FROM `patient_details`
        LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
        WHERE patient_profile.age = 1 AND MONTH($date_select) = MONTH(CURRENT_DATE()) $loc
        )
        #Todler
        UNION ALL
        (SELECT COUNT(DISTINCT patient_details.P_id) AS count,
        (CASE WHEN $date_select IS NOT NULL THEN 'yearTodler' ELSE 'yearTodler' END) AS dates 
        FROM `patient_details`
        LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
        WHERE (patient_profile.age >= 2 AND patient_profile.age <= 5) AND YEAR($date_select) = YEAR(CURRENT_DATE()) 
        )
        UNION ALL
        (SELECT COUNT(DISTINCT patient_details.P_id) AS count,
        (CASE WHEN $date_select IS NOT NULL THEN 'monthTodler' ELSE 'monthTodler' END) AS dates 
        FROM `patient_details`
        LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
        WHERE (patient_profile.age >= 2 AND patient_profile.age <= 5) AND MONTH($date_select) = MONTH(CURRENT_DATE()) $loc
        )
        #Kids
        UNION ALL
        (SELECT COUNT(DISTINCT patient_details.P_id) AS count,
        (CASE WHEN $date_select IS NOT NULL THEN 'yearKid' ELSE 'yearKid' END) AS dates 
        FROM `patient_details`
        LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
        WHERE (patient_profile.age >= 6 AND patient_profile.age <= 13) AND YEAR($date_select) = YEAR(CURRENT_DATE()) $loc
        )
        UNION ALL
        (SELECT COUNT(DISTINCT patient_details.P_id) AS count,
        (CASE WHEN $date_select IS NOT NULL THEN 'monthKid' ELSE 'monthKid' END) AS dates 
        FROM `patient_details`
        LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
        WHERE (patient_profile.age >= 6 AND patient_profile.age <= 13) AND MONTH($date_select) = MONTH(CURRENT_DATE()) $loc
        )
        #Adult
        UNION ALL
        (SELECT COUNT(DISTINCT patient_details.P_id) AS count,
        (CASE WHEN $date_select IS NOT NULL THEN 'yearAdult' ELSE 'yearAdult' END) AS dates 
        FROM `patient_details`
        LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
        WHERE patient_profile.age > 14 AND YEAR($date_select) = YEAR(CURRENT_DATE()) $loc
        )
        UNION ALL
        (SELECT COUNT(DISTINCT patient_details.P_id) AS count,
        (CASE WHEN $date_select IS NOT NULL THEN 'monthAdult' ELSE 'monthAdult' END) AS dates 
        FROM `patient_details`
        LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
        WHERE patient_profile.age > 14 AND MONTH($date_select) = MONTH(CURRENT_DATE()) $loc
        )";
    return $sth;
    }
    function test($sth,$val,$val2,$val3,$val4){
        $sth = "
            SELECT COUNT(DISTINCT patient_details.P_id) AS count, $val3
            $val2 AS dates $val4
            FROM `patient_details`
            LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
            WHERE $val 
            GROUP BY YEAR(date), MONTH(date) $val4
            ORDER BY YEAR(date), MONTH(date)
        ";
        return $sth;
    }
    function monthly_cases($sql_sth){
        $value = array();
        while($get_result = $sql_sth->fetch(PDO::FETCH_ASSOC)){
            $value += array($get_result['count'] => $get_result['illness']);
            }
        return $value;
    }
    function calendar($sql_sth){
        $value = array();
        $month_name = array(
            0 => "Jan",
            1 => "Feb",
            2 => "Mar",
            3 => "Apr",
            4 => "May",
            5 => "Jun",
            6 => "Jul",
            7 => "Aug",
            8 => "Sep",
            9 => "Oct",
            10 => "Nov",
            11 => "Dec"
         );
        $calendar = array();
        $getMonth = getdate();
        $month = (int)$getMonth['mon'];
        for($i = 0; $i < $month; $i++){
            $calendar += array($month_name[$i] => "0");
        }
        while($get_result = $sql_sth->fetch(PDO::FETCH_ASSOC)){
            $value += array($get_result['month'] => $get_result['count']);
            }
        $monthly = array_replace($calendar,$value);
        return $monthly;
    }
    function table_case($sql_sth,$val1){
        $sql_sth = "
        SELECT 
        count(*) AS count,
        patient_details.illness,
        sum(case WHEN patient_details.status LIKE 'Deceased' then 1 else 0 end) AS deceased
        FROM patient_details LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
        WHERE $val1
        GROUP BY patient_details.illness DESC
        ";
        return $sql_sth;
    }
    function table_fetch($sth){
        $illness_cases = array();
        $illness_count_cases = array();
        $illness_count_deceased = array();
        $i = 0;
        while($get_result = $sth->fetch(PDO::FETCH_ASSOC)){
            $illness_cases += array( $i => $get_result['illness']);
            $illness_count_cases += array($i => $get_result['count']);
            $illness_count_deceased += array($i => $get_result['deceased']);
            $i++;
            }
        $value = array($illness_cases,$illness_count_cases,$illness_count_deceased);
        return $value;
    }
?>