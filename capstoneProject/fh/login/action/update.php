
<?php
    session_start();
    require_once('../../../config/config.php');
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['reset'])){
            $email=trim($_POST['email']);
            $email=htmlspecialchars($_POST['email']);
    
            $sth=$connection->prepare("SELECT * FROM `admin` WHERE email=:email");
            $sth->execute(array(':email'=>htmlspecialchars($_POST['email'])));
            $row=$sth->fetch(PDO::FETCH_ASSOC);
            $count=$sth->rowCount();
            if($count==1){
                if (password_verify(htmlspecialchars($_POST['code']) , $row['temp_password']))
            {
                $new_password=trim($_POST['new_password']);
                $new_password=htmlspecialchars($_POST['new_password']);
                $encrypt = password_hash($new_password,PASSWORD_DEFAULT);
    
                $sth=$connection->prepare("UPDATE `admin` SET `password` = ? WHERE email=? ");
                $sth->bindParam(1,$encrypt,PDO::PARAM_STR);
                $sth->bindParam(2,$email,PDO::PARAM_STR);
    
                try{
                    $sth->execute();
                    $sth->nextRowset();
                    echo "Success";
                    $_SESSION['msg']='Please Login with your new password';
                    header('Location:../../index.php'); 
                  }catch(Exception $e){
                    echo "<script>console.log('". $e ."')</script>";
                    echo "something went wrong";
                  }

        }else{
            $_SESSION['msg']='The code you entered is wrong. Please try again.';
            header('Location:../update.php');
        }
        }else{
            $_SESSION['msg']='The code you entered is wrong. please try again';
            header('Location:../update.php');  
        }
    
    }
    }
?>