<?php
  /******************SQL statement connection*************************/
  include("../control/SQL/SQL_commands.php"); // original
  include("modal_query/suggest.php");
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
              <h2 class="modal-title" id="data-modal">Data Entry</h2>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="POST">
              <div class="modal-body">
              <div class="h-100 d-flex justify-content-center">
                <table id="data_entry_table" class="lead form-group">
                          <tr>
                              <td><label>Name</label></td> <td> </td> 
                              <td class='input-group fullName'>
                                <input id="name" class='form-control form-control-lg'  type='text'  name='P_name' placeholder="First" list="nameSuggest" required>
                                <input maxlength="1" id="middle" class='form-control form-control-lg'  type='text' name='P_middle' placeholder="Middle" >
                                <input id="last" class='form-control form-control-lg'  type='text' name='P_last' placeholder="Last" list="lastSuggest" required>
                              </td>
                          </tr>
                          <td><label>Age</label></td> <td> </td> 
                          <td><input id="age" class="form-control form-control-lg" class="age" type="number" name="P_age" placeholder="Age" required></td>
                        </tr>
                        <tr><td><label>Gender</label></td> <td> </td> 
                            <td>
                                <select id="gender" class="form-select form-control form-control-lg" aria-label="Default select example" name="P_gender" placeholder="Gender" required> 
                                <option value="" selected disabled hidden>Choose here</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                </select>
                            </td>
                        </tr
                        <tr><td><label>Disease</label></td> <td> </td> <td><input class="name form-control form-control-lg" type="text" name="P_illness" placeholder="Disease Type" list="diseaseSuggest" required></td></tr>
                        <tr><td><label>Date</label></td> <td> </td> <td><input class="name form-control form-control-lg" type="date" name="P_date" required></td></tr>
                        <tr><td><label>Optional</label><td> </td></td><td class="form-floating "><textarea class="name form-control form-control-lg " placeholder="Recommended Action"  name="P_description" ></textarea></td></tr>
                        <tr><td><label>BRGY</label></td> <td> </td> 
                            <td>
                                <select id="address" class="form-select form-control form-control-lg" aria-label="Default select example" name="P_brgy" required> 
                                <option value="" selected disabled hidden>Choose here</option>
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
                        <tr><td><label>Status</label></td> <td> </td> 
                        <td>
                            <select name="P_status" class="form-select form-control form-control-lg" aria-label="Default select example">
                              <option selected value="" hidden>Report Back</option>
                              <option value="Cured">Cured</option>
                              <option value="Unwell">Unwell</option>
                              <option value="Deceased">Desceased</option>
                            </select>
                        </td>
                        </tr>
                        <tr><td><label>Follow-up</label></td> <td> </td> 
                            <td>
                                <input class="form-control form-control-lg" type="date" name="P_status_date" >   
                            </td>
                        </tr>
                        <tr><td></td></tr>
                </table>
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

<datalist id="nameSuggest">
<?php 
for($i = 0;$i < count($input_name);$i++){
?>
  <option value="<?php echo $input_name[$i]['name'] ?>"> </option>
<?php
}
?>
</datalist>

<datalist id="lastSuggest">
<?php 
for($i = 0;$i < count($input_last);$i++){
?>
  <option value="<?php echo $input_last[$i]['last'] ?>"> </option>
<?php
}
?>
</datalist>

<datalist id="diseaseSuggest">
<?php 
for($i = 0;$i < count($diseases);$i++){
?>
  <option value="<?php echo $diseases[$i]['illness_type'] ?>"> </option>
<?php
}
?>
</datalist>
</body>

</html>