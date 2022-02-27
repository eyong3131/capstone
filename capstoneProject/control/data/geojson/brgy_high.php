<?php
  include('../../../config/config.php');
?>
<?php
  //brgy listing
  $brgy = ["Sta Monica","Sta Veronica","San Bartolome","San Roque","Santiago I","Santiago II","Bautista"];
  $highest_diseases = array();

  for($i = 0; $i < count($brgy); $i++){
    $sth = $connection->
    prepare("SELECT COUNT(*) AS count,patient_details.illness,patient_profile.address FROM patient_details 
    LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
    WHERE MONTH(date) = MONTH(CURRENT_DATE()) AND patient_profile.address LIKE '%".$brgy[$i]."'
    GROUP BY patient_details.illness
    ORDER BY COUNT(*) DESC LIMIT 1;
    ");
    $sth -> execute();
    $get_result = $sth->fetch(PDO::FETCH_ASSOC);
    if($get_result['address'] != NULL){
      $highest_diseases += array(
        $i => array(
          "address" =>  $get_result['address'],
          "illness" => $get_result['illness'],
          "count" => $get_result['count']
          )
      );
    }else{
      $highest_diseases += array(
        $i => array(
          "address" => $brgy[$i],
          "illness" => "None",
          "count" => "0"
          )
      );
    }
    $sth->nextRowset();
  }
  //echo json_encode($final);
  //$final = array($highest_diseases);
  //print_r($highest_diseases);
  //echo json_encode($final);
  echo json_encode($highest_diseases);
  $connection = null;
?>