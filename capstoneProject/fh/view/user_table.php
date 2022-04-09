<?php
    session_start();
    date_default_timezone_set('Asia/Manila');
    include('../../config/config.php');
    //include('../../config/header_cdn.php');
    if(!isset($_SESSION['admin'])){
        header('Location: ../index.php');
        exit;
    } else {
        if(isset($_POST['logout'])){
          //header('refresh:0');
          header('Location: ../index.php');
          session_destroy();
        }
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Users</title>
  <!-- DataTables -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">  
  <link rel="stylesheet" href="../../assets/css/style.css">
  <style>
    table.dataTable tbody tr td:nth-child(2):hover {
      background-color:white !important;
      font-size:1rem;
   }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <!-- Modals ------------------------->
    <?php //include('add.php');?>
    <?php //include('../templates/modals/profile_modal.php');?>
    <?php include("../templates/modals/data_entry_modal.php");?> 
    <?php include("../templates/modals/edit_modal.php");?> 
    <?php include('../templates/modals/profile_modal.php');?>

  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
        <label class="myTitle"> Viral Disease Monitoring System</label>
        </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <form method="post">
          <li class="nav-item">
          <button id="logout1" type="submit" class="btn nav-link" name="logout" style="display:none;">
              <i class="fas fa-sign-out-alt"></i>
          </button>
        </li>
       </form>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- SPC LOGO -->
      <a href="#" class="brand-link">
        <img src="../../assets/img/spc.png" alt="Logo" width="100" style="margin-left:3.75rem;">
      </a>
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item" data-toggle="modal" data-target="#profile">
              <p class="nav-link">
              
              <?php 
                      if($profile_urow['type'] != NULL && $profile_urow['img'] != NULL){
                      ?><i>&nbsp &nbsp &nbsp &nbsp &nbsp </i>
                        <embed id="myProfile" class="img-fluid card-img-top" src="data:<?php echo $type ;?>;base64,<?php echo base64_encode($img);?>" width="100">
                      <?php }else {  ?>
                        <img class="profileImg " src="../../assets/img/account.png" alt="Profile" width="100" style="margin-left:3.75rem;">
                      <?php }

                      ?>
              </p>
            </li>
          <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-user-cog fa-2x fa-white"></i>
                <p class="myFont">
                  Users
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./sysconfig.php" class="nav-link">
                <i class="fas fa-cogs fa-2x fa-white"></i>
                <p class="myFont">
                  Configuration
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a id="logout2" href="#" class="nav-link">
              &nbsp<i class="fas fa-sign-out-alt fa-2x fa-white"></i>
              <p class="myFont">
                Logout
              </p>
              </a>

            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>User Table</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="d-flex justify-content-between">
        <h2><input id="tableSearch" class="form-control name" type="text" placeholder="Search" aria-label="Search"> </h2>
          </div>
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <!--Main Area-->
          ` <div class="table-responsive"> 
            <table class="table table-fluid table-sm  table-bordered" id="dataTable" style="width:100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Middle</th>
                  <th>Last</th>
                  <th>Age</th>
                  <th>Gender</th>
                  <th>Address</th>
                  <th>User Name</th>
                  <th>Time Joined</th>
                  <th>Date Joined</th>
                  <th>Status</th>
                  <th>Command</th>
                </tr>
              </thead>
            </table>
          </div>
    </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
    </footer>

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <?php }?>
  <!-- jQuery -->
  <script>
    $(document).ready(function() {
      $('#logout2').click(function(){ $('#logout1').click() });
      $(".fullName").keypress(function(event) {
        var character = String.fromCharCode(event.keyCode);
        return isValid(character);     
        });
        function isValid(str) {
            return !/[~`!@#$%\^&*()+=\-\[\]\\';,/{}|\\":<>\?1234678905]/g.test(str);
        }

    });

  </script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <!-- datatable -->
  <script type="text/javascript" src="../control/data/data_middle.js"></script>
  <!-- overlayScrollbars -->
  <script src="../../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>  
  <!--- others --->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!----table management---->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
</body>
</html>
