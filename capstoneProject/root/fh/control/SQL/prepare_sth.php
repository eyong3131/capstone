<?php
/********************Checking and executing*********************************/
/***************** patient check ***************************/
  function sql_check_user($sql_sth,$email){
    $sql_sth->bindParam(1, $email, PDO::PARAM_INT);
    return $sql_sth;
  } 
  function check_email($sth,$email){
    $sth->bindParam(1,$email, PDO::PARAM_STR);
    try {
      $sth->execute();
      $sth_id = $sth->fetch(PDO::FETCH_ASSOC);
      return (int)$sth_id['user_id'];
    } catch (PDOException $e) {
      exit("Error: " . $e->getMessage());
    }
  }
  function sql_user($sth,$name,$middle,$last,$age,$email,$gender,$address,$encrypt,$user_status,$time_joined,$date_joined){
    $sth->bindparam(1,$name,PDO::PARAM_STR);
    $sth->bindparam(2,$middle,PDO::PARAM_STR);
    $sth->bindparam(3,$last,PDO::PARAM_STR);
    $sth->bindparam(4,$age,PDO::PARAM_INT);
    $sth->bindparam(5,$gender,PDO::PARAM_STR);
    $sth->bindparam(6,$address,PDO::PARAM_STR);
    $sth->bindparam(7,$email,PDO::PARAM_STR);
    $sth->bindparam(8,$encrypt,PDO::PARAM_STR);
    $sth->bindparam(9,$time_joined,PDO::PARAM_STR);
    $sth->bindparam(10,$date_joined,PDO::PARAM_STR);
    $sth->bindparam(11,$user_status,PDO::PARAM_STR);
    try {
      $sth->execute();
      //$sth_id = $sth->fetch(PDO::FETCH_ASSOC);
      //return (int)$sth_id['user_id'];
    } catch (PDOException $e) {
      exit("Error: " . $e->getMessage());
    }
  }
  function sql_user_update($sth,$name,$middle,$last,$age,$email,$gender,$address){
    $sth->bindparam(':name',$name,PDO::PARAM_STR);
    $sth->bindparam('middle',$middle,PDO::PARAM_STR);
    $sth->bindparam(':last',$last,PDO::PARAM_STR);
    $sth->bindparam(':age',$age,PDO::PARAM_INT);
    $sth->bindparam('gender',$gender,PDO::PARAM_STR);
    $sth->bindparam(':address',$address,PDO::PARAM_STR);
    $sth->bindparam(':email',$email,PDO::PARAM_STR);
    try {
      $sth->execute();
      //$sth_id = $sth->fetch(PDO::FETCH_ASSOC);
      //return (int)$sth_id['user_id'];
    } catch (PDOException $e) {
      exit("Error: " . $e->getMessage());
    }
  }
  function update_password($sth,$encrypt){
    $sth->bindparam(':password',$encrypt,PDO::PARAM_STR);
    try {
      $sth->execute();
      //$sth_id = $sth->fetch(PDO::FETCH_ASSOC);
      //return (int)$sth_id['user_id'];
    } catch (PDOException $e) {
      exit("Error: " . $e->getMessage());
    }
  }
  function sql_check_admin($sth,$name,$middle,$last,$age,$email,$gender,$address){
    $sth->bindparam(1,$name,PDO::PARAM_STR);
    $sth->bindparam(2,$middle,PDO::PARAM_STR);
    $sth->bindparam(3,$last,PDO::PARAM_STR);
    $sth->bindparam(4,$age,PDO::PARAM_INT);
    $sth->bindparam(5,$gender,PDO::PARAM_STR);
    $sth->bindparam(6,$address,PDO::PARAM_STR);
    $sth->bindparam(7,$email,PDO::PARAM_STR);
    try {
      $sth->execute();
      $sth_id = $sth->fetch(PDO::FETCH_ASSOC);
      return (int)$sth_id['user_id'];
    } catch (PDOException $e) {
      exit("Error: " . $e->getMessage());
    }
  }
  function sql_check_response($sql_sth){
    try {
      $sql_sth->execute();
      $sql_id = $sql_sth->fetch(PDO::FETCH_ASSOC);
      return (int)$sql_id['user_id'];
    } catch (PDOException $e) {
      exit("Error: " . $e->getMessage());
    }
  }


?>