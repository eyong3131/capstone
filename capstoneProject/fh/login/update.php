<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Viral Diseases Monitoring System</title>
      <!-- Google Font: Source Sans Pro -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="../../../assets/plugins/fontawesome-free/css/all.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="../../../assets/css/adminlte.min.css">
      <link rel="stylesheet" href="../../../assets/css/login.css">
   </head>
   <body class="hold-transition login-page">
      <div class="login-box">
         <!-- /.login-logo -->
         <div class="card card-outline ">
            <div class="card-header text-center">
               <a  class="brand-link">
               <img src="../../../assets/img/spc.png" alt="Logo" width="125" style="margin-bottom: -10px;">
               </a>
               <h5>Forgot Password</h5>
            </div>
            <div class="card-body" >
               <form method="post" action="action/update.php">
                     <div class="col-12">
                        <?php
                            if(isset($_SESSION['msg'])){ 
                        ?>
                            <div class="col-12 alert alert-success" role="alert">
                        <?php 
                            echo $_SESSION['msg'];
                            }
                        ?>
                        </div>
                        <?php unset($_SESSION['msg']); ?>
                     </div>
                  <div class="input-group mb-3">
                     <input type="text" class="form-control form-control-lg" placeholder="Username" name="email">
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-user fa-lg"></span>
                        </div>
                     </div>
                  </div>
                  <div class="input-group mb-3">
                     <input type="password" class="form-control form-control-lg" placeholder="Code" name="code">
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-lock fa-lg"></span>
                        </div>
                     </div>
                  </div>
                  <div class="input-group mb-3">
                     <input type="password" class="form-control form-control-lg" placeholder="Password" name="new_password">
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-lock fa-lg"></span>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-6 offset-3">
                        <button type="submit" class="btn btn-primary btn-block btn-lg"  name="reset" >Reset</button>
                     </div>
                  </div>
               </form>
            </div>
            <!-- /.card-body -->
         </div>
         <!-- /.card -->
      </div>
      <!-- /.login-box -->
   </body>
</html>