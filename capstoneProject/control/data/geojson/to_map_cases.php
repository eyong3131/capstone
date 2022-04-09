<?php
  include('../../../config/config.php');
?>
<?php
  //brgy listing
  $brgy_query = $connection->
  prepare("SELECT COUNT(*) AS count, patient_profile.address FROM patient_details
  LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
  WHERE MONTH(date) = MONTH(CURRENT_DATE())
  GROUP BY patient_profile.address");
  $brgy_query -> execute();
  $brgy_assoc = array();
  while($get_result = $brgy_query->fetch(PDO::FETCH_ASSOC)){
  $brgy_assoc += array($get_result['address'] => $get_result['count']);

  }
  echo json_encode($brgy_assoc);
  $connection = null;
?>

