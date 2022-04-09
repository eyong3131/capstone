<?php
//##########################################################################
// ITEXMO SEND SMS API - PHP - CURL METHOD
// Visit www.itexmo.com/developers.php for more info about this API
//##########################################################################

function itexmo($number,$message,$apicode,$passwd){
    $ch = curl_init();
    $itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
    curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 
              http_build_query($itexmo));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    return curl_exec ($ch);
    curl_close ($ch);
  }
  //##########################################################################
  
?>


<?php
    try{
        //Getting Highest Case base on User address
        $user_address = $_SESSION['user_address'];
        $sth_cases = $connection->prepare("
        SELECT COUNT(*) AS count, MAX(patient_details.illness) AS illness, patient_profile.address  FROM patient_details
        LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
        WHERE MONTH(date) = MONTH(CURRENT_DATE()) AND patient_profile.address LIKE '%$user_address%'
        GROUP BY patient_details.illness
		ORDER BY COUNT(*) DESC LIMIT 1
        ");
        $sth_cases->execute();
        $case  = $sth_cases->fetch(PDO::FETCH_ASSOC);
        $sth_cases->nextRowset();

        $highest_case = $case['illness'];
        $case_value = $case['count'];
        $recommendation = '';
        //Getting illness Information
        $sth_cases = $connection->prepare("
        SELECT * FROM `illness_desc` WHERE illness_type LIKE '%$highest_case%'
        ");
        $sth_cases->execute();
        $case_name  = $sth_cases->fetch(PDO::FETCH_ASSOC);
        $sth_cases->nextRowset();

        $getMonth = getdate();
  

        $sth_cases = $connection->prepare("
            SELECT COUNT(*) AS count, MAX(patient_details.illness) AS illness FROM patient_details
            LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
            WHERE YEAR(patient_details.date) = YEAR(CURRENT_DATE() - INTERVAL 1 YEAR) AND 
            MONTH(patient_details.date) = MONTH(CURRENT_DATE()- INTERVAL 12 MONTH) AND patient_profile.address LIKE '%$user_address%'
            GROUP BY patient_details.illness 
            ORDER BY COUNT(*) DESC LIMIT 5
        ");
        $sth_cases->execute();
        $prediction = "";
        while($get_result = $sth_cases->fetch(PDO::FETCH_ASSOC)){
            $prediction .= $get_result['illness'] . ", ";
            }
        
        $sth_cases->nextRowset();

        /** Warning Support*/
        if($case_value >= 1 || $case_value <= 3){
            $actions = $case_name['actions'];
            $recommend = "We Recommend to ";
            $additional = "if the situation gotten worse.";
            $sentence = "As of ". $getMonth['month'] ." ". $getMonth['year'] .' '.
                        "The Leading Viral Case from ".$user_address. " is: ".$highest_case." ".
                        "With the case number of:  " . 
                        $case['count']." ".$recommend ." ". $actions ." ". $additional;
            
            $number = "09387884716";
            $message = "NOTICE FROM ".$user_address." HEALTH CENTER Disease:".$highest_case."  Cases#: ".$case['count'];
            $apicode = "TR-MAYET926662_XEQA1";
            $passwd = "k]46l#8&#p";
            if($_SESSION['alert_check']){
                itexmo($number,$message,$apicode,$passwd); 
                $_SESSION['alert_check'] = false;

            }
        }else{
            $actions = '';
            $recommend = " ";
            $additional = " ";
            $sentence = "There still no record at the moment.";
        }

        /** Prediction Support */
        if($prediction != NULL){
            $prediction_sentence = "The System expected the ". $prediction ." Please observe the Case carefully";
        }else{
            $prediction_sentence = "The System Expect nothing from this month. Please encode some information to the system.";
        }



    } catch (PDOException $e) {
        echo $connection;
        exit("Error: " . $e->getMessage());
    }
?>