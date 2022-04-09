<?php
  /******************SQL statement connection*************************/
  //include("../control/SQL/SQL_commands.php"); // original
  //include('SQL_commands.php'); //test 
  include('../control/SQL/SQL_commands.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal-Data-entry</title>
</head>
<body>
    <div class="modal fade" id="data-entry-modal" tabindex="-1" role="dialog" aria-labelledby="data-modal" aria-hidden="true"  data-backdrop="false">
        <div class="modal-dialog modal-lg" role="">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title" id="data-modal">User Entry</h1>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
              <div class="modal-body">
              <div class="h-100 d-flex justify-content-center">
                <div class="jumbotron my-auto ">
                    <table class="lead form-group">
                            <tr>
                              <td><label>Profile</label></td><td></td>
                              <td><input type="file" class="form-control-file form-control-lg" class="name " name="myfile"></td>
                            </tr>
                            <tr>
                                <td><label>Name</label></td> <td></td> 
                                <td class="input-group fullName">
                                    <input class="form-control form-control-lg" class="name " type="text" placeholder="First Name" name="P_name" required>
                                    <input class="form-control form-control-lg" class="name " type="text" placeholder="Middle Name" name="P_middle" required>
                                    <input class="form-control form-control-lg" class="name " type="text" placeholder="Last Name"name="P_last" required>
                                </td>
                            </tr>
                            <tr><td><label>Age</label></td> <td></td> 
                                <td><input class="form-control form-control-lg" lass="name age" type="text" placeholder="Age" name="P_age" ></td>
                            </tr>
                            <tr><td><label>Username</label></td> <td></td> 
                                <td><input class="form-control form-control-lg" lass="name age" type="text" placeholder="Username" name="P_email" ></td>
                            </tr>
                            <tr><td><label>Password</label></td> <td></td> 
                                <td><input class="form-control form-control-lg" lass="name age" type="password" placeholder="Password" name="P_password" ></td>
                            </tr>
                            <tr>
                              <td><label>Gender</label></td> <td></td>
                              <td>
                                <select name="P_gender" class="form-select form-control form-control-lg" aria-label="Default select example" required>
                                  <option  selected disabled hidden>Gender</option>
                                  <option value="Male">Male</option>
                                  <option value="Female">Female</option>
                                  <option value="Rather Not Say">Rather Not Say</option>
                                </select>
                              </td>
                            </tr>
                            <tr><td><label>BRGY</label></td> <td></td> 
                                <td>
                                    <select class="form-select form-control form-control-lg" aria-label="Default select example" name="P_brgy" required> 
                                    <option selected disabled hidden>Baranggay</option>
                                    <option value="San Bartolome">San Bartolome</option>
                                    <option value="Bautista">Bautista</option>
                                    <option value="San Roque">San Roque</option>
                                    <option value="Sta Monica">Sta Monica</option>
                                    <option value="Sta Veronica">Sta Veronica</option>
                                    <option value="Santiago I">Santiago I</option>
                                    <option value="Santiago II">Santiago II</option>
                                    </select>
                                </td>
                            </tr>
                            <tr><td></td></tr>
                    </table>
                </div>
            </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="saveData" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
</body>
</html>