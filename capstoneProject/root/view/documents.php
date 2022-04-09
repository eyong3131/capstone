<?php
    session_start();
    include('../config/config.php');
    date_default_timezone_set('Asia/Manila');
    if(!isset($_SESSION['user'])){
        header('Location: ../index.php');
        exit;
    } else {
        if(isset($_POST['logout'])){
          header('refresh:0');
        }
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Documents</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- DataTables -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 

  <!-- Latest compiled JavaScript -->
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/pdfmake.min.js" integrity="sha512-Yf733gmgLgGUo+VfWq4r5HAEaxftvuTes86bKvwTpqOY3oH0hHKtX/9FfKYUcpaxeBJxeXvcN4EY3J6fnmc9cA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/vfs_fonts.js" integrity="sha512-cktKDgjEiIkPVHYbn8bh/FEyYxmt4JDJJjOCu5/FQAkW4bc911XtKYValiyzBiJigjVEvrIAyQFEbRJZyDA1wQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <!-- Modals ------------------------->
    <?php include('../templates/modals/notification.php'); ?>
    <?php include('../templates/modals/profile_modal.php');?>
    <?php include("../templates/modals/data_entry_modal.php");?> 
    <?php include("../templates/modals/edit_modal.php");?> 
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
              <i class="fas fa-2x fa-sign-out-alt"></i>
          </button>
        </li>
       </form>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- SPC LOGO -->
      <?php
        $locimg = strtolower(str_replace(' ', '', $_SESSION['user_address'])).".jpg";
      ?>
      <a href="#" class="brand-link">
        <img src="../assets/img/<?php echo $locimg;?>" onerror="this.onerror=null;this.src='../assets/img/spc.png'" alt="Logo" width="100" style="margin-left:3.75rem;">
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
                        <embed id="myProfile" class="img-fluid card-img-top" src="data:<?php echo $type ;?>;base64,<?php echo base64_encode($img);?>">
                      <?php }else {  ?>
                        <img class="profileImg " src="../assets/img/account.png" alt="Profile" width="100" style="margin-left:3.75rem;">
                      <?php } ?>
              </p>
            </li>
            <li class="nav-item">
              <a href="./dashboard.php" class="nav-link">
                <i class="fas fa-columns fa-2x fa-white"></i>
                <p class="myFont">
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-book-medical fa-2x fa-white"></i>
                <p class="myFont">
                  Documents
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./graphs.php" class="nav-link">
                <i class="fa fa-flag fa-2x fa-white"></i>
                <p class="myFont">
                  Graphs
                </p>
              </a>
            </li>
            <li class="nav-item" data-toggle="modal" data-target="#notification">
              <a href="#" class="nav-link">
                <i class="fa fa-bell fa-2x fa-white"></i>
                <p class="myFont">
                  Alert
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./about.php" class="nav-link">
              &nbsp&nbsp<i class="fa fa-info fa-2x fa-white"></i>
                <p class="myFont">
                &nbsp About
                </p>
              </a>
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
              <h1>Documents</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="d-flex justify-content-between">
        <h2><input id="tableSearch" class="form-control name" type="text" placeholder="Search" aria-label="Search"> </h2>
          <div class="btn-group">
            <button class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#data-entry-modal"> 
                      Enter Data
            </button>
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Data Filter
            </button>
            <div class="dropdown-menu">
              <button id="Q1" onclick="q1()" class="dropdown-item otherForms">Q1</button>
              <button id="Q2" onclick="q2()" class="dropdown-item otherForms">Q2</button>
              <button id="Q3" onclick="q3()" class="dropdown-item otherForms">Q3</button>
              <button id="Q4" onclick="q4()" class="dropdown-item otherForms">Q4</button>
              <button id="currentYear()" onclick="currentYear()" class="dropdown-item otherForms">Current Year</button>
              <button id="currentYear" onclick="lastYear()" class="dropdown-item otherForms">Last Year</button>
              <button id="allYears()" onclick="showAll()" class="dropdown-item otherForms">Show All</button>
              <button id="recent" onclick="recent()" class="dropdown-item">Recently Deleted</button>
            </div>
          </div>
          <!-------------------------------->
          </div>
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <!--Main Area-->
          ` <div class="table-responsive"> 
            <table class="table table-fluid table-sm" id="dataTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Record ID</th>
                  <th>Name</th>
                  <th>Age</th>
                  <th>Gender</th>
                  <th>Type Of Illments</th>
                  <th>Date Contracted</th>
                  <th>Brgy. Address</th>
                  <th>Patient Status</th>
                  <th>Date Status</th>
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


    });

  </script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <!-- datatable -->
  <script type="text/javascript" src="../control/data_middle/data_middle.js"></script>
  <!-- overlayScrollbars -->
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
  <?php 
  include('../templates/modals/asset/pdfmake/graphs/graphsPDF.php');
  include('../templates/modals/asset/pdfmake/graphs/age_bracket.php');
  ?>
  <script src="../templates/modals/asset/pdfmake/pdf/pdfmake.js"></script>
  <script>
    $(document).ready(function(){  
      $('#logout2').click(function(){ $('#logout1').click() });
    });
  </script>
</body>
</html>