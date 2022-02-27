<?php
  include('modal_query/profile_query.php');
  if($profile_urow['type'] != NULL && $profile_urow['img'] != NULL){
    $type = $profile_urow['type'];
    $img  = $profile_urow['img'];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Modal</title>
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
              <img src="../assets/img/account.png" alt="Profile" width="100%">
              <?php }?> 
              <h1><?php echo $profile_urow['email'];?></h1>
              <p><?php echo strtoupper($profile_urow['address']); ?></p>
              <input id="uploadFile" placeholder="Choose File" disabled="disabled" />
              <div class="fileUpload btn btn-primary">
                  <span>Upload</span>
                  <input id="uploadBtn" type="file" class="upload" name="myProfile"/>
              </div>
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
    <script>
      document.getElementById("uploadBtn").onchange = function () {
      document.getElementById("uploadFile").value = this.value;
      };
    </script>
</body>
</html>