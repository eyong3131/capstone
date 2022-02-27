<?php
    if(!isset($_SESSION['user'])){
        include('login/login.php');
        //header('Location:login/login.php');
        exit;
    } elseif(isset($_SESSION['user'])!=""){
        header("Location:view/dashboard.php");
    }
?>