<?php
    session_start();
    include('../../config/config.php');
    if(!isset($_SESSION['user'])){
        header('Location: ../login.php');
        exit;
    }
    /******************************************************/
        try { 
            if(isset($_POST["details_id"])){
                $details_id = $_POST["details_id"];
                $profile_id = $_POST["profile_id"];
                $p_id = ":p_id";
                $sql_edit    = "
                    SELECT 
                    pp.id,
                    pp.name AS name,
                    pp.middle AS middle,
                    pp.last AS last,
                    pp.address,
                    pp.age,
                    pp.gender,
                    pt.id AS details_id,
                    pt.illness AS illness,
                    pt.date AS date,
                    pt.status AS status,
                    pt.second_status AS second_status
                    FROM patient_profile AS pp
                        INNER JOIN 
                        patient_details as pt   
                        ON pp.id = pt.P_id 
                        WHERE pt.id = $p_id
                        GROUP BY pp.name, pp.middle,pp.last";
                $stmt_edit   = $connection->prepare($sql_edit);
                $result_edit = $stmt_edit->execute(array( $p_id => $details_id));
                $urow_edit   = $stmt_edit->fetch(PDO::FETCH_ASSOC);
                $response ="
                <div class='modal-body'>
                <div class='h-100 d-flex justify-content-center'>
                <table class='lead form-group'>
                        <tr>
                            <td><label>Name</label></td> <td> </td> 
                            <td class='input-group fullName'>
                              <input class=\"name \" type=\"text\" name=\"profile_id\" value='$profile_id' hidden>
                              <input class=\"name \" type=\"text\" name=\"details_id\" value=" .$details_id ." hidden>
                              <input class='form-control form-control-lg' class='name ' type='text'  name='P_name' value='" .$urow_edit['name'] ."' required>
                              <input class='form-control form-control-lg' class='name ' type='text' name='P_middle' value='" .$urow_edit['middle'] ."' required>
                              <input class='form-control form-control-lg' class='name ' type='text' name='P_last'value='" .$urow_edit['last'] ."' required>
                            </td>
                        </tr>
                        <tr><td><label>Age</label></td> <td> </td> 
                            <td><input class='form-control form-control-lg' class='age' type='number' name='P_age' value=" .$urow_edit['age'] ." required></td>
                        </tr>
                
                        <tr><td><label>Gender</label></td> <td> </td> 
                        <td>
                            <select class='form-select form-control form-control-lg' aria-label='Default select example' name='P_gender' required> 
                            <option value='".$urow_edit['gender']."' selected disable hidden>".$urow_edit['gender']."</option>
                            <option value='Male'>Male</option>
                            <option value='Female'>Female</option>
                            </select>
                        </td>
                        </tr>
                      
                        <tr><td><label>Disease</label></td> <td> </td> <td><input class='name form-control form-control-lg' type='text' name='P_illness' required value=" .$urow_edit['illness'] ."></td></tr>
                        <tr><td><label>Date</label></td> <td> </td> <td><input class='name form-control form-control-lg' type='date' name='P_date'value=" .$urow_edit['date']. " required></td></tr>
                        <tr><td><label>Optional</label><td> </td></td><td class='form-floating'><textarea class='name form-control form-control-lg ' placeholder='Recommended Action'  name='P_description' ></textarea></td></tr>
                        <tr><td><label>BRGY</label></td> <td> </td> 
                            <td>
                                <select class='form-select form-control form-control-lg' aria-label='Default select example' name='P_brgy' required> 
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
                        <tr><td><label>Status</label></td> <td> </td> 
                        <td>
                            <select name='P_status' class='form-select form-control form-control-lg' aria-label='Default select example'>
                              <option value='" .$urow_edit['status']. "' selected hidden>" .$urow_edit['status']. "</option>
                              <option value='Cured'>Cured</option>
                              <option value='Unwell'>Unwell</option>
                              <option value='Deceased'>Desceased</option>
                            </select>
                        </td>
                        </tr>
                        <tr><td><label>Date</label></td> <td> </td> 
                            <td>
                                <input class='form-control form-control-lg' type='date' name='P_status_date' value=" .$urow_edit['second_status']. " >   
                            </td>
                        </tr>
                        <tr><td></td></tr>
                </table>
              </div>
                </div>
               ";
                ?>
             <?php echo $response;}?>
            <?php
        } catch (PDOException $e) {
            exit("Error edit ajax: " . $e->getMessage());
        }
        ?>
