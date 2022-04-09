<?php
  include('modal_query/profile_query.php');
  if($profile_urow['type'] != NULL || $profile_urow['img'] != NULL){
    $type = $profile_urow['type'];
    $img  = $profile_urow['img'];
  }
  $admin_address = $profile_urow['address'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Modal</title>
    <style>

    </style>
</head>
<body>
<form method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="profile" tabindex="-1" role="dialog" aria-labelledby="profile-modal" aria-hidden="true"  data-backdrop="false">
        <div class="modal-dialog modal-md" role="">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title " id="profile-modal">Profile</h1>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="card">
              <?php 
              if($profile_urow['type'] != NULL && $profile_urow['img'] != NULL){
              ?>
              <i>&nbsp &nbsp &nbsp &nbsp &nbsp </i>
              <embed class="img-fluid card-img-top" src="data:<?php echo $type ;?>;base64,<?php echo base64_encode($img);?>" alt="Profile" width="100%">
              <?php }else {  ?>
              <img src="assets/img/account.png" alt="Profile" width="100%">
              <?php }?> 
              <h1><?php echo $profile_urow['email'];?></h1>
              <p><?php echo strtoupper($profile_urow['address']); ?></p>
              <input id="uploadFile" placeholder="Choose File" disabled="disabled" />
              <div class="fileUpload btn btn-primary">
                  <span>Upload</span>
                  <input id="uploadBtn" type="file" class="upload" name="myfile"/>
              </div>
              <input class="form-control form-control-lg" type="text" placeholder="Brgy Number to Notify" name="contactNumber">
          
          </div>
          
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="updateProfile">Update Picture</button>
            </div>
          </div>
        </div>
      </div>
      </form>
    <?php
    if(isset($_POST['updateProfile'])){
        if(file_exists($_FILES['myfile']['tmp_name'])){
            $fileName = $_FILES['myfile']['name'];
            $type = $_FILES['myfile']['type'];
            $data = file_get_contents($_FILES['myfile']['tmp_name']);
          }
          $contactNumber = $_POST['contactNumber'];
          $contactSth;
          $profileImg;
          if(isset($_POST['contactNumber'])){
            $contactSth = "`contact` = ?";
          }else{
            $contactNumber ="";
          }
          if(file_exists($_FILES['myfile']['tmp_name'])){
            $profileImg = ",`fileName`=?,`type`=?,`img`=? ";
          }else{
            $profileImg = "";
          }
          $sth = $connection->prepare("
          UPDATE `admin` 
          SET
          $contactSth
          $profileImg
          WHERE user_id = ?
          ");

          if(isset($_POST['contactNumber'])){
            $sth->bindParam(1,$contactNumber);
          }
          if(file_exists($_FILES['myfile']['tmp_name']) == NULL){
            $sth->bindParam(2,$_SESSION['admin']);
          }
          if(file_exists($_FILES['myfile']['tmp_name'])){
            $sth->bindParam(2,$fileName);
            $sth->bindParam(3,$type);
            $sth->bindParam(4,$data);
            $sth->bindParam(5,$_SESSION['admin']);
          }
          if(!isset($_POST['contactNumber'])){
            $sth->bindParam(1,$fileName);
            $sth->bindParam(2,$type);
            $sth->bindParam(3,$data);
            $sth->bindParam(4,$_SESSION['admin']);
          }
          try{
            $sth->execute();
          }catch(Exception $e){
            //echo "<script>console.log('". $e ."')</script>";
          }
          
          $sth->nextRowset();
    }
    ?>
    <script>
      document.getElementById("uploadBtn").onchange = function () {
      document.getElementById("uploadFile").value = this.value;
      };
    </script>
</body>
</html>