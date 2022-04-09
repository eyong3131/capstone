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
  <title>Graphs</title>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="crossorigin=""></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="../control/data/geojson/map.geojson"></script> 
  <link rel="stylesheet" href="../templates/style/style.css" />
  <link rel="stylesheet" href="../templates/style/mapstyle.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="crossorigin=""/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../templates/style/mapstyle.css" />
  <link rel="stylesheet" href="../assets/css/style.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->

 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/pdfmake.min.js" integrity="sha512-Yf733gmgLgGUo+VfWq4r5HAEaxftvuTes86bKvwTpqOY3oH0hHKtX/9FfKYUcpaxeBJxeXvcN4EY3J6fnmc9cA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/vfs_fonts.js" integrity="sha512-cktKDgjEiIkPVHYbn8bh/FEyYxmt4JDJJjOCu5/FQAkW4bc911XtKYValiyzBiJigjVEvrIAyQFEbRJZyDA1wQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!---Modals -->
    <?php include('../templates/modals/profile_modal.php'); ?>
    <?php include('../templates/modals/notification.php'); ?>
    <!--End Modal--->

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
              <a href="./documents.php" class="nav-link">
                <i class="fas fa-book-medical fa-2x fa-white"></i>
                <p class="myFont">
                  Documents
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
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
              <h1>Graphs</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
      <div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <!--Main Area-->
            <div id="map" class="w-100"style="width: 5rem; height: 20rem;"></div>
            </div>
            <div id="show-bartolome"class="brgy-area San-Bartolome">
              <div class="row">
              <div class="col-md-6">
              <h2>San Bartolome</h2>
              <canvas class="w-100 chartjs-render-monitor" id="bartolome1" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              <div class="col-md-6">
              <h2>San Bartolome</h2>
              <canvas class="w-100 chartjs-render-monitor" id="bartolome2" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              </div>
            </div>
            <div id="show-bautista" class="brgy-area Bautista">
              <div class="row">
              <div class="col-md-6">
              <h2>Bautista</h2>
              <canvas class="w-100 chartjs-render-monitor" id="bautista1" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              <div class="col-md-6">
              <h2>Bautista</h2>
              <canvas class="w-100 chartjs-render-monitor" id="bautista2" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              </div>
            </div>
            <div id="show-roque"class="brgy-area San-Roque">
              <div class="row">
              <div class="col-md-6">
              <h2>San Roque</h2>
              <canvas class="w-100 chartjs-render-monitor" id="roque1" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              <div class="col-md-6">
              <h2>San Roque</h2>
              <canvas class="w-100 chartjs-render-monitor" id="roque2" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              </div>
            </div>
            <div id="show-monica"class="brgy-area Sta-Monica">
              <div class="row">
              <div class="col-md-6">
              <h2>Sta Monica</h2>
              <canvas class="w-100 chartjs-render-monitor" id="monica1" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              <div class="col-md-6">
              <h2>Sta Monica</h2>
              <canvas class="w-100 chartjs-render-monitor" id="monica2" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              </div>
            </div>
            <div id="show-veronica"class="brgy-area">
              <div class="row">
              <div class="col-md-6">
              <h2>Sta Veronica</h2>
              <canvas class="w-100 chartjs-render-monitor" id="veronica1" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              <div class="col-md-6">
              <h2>Sta Veronica</h2>
              <canvas class="w-100 chartjs-render-monitor" id="veronica2" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              </div>
            </div>
            <div id="show-santiagoUno"class="brgy-area">
              <div class="row">
              <div class="col-md-6">
              <h2>Santiago I</h2>
              <canvas class="w-100 chartjs-render-monitor" id="santiagoUno1" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              <div class="col-md-6">
              <h2>Santiago I</h2>
              <canvas class="w-100 chartjs-render-monitor" id="santiagoUno2" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              </div>
            </div>
            <div id="show-santiagoDos"class="brgy-area San-Bartolome">
              <div class="row">
              <div class="col-md-6">
              <h2>Santiago II</h2>
              <canvas class="w-100 chartjs-render-monitor" id="santiagoDos1" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              <div class="col-md-6">
              <h2>Santiago II</h2>
              <canvas class="w-100 chartjs-render-monitor" id="santiagoDos2" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              </div>
            </div>
          </div>
      </section>
      <!-- /.content -->
      <footer class="main-footer">

      </footer>
    </div>
    <!-- /.content-wrapper -->
    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <?php }?>
  <?php
      include('../config/footer_cdn.php');
    ?>
    <?php 
    include('../control/data/brgy_data/bartolome.php');
    include('../control/data/brgy_data/bautista.php');
    include('../control/data/brgy_data/roque.php');
    include('../control/data/brgy_data/monica.php');
    include('../control/data/brgy_data/veronica.php');
    include('../control/data/brgy_data/santiago1.php');
    include('../control/data/brgy_data/santiago2.php');
    ?>
    <script src="../control/data/maps.js"></script>
  <!-- overlayScrollbars -->
  <!-- AdminLTE App -->
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>  
  <!--- others --->
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