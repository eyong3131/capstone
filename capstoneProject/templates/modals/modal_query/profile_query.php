<?php
    try { 
        $id=$_SESSION['user'];
        $profile_query = $connection->query("SELECT * FROM users inner join activity on users.user_id=activity.user_id where users.user_id='$id' LIMIT 5");
        $profile_sql    = "SELECT * FROM users WHERE user_id = :user_id";
        $profile_stmt   = $connection->prepare($profile_sql);
        $profile_result = $profile_stmt->execute(array(":user_id" => $id));
        $profile_urow   = $profile_stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }
    
?>
<?php    
    if(isset($_POST['logout'])){
      $user_status="offline";
          $stmt =$connection->prepare('UPDATE users SET
                                  user_status=:user_status WHERE user_id=:id');
      $stmt->bindParam(':user_status',$user_status);
      $stmt->bindParam(':id',$_SESSION['user']);
      $stmt->execute();
        $time_loged =date("Y-m-d H:i:s",strtotime("now"));
        $stmt=$connection->prepare('INSERT INTO activity(time_loged,user_id)VALUES(?,?)');
        $stmt->bindparam(1,$time_loged);
        $stmt->bindparam(2,$_SESSION['user']);
        $stmt->execute();
      session_destroy();
    }
  ?>
  <?php
  if(isset($_POST['updateProfile'])){
    if(file_exists($_FILES['myProfile']['tmp_name'])){
        $fileName = $_FILES['myProfile']['name'];
        $type = $_FILES['myProfile']['type'];
        $data = file_get_contents($_FILES['myProfile']['tmp_name']);
        $sth = $connection->prepare("
        UPDATE `users` 
        SET
        `fileName`=?,
        `type`=?,
        `img`=? 
        WHERE user_id = ?
        ");
        $sth->bindParam(1,$fileName);
        $sth->bindParam(2,$type);
        $sth->bindParam(3,$data);
        $sth->bindParam(4,$_SESSION['user']);
        try{
          $sth->execute();
        }catch(Exception $e){
          //echo "<script>console.log('". $e ."')</script>";
        }
        
        $sth->nextRowset();
      }
}
  ?>