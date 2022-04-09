<?php
  include('prepare_sth.php');
  if(isset($_POST['saveData'])|| isset($_POST['updateData'])){
    /********* naming ************/
    $P_name = trim(ucfirst($_POST['P_name']));
    $P_middle = ucfirst($_POST['P_middle']);
    $P_last = trim(ucfirst($_POST['P_last']));
    $P_age = (int)$_POST['P_age'];
    $P_gender = $_POST['P_gender'];
    $P_illness = strtoupper($_POST['P_illness']);
    $P_description = NULL;
    if($_POST['P_description'] != NULL){
      $P_description = $_POST['P_description'];
    }
    $P_date = date('Y-m-d',strtotime($_POST['P_date']));
    $P_brgy = $_POST['P_brgy'];
    $P_status = $_POST['P_status'];
    $P_status_date = NULL;
    if($_POST['P_status_date']!=NULL){
    $P_status_date = date('Y-m-d',strtotime($_POST['P_status_date']));
    }
    /***************sub names*****************/
    $p_id = ":P_id";
    $name = ":P_name";
    $middle = ":P_middle";
    $last = ":P_last";
    $age = ":P_age";
    $gender =":P_gender";
    $illness = ":P_illness";
    $description = ":P_description";
    $date = ":P_date";
    $brgy = ":P_brgy";
    $status = ":P_status";
    $second = ":P_status_date";

    try {
      /***************************/
        /**************check profile******************* */
        //$sql_sth = $connection->prepare("CALL `checkPatient`($name,$middle,$last,$age);");
        $sql_sth = $connection->prepare("
        SELECT patient_profile.id FROM `patient_profile` WHERE 
        patient_profile.name=$name AND 
        patient_profile.middle=$middle AND 
        patient_profile.last=$last AND 
        patient_profile.age=$age;
        ");
        sql_check_prepare($sql_sth,$P_name,$P_middle,$P_last,$P_age,$name,$middle,$last,$age);
        $person_id = sql_check_response($sql_sth);
        $sql_sth->nextRowset();
        /******************************** */
        /************Illness Records Check***********/
        //$sql_sth = $connection->prepare("CALL `checkIllness`($illness);");
        $sql_sth = $connection->prepare("
        SELECT id FROM `illness_desc` 
        WHERE 
        illness_desc.illness_type LIKE CONCAT('%', $illness , '%');
        ");
        $illness_records = illness_check_response($sql_sth,$illness,$P_illness);
        $sql_sth->nextRowset();
        /***************illness insert******************/
        if ($illness_records == NULL){
        $sql_sth = $connection->prepare("INSERT INTO `illness_desc`(`illness_type`,`action`)VALUES($illness,$description);");
        illess_execute_response($sql_sth,$illness,$P_illness,$description,$P_description);
        $sql_sth->nextRowset();
        }else{
          $sql_sth = $connection->prepare("UPDATE `illness_desc` SET `action` = ? WHERE `illness_type` = ? ");
          $sql_sth ->bindParam(1, $P_description);
          $sql_sth ->bindParam(2, $P_illness);
          $sql_sth ->execute();
          $sql_sth ->nextRowset();
        }
        /*****************check details records This needs to update connected to prepare_sth file Line 36 *********************/
        //$sql_sth = $connection->prepare("CALL `checkDetails`($name,$middle,$last,$brgy,$age,$gender,$illness,$date,$status,$second);");
        $sql_sth = $connection->prepare("
        SELECT 
        patient_details.id AS details_ID
        FROM `patient_profile` 
        INNER JOIN `patient_details`    
        ON patient_details.P_id = patient_profile.id 
        WHERE
        patient_profile.name = $name AND 
        patient_profile.middle = $middle AND 
        patient_profile.last = $last AND 
        patient_profile.address = $brgy AND 
        patient_profile.age = $age AND 
        patient_profile.gender=$gender AND 
        patient_details.illness  = $illness AND 
        patient_details.date = $date AND 
        patient_details.status = $status AND 
        patient_details.second_status <=> $second;
        ");
        prepare_details($sql_sth,$name,$middle,$last,$brgy,$age,$gender,$illness,$date,$status,$second,$P_name,$P_middle,$P_last,$P_brgy,$P_age,$P_gender,$P_illness,$P_date,$P_status,$P_status_date);
        $check_details = sql_details_response($sql_sth);
        $sql_sth->nextRowset(); 
      /**************************/

      if(isset($_POST['saveData'])){
        //inserting patient information if not existing
        if ($person_id == NULL){
        $sql_sth = $connection->prepare("
        INSERT INTO `patient_profile`(`name`,`middle`,`last`,`age`,`address`,`gender`) 
        VALUES($name,$middle,$last,$age,$brgy,$gender);");
        sql_profile_prepare($sql_sth,$P_name,$P_middle,$P_last,$P_age,$P_brgy,$P_gender,$name,$middle,$last,$age,$brgy,$gender);
        execute_response($sql_sth);
        $sql_sth->nextRowset();
        /*************** retreve id *********************/
        //$sql_sth = $connection->prepare("CALL `checkPatient`($name,$middle,$last,$age);");
        $sql_sth = $connection->prepare("
        SELECT patient_profile.id FROM `patient_profile` WHERE 
        patient_profile.name=$name AND 
        patient_profile.middle=$middle AND 
        patient_profile.last=$last AND 
        patient_profile.age=$age;
        ");
        sql_check_prepare($sql_sth,$P_name,$P_middle,$P_last,$P_age,$name,$middle,$last,$age);
        $person_id = sql_check_response($sql_sth);
        $sql_sth->nextRowset();
        }
        /**************** Insert Records ********/
        if($check_details == NULL){
          $sql_sth = $connection->prepare("
          INSERT INTO `patient_details` (`P_id`,`illness`,`date`,`status`,`second_status`)
          VALUES($p_id, $illness,$date,$status,$second);
          ");
          details_prepare($sql_sth,$person_id,$p_id,$P_date,$date,$P_illness,$illness,$P_status,$status,$P_status_date,$second);
          execute_response($sql_sth);
          $sql_sth->nextRowset();
        }else{
          echo '<script>alert("the records that you just entered already existed, try searching it instead")</script>';
        }
        /*****************************************/
        
      }elseif(isset($_POST['updateData'])){
        try {  
          
        /**************************/
        $details_id = $_POST['details_id'];
        $profile_id = $_POST['profile_id'];
        if($check_details == NULL){
          $sql_profile_update = $connection->prepare("UPDATE `patient_profile` SET 
          patient_profile.name=$name, 
          patient_profile.middle=$middle,
          patient_profile.last=$last,
          patient_profile.address=$brgy,
          patient_profile.age=$age,
          patient_profile.gender=$gender
          WHERE 
          patient_profile.id=$profile_id");
          sql_profile_prepare($sql_profile_update,$P_name,$P_middle,$P_last,$P_age,$P_brgy,$P_gender,$name,$middle,$last,$age,$brgy,$gender);
          execute_response($sql_profile_update);
          $sql_profile_update->nextRowset();
          /*************** retreve id again *********************/
          //$sql_sth = $connection->prepare("CALL `checkPatient`($name,$middle,$last,$age);");
          $sql_sth = $connection->prepare("
          SELECT patient_profile.id FROM `patient_profile` WHERE 
          patient_profile.name=$name AND 
          patient_profile.middle=$middle AND 
          patient_profile.last=$last AND 
          patient_profile.age=$age;
          ");
          sql_check_prepare($sql_sth,$P_name,$P_middle,$P_last,$P_age,$name,$middle,$last,$age);
          $person_id = sql_check_response($sql_sth);
          $sql_sth->nextRowset();
          $sql_details_update = $connection->prepare("UPDATE `patient_details`SET
          patient_details.P_id = $p_id,
          patient_details.illness = $illness,
          patient_details.date = $date,
          patient_details.status = $status,
          patient_details.second_status = $second
          WHERE
          id = $details_id 
          ");
          details_prepare($sql_details_update,$person_id,$p_id,$P_date,$date,$P_illness,$illness,$P_status,$status,$P_status_date,$second);
          execute_response($sql_details_update);
          $sql_details_update->nextRowset();
          
        }else{
          echo '<script>alert("the records that you just entered already existed, try searching it instead")</script>';
        }

          
        }catch (PDOException $e){
          exit("Error: " . $e->getMessage());
      }


      }else{
        
      }
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }
  }

?>