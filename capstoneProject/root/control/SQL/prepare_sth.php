<?php
/********************Checking and executing*********************************/
/***************** patient check ***************************/
  function sql_check_prepare($sql_sth,$P_name,$P_middle,$P_last,$P_age,$name,$middle,$last,$age){
    $sql_sth->bindParam($name, $P_name, PDO::PARAM_STR);
    $sql_sth->bindParam($middle, $P_middle, PDO::PARAM_STR);
    $sql_sth->bindParam($last, $P_last, PDO::PARAM_STR);
    $sql_sth->bindParam($age, $P_age, PDO::PARAM_INT);
    return $sql_sth;
  } 

  /******************* patient profile *************************/
  function sql_profile_prepare($sql_sth,$P_name,$P_middle,$P_last,$P_age,$P_brgy,$P_gender,$name,$middle,$last,$age,$brgy,$gender){
    $sql_sth->bindParam($name, $P_name, PDO::PARAM_STR);
    $sql_sth->bindParam($middle, $P_middle, PDO::PARAM_STR);
    $sql_sth->bindParam($last, $P_last, PDO::PARAM_STR);
    $sql_sth->bindParam($age, $P_age, PDO::PARAM_INT);
    $sql_sth->bindParam($brgy, $P_brgy, PDO::PARAM_STR);
    $sql_sth->bindParam($gender,$P_gender, PDO::PARAM_STR);
    return $sql_sth;
  }
  /****************** Illness **************************/
  function illess_execute_response($sql_sth,$illness,$P_illness,$description,$P_description){
    $sql_sth ->bindParam($illness, $P_illness, PDO::PARAM_STR);
    $sql_sth ->bindParam($description, $P_description, PDO::PARAM_STR);
    $sql_sth->execute();
  }
  /****************** patient profiling **************************/
  function details_prepare($sql_sth,$person_id,$p_id,$P_date,$date,$P_illness,$illness,$P_status,$status,$P_status_date,$second){
    $sql_sth->bindParam($p_id, $person_id, PDO::PARAM_INT);
    $sql_sth->bindParam($date, $P_date, PDO::PARAM_STR);
    $sql_sth->bindParam($illness, $P_illness, PDO::PARAM_STR);
    $sql_sth->bindParam($status, $P_status, PDO::PARAM_STR);
    $sql_sth->bindParam($second, $P_status_date, PDO::PARAM_STR);
    return $sql_sth;
    
  }
  /*****************check details This is it********************* */
  function prepare_details($sql_sth,$name,$middle,$last,$brgy,$age,$gender,$illness,$date,$status,$second,$P_name,$P_middle,$P_last,$P_brgy,$P_age,$P_gender,$P_illness,$P_date,$P_status,$P_status_date){
    //($sql_sth,$p_id,$illness,$date,$status,$second,$person_id,$P_illness,$P_date,$P_status,$P_status_date){
    $sql_sth->bindParam($name, $P_name, PDO::PARAM_STR);
    $sql_sth->bindParam($middle, $P_middle, PDO::PARAM_STR);
    $sql_sth->bindParam($last, $P_last, PDO::PARAM_STR);
    $sql_sth->bindParam($brgy, $P_brgy, PDO::PARAM_STR);
    $sql_sth->bindParam($age, $P_age, PDO::PARAM_INT);
    $sql_sth->bindParam($gender,$P_gender, PDO::PARAM_STR);
    //$sql_sth->bindParam($p_id, $person_id, PDO::PARAM_INT);
    $sql_sth->bindParam($date, $P_date, PDO::PARAM_STR);
    $sql_sth->bindParam($illness, $P_illness, PDO::PARAM_STR);
    $sql_sth->bindParam($status, $P_status, PDO::PARAM_STR);
    $sql_sth->bindParam($second, $P_status_date, PDO::PARAM_STR);
    return $sql_sth;
  }

  /********************* Check and Execute General statements *****************************/
  function illness_check_response($sql_sth,$illness,$P_illness){
    $sql_sth ->bindParam($illness, $P_illness, PDO::PARAM_STR);
      try {
      $sql_sth->execute();
      $sql_val = $sql_sth->fetch(PDO::FETCH_ASSOC);
      return (int)$sql_val['id'];
      } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
      }
  }
  function sql_check_response($sql_sth){
    try {
      $sql_sth->execute();
      $sql_id = $sql_sth->fetch(PDO::FETCH_ASSOC);
      return (int)$sql_id['id'];
    } catch (PDOException $e) {
      exit("Error: " . $e->getMessage());
    }
  }
  function sql_details_response($sql_details_response){
    try {
      $sql_details_response->execute();
      $sql_details_id = $sql_details_response->fetch(PDO::FETCH_ASSOC);
      return (int)$sql_details_id['details_ID'];
    } catch (PDOException $e) {
      exit("Error: " . $e->getMessage());
    }
  }
  function execute_response($sql_details){
    try{
      $sql_details->execute();
    }catch(PDOException $e) {
      exit("Error: " . $e->getMessage());
    }
    
  }

?>