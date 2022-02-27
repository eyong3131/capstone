<?php
    session_start();
    require_once('../../../config/config.php');
    if (isset($_SESSION['admin'])!=""){
        header("Location:../../view/user_table.php");
        //exit();
    }
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['login'])){
            $email=trim($_POST['email']);
            $email=htmlspecialchars($_POST['email']);
    
            $password=trim($_POST['password']);
            $password=htmlspecialchars($_POST['password']);
    
            $sth=$connection->prepare("SELECT * FROM `admin` WHERE email=:email");
            $sth->execute(array(':email'=>htmlspecialchars($_POST['email'])));
            $row=$sth->fetch(PDO::FETCH_ASSOC);
            $count=$sth->rowCount();
            if($count==1){
                if (password_verify(htmlspecialchars($_POST['password']) , $row['password']))
            {
            $_SESSION['admin'] = $row['user_id'] ;
            $_SESSION['admin_address'] = $row['address'];
            header("Location:../../view/user_table.php");
        
            $user_status="online";
            $stmt =$connection->prepare('UPDATE admin SET
                                    user_status=:user_status WHERE user_id=:id');
            $stmt->bindParam(':user_status',$user_status);
            $stmt->bindParam(':id',$_SESSION['admin']);
            $stmt->execute();
            $time_loged =date("Y-m-d H:i:s",strtotime("now"));
            $stmt=$connection->prepare('INSERT INTO `admin_activity`(time_loged,user_id)VALUES(?,?)');
            $stmt->bindparam(1,$time_loged);
            $stmt->bindparam(2,$_SESSION['admin']);
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
    }
?>
