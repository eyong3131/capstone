<?php
    session_start();
    date_default_timezone_set('Asia/Manila');
    include('../../config/config.php');
    include('./script/script.php');
    //include('../../config/header_cdn.php');
    if(!isset($_SESSION['admin'])){
        header('Location: ../index.php');
        exit;
    } else {
        if(isset($_POST['logout'])){
          header('refresh:0');
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
      font-size:1rem !important;
      transition: none !important;
   }
   table.dataTable tbody tr td:nth-child(1):hover {
      background-color:#71d1eb !important;
      font-size:1.05rem;
      transition: 0.3s;
   }
   table.dataTable tr td:nth-child(2){
      width:70vw;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <!-- Modals ------------------------->
    <?php //include('add.php');?>
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
              <a href="./user_table.php" class="nav-link">
                <i class="fas fa-user-cog fa-2x fa-white"></i>
                <p class="myFont">
                  Users
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
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

      <!-- Main content -->
      <section class="content">
          <div class=" justify-content-between    ">
            <!--Main Area-->
            <div class="row">
                <!-----ItexMo---->
                <div class="col-md-5">
                  <h2 class="content-header">Itexmo Config</h2>
                  <form action="./script/apicode.php" method="POST">
                    <div class="form-group">
                        <label for="apiCode">API Code</label>
                        <input name="apicode" type="text" class="form-control form-control-lg" id="apiCode" aria-describedby="emailHelp" placeholder="<?php echo $itextmoapi[0]['apiCode']; ?>">
                        <small class="form-text text-muted">It is the user name provided by Itexmo</small>
                    </div>
                    <div class="form-group">
                        <label for="apiPassword">API Password</label>
                        <input name="apipassword" type="text" class="form-control form-control-lg" id="apiPassword" placeholder="<?php echo $itextmoapi[0]['apiPassword']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary" name="apiUpdate">Submit</button>
                  </form>
                </div>
                <!-------------------->
                <div class="col-md-1">
                </div>
                <!----Ilness Information Management-->
                <div class="col-md-5">
                  <h2 class="content-header">Illness Entry / Update</h2>
                  <form action="./script/illness_info.php" method="POST">
                    <div class="form-group">
                        <label for="illnessType">Illness Type</label>
                        <input id="illnessType" type="text" class="form-control form-control-lg"  aria-describedby="emailHelp" placeholder="Illness Type" name="illnessType">
                        <small class="form-text text-muted">New or Update Illness Information</small>
                    </div>
                    <div class="form-group">
                        <label for="ilnessAction">Actions</label>
                        <textarea id="ilnessAction" type="text" class="form-control"  placeholder="Actions when Case is High" name="illnessActions"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="illnessUpdate">Submit</button>
                  </form>
                </div>
                <!-------------------->
            </div>
            ` <div class="table-responsive"> 
                <h2 class="content-header">Illness Management</h2>
                        <table class="table table-fluid table-sm  table-bordered" id="dataTable" style="width:100%">
                        <thead>
                            <tr>
                            <th>Illness Type</th>
                            <th>Action</th>
                            <th>Command</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        for($i = 0;$i < count($config_table);$i++){
                        ?>
                            <tr>
                            <td><?php echo $config_table[$i]['type']; ?></td>
                            <td><?php echo $config_table[$i]['actions']; ?></td>
                            <td><button id="<?php echo $config_table[$i]['id']; ?>" class="del crud btn btn-sm btn-outline-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg></button></td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                        </table>
                    </div>
            <!-------------->            
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
    $(document).ready(function () {
      var dataTable = $('#dataTable').DataTable({
        pageLenght: 5,
        lengthMenu: [[5, 10, 20], [5, 10, 20]]
      });
      $('.dataTables_length').addClass('bs-select');
      $('#logout2').click(function(){ $('#logout1').click() });
      $('#dataTable tbody').delegate('tr td:nth-child(1)', 'click', function(){
        var dataIllness = dataTable.row(this).data();
        var illnessInput = dataIllness[0];
        var illnessAction = dataIllness[1]
        document.getElementById("illnessType").value = illnessInput;
        document.getElementById("ilnessAction").value = illnessAction;
      });
      $('#dataTable').on('click', '.del', function(){
        var del_id = $(this).attr('id');
        var warning = confirm("your trying to illness record #" + del_id +" this action cannot be reversed");
        if(warning == true){
            $.ajax({
                type:'POST',
                url:'./script/delete.php',
                data:{
                  delete_id:del_id
                },
                success: function(data){
                  window.location.reload();
                }
            });
        } 
    });
    });
  </script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <!-- datatable -->
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
