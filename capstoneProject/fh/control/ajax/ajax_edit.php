<?php
    session_start();
    include('../../../config/config.php');
    if(!isset($_SESSION['admin'])){
        header('Location: ../login.php');
        exit;
    }
    /******************************************************/
        try { 
            if(isset($_POST["details_id"])){
                $details_id = $_POST["details_id"];
                //$profile_id = $_POST["profile_id"];
                $p_id = ":p_id";
                $sql_edit    = "
                SELECT 
                users.user_id,
                users.name,
                users.middle,
                users.last,
                users.age,
                users.gender,
                users.address,
                users.email,
                users.time_joined,
                users.date_joined,
                users.user_status
                FROM users
                WHERE user_id = $p_id";
                $stmt_edit   = $connection->prepare($sql_edit);
                $result_edit = $stmt_edit->execute(array( $p_id => $details_id));
                $urow_edit   = $stmt_edit->fetch(PDO::FETCH_ASSOC);
                $response ="
                <div class='modal-body'>
                <div class='h-100 d-flex justify-content-center'>
                    <table class='lead form-group'>
                          <tr>
                          <td><label>Profile</label></td><td></td>
                          <td><input type='file' class='form-control-file form-control-lg' class='name' name='myfile'></td>
                          </tr>
                            <tr>
                                <td><label>Name</label></td> <td></td> 
                                <td class='input-group'>
                                  <input class=\"name \" type=\"text\" name=\"details_id\" value=" .$details_id ." hidden>
                                  <input required class='form-control form-control-lg' class='name ' type='text'  name='P_name' value='".$urow_edit['name']."'>
                                  <input required class='form-control form-control-lg' class='name ' type='text'  name='P_middle' value=".$urow_edit['middle']. ">
                                  <input required class='form-control form-control-lg' class='name ' type='text'  name='P_last' value='".$urow_edit['last']."'>
                                </td>
                            </tr>
                            <tr><td><label>Age</label></td> <td></td> 
                                <td><input required class='form-control form-control-lg' class='name age' type='text' name='P_age' value=".$urow_edit['age']." ></td>
                            </tr>
                            <tr><td><label>Username</label></td> <td></td> 
                            <td><input required class='name form-control form-control-lg' type='text' name='P_email'  value=".$urow_edit['email']." ></td>
                            </tr>
                            <tr><td><label>Password</label></td> <td></td> 
                            <td><input class='name form-control form-control-lg' type='password' name='P_password'></td>
                            </tr>
                            <tr> <td><label>Gender</label></td> <td></td>
                              <td>
                              <select name='P_gender' class='form-select form-control form-control-lg' aria-label='Default select example' required>
                                  <option value='".$urow_edit['gender']."' selected disable hidden >".$urow_edit['gender']."</option>
                                  <option value='Male'>Male</option>
                                  <option value='Female'>Female</option>
                                  <option value='Rather Not Say'>Rather Not Say</option>
                              </select>
                              </td>
                            </tr>
                            <tr><td><label>BRGY</label></td> <td></td> 
                                <td>
                                    <select  required class='form-select form-control form-control-lg' aria-label='Default select example' name='P_brgy'> 
                                    <option value='".$urow_edit['address']."' selected disable hidden>".$urow_edit['address']."</option>
                                    <option value='\"San Bartolome\"'>San Bartolome</option>
                                    <option value='Bautista'>Bautista</option>
                                    <option value=\"San Roque\">San Roque</option>
                                    <option value=\"Sta Monica\">Sta Monica</option>
                                    <option value=\"Sta Veronica\">Sta Veronica</option>
                                    <option value=\"Santiago I\">Santiago I</option>
                                    <option value=\"Santiago II\">Santiago II</option>
                                    </select>
                                </td>
                            </tr>
                    </table>
              </div>
                </div>
               ";
                ?>

             <?php echo $response;}?>
            <?php
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
        ?>
