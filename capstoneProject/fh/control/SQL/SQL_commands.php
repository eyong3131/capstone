<?php
  include('prepare_sth.php');
  if(isset($_POST['saveData'])|| isset($_POST['updateData'])){
    $name=trim($_POST['P_name']);
    $name=htmlspecialchars($_POST['P_name']);

    $middle=trim($_POST['P_middle']);
    $middle=htmlspecialchars($_POST['P_middle']);

    $last = trim($_POST['P_last']);
    $last = htmlspecialchars($_POST['P_last']);

    $age=trim($_POST['P_age']);
    $age=htmlspecialchars($_POST['P_age']);

    $gender=trim($_POST['P_gender']);
    $gender=htmlspecialchars($_POST['P_gender']);
    
    $address=trim($_POST['P_brgy']);
    $address=htmlspecialchars($_POST['P_brgy']);

    $email=trim($_POST['P_email']);
    $email=htmlspecialchars($_POST['P_email']);

    $password=trim($_POST['P_password']);
    $password=htmlspecialchars($_POST['P_password']);

    $user_status='offline';
    $time_joined =date("Y-m-d H:i:s",strtotime("now"));
    $date_joined =date("Y-m-d", strtotime("now"));

    if(file_exists($_FILES['myfile']['tmp_name'])){

      $fileName = $_FILES['myfile']['name'];
      $type = $_FILES['myfile']['type'];
      $data = file_get_contents($_FILES['myfile']['tmp_name']);
    }

    if(!empty($password)){
      $encrypt = password_hash($password,PASSWORD_DEFAULT);
    }

    /*
    $sth = $connection->prepare("CALL `checkUsers`(?);");
    $email_id = check_email($sth,$email);
    $sth->nextRowset();
    */
    //$sth=$connection->prepare("CALL `updateUser`(?,?,?,?,?,?,?)");
    $sth = $connection->prepare("
      SELECT users.user_id 
      FROM `users` 
      WHERE 
      users.name = ? AND 
      users.middle = ? AND 
      users.last = ? AND 
      users.age = ? AND 
      users.gender = ? AND 
      users.address = ? AND
      users.email LIKE CONCAT('%', ? , '%');"
    );
    $user_id=sql_check_admin($sth,$name,$middle,$last,$age,$email,$gender,$address);
    $sth->nextRowset();

    if(isset($_POST['saveData'])){
      if($user_id == NULL){
        try {
          //$sth=$connection->prepare("INSERT into  users(name,middle,last,age,gender,address,email,password,time_joined,date_joined,user_status)VALUES(?,?,?,?,?,?,?,?,?,?,?)");
          //sql_user($sth,$name,$middle,$last,$age,$email,$gender,$address,$encrypt,$user_status,$time_joined,$date_joined);
          $sth=$connection->prepare("INSERT into  users(name,middle,last,age,gender,address,email,password,time_joined,date_joined,user_status,fileName,type,img)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
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
          $sth->bindParam(12,$fileName);
          $sth->bindParam(13,$type);
          $sth->bindParam(14,$data);
          $sth->execute();
          $sth->nextRowset();
        } catch (PDOException $e) {
          exit("Error: " . $e->getMessage());
        }
      } else{
        echo "<script>alert('user already existed')</script>";
      }
    }
    if(isset($_POST['updateData'])){
      $details_id = $_POST['details_id'];
      $pwd;
      $img;
      if(isset($encrypt)){
        $pwd = ', `password`=?';
      }else{
        $pwd = '';
      }
      if(file_exists($_FILES['myfile']['tmp_name'])){
        $img = ", `fileName`=?,`type`=?,`img`=? ";
      }else{
        $img = '';
      }
      $sth = $connection->prepare("
      UPDATE `users` 
      SET 
      `name`=?,
      `middle`=?,
      `last`=?,
      `age`=?,
      `gender`=?,
      `address`=?,
      `email`=?,
      `time_joined`=?,
      `date_joined`=?,
      `user_status`=?
       $img
       $pwd
      WHERE user_id = $details_id
      ");
      $sth->bindparam(1,$name,PDO::PARAM_STR);
      $sth->bindparam(2,$middle,PDO::PARAM_STR);
      $sth->bindparam(3,$last,PDO::PARAM_STR);
      $sth->bindparam(4,$age,PDO::PARAM_INT);
      $sth->bindparam(5,$gender,PDO::PARAM_STR);
      $sth->bindparam(6,$address,PDO::PARAM_STR);
      $sth->bindparam(7,$email,PDO::PARAM_STR);
      $sth->bindparam(8,$time_joined,PDO::PARAM_STR);
      $sth->bindparam(9,$date_joined,PDO::PARAM_STR);
      $sth->bindparam(10,$user_status,PDO::PARAM_STR);
      if(file_exists($_FILES['myfile']['tmp_name'])){
        $sth->bindParam(11,$fileName);
        $sth->bindParam(12,$type);
        $sth->bindParam(13,$data);
      }
      if(isset($encrypt) && file_exists($_FILES['myfile']['tmp_name']) == NULL ){
        $sth->bindparam(11,$encrypt,PDO::PARAM_STR);
      }
      if(isset($encrypt) && file_exists($_FILES['myfile']['tmp_name'])){
        $sth->bindparam(14,$encrypt,PDO::PARAM_STR);
      }
      $sth->execute();
      $sth->nextRowset();
    }else{
        
    }
  }

?>