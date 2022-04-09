<?php
    if(!isset($_SESSION['admin'])){
        include('login/login.php');
        //header('Location:login/login.php');
        exit;
    } elseif(isset($_SESSION['admin'])!=""){
        header("Location:view/dashboard.php");
    }
?>