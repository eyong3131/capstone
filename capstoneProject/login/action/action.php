<?php
    session_start();
    require_once('../../config/config.php');
    date_default_timezone_set('Asia/Manila');
    if (isset($_SESSION['user'])!=""){
        header("Location:../../view/dashboard.php");
        //exit();
    }
    if(isset($_POST['login'])){
        $name=trim($_POST['email']);
        $name=htmlspecialchars($_POST['email']);
        
        $password=trim($_POST['password']);
        $password=htmlspecialchars($_POST['password']);

        $sth=$connection->prepare("SELECT * FROM users WHERE email=:email");
        $sth->execute(array(':email'=>htmlspecialchars($_POST['email'])));
        $row=$sth->fetch(PDO::FETCH_ASSOC);
        $count=$sth->rowCount();
        if($count==1){
            if (password_verify(htmlspecialchars($_POST['password']) , $row['password']))
        {
        $_SESSION['user'] = $row['user_id'];
        $_SESSION['user_address'] = $row['address'];
        $_SESSION['alert_check'] = true;
          header("Location:../../view/dashboard.php");
    
        $user_status="online";
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
    }else{
        $_SESSION['msg']='The Email or Password you entered is incorrect';
        header('Location:../../index.php');  

    }
    }else{
        $_SESSION['msg']='The Email or Password you entered is incorrect';
        header('Location:../../index.php');  

    }
}
    
?>
