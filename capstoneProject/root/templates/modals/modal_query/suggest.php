<?php
/** Disease Suggestion */
  $sth=$connection->prepare("SELECT DISTINCT illness_desc.illness_type FROM `illness_desc` LIMIT 20");
  $sth->execute();
  $diseases = $sth->fetchAll(PDO::FETCH_ASSOC);
  $sth->nextRowset();
  /** Name Suggestion */
  $sth=$connection->prepare("SELECT DISTINCT patient_profile.name FROM `patient_profile`  LIMIT 20");
  $sth->execute();
  $input_name = $sth->fetchAll(PDO::FETCH_ASSOC);
  $sth->nextRowset();
  /** Last Name Suggestion */
  $sth=$connection->prepare("SELECT DISTINCT patient_profile.last FROM `patient_profile`  LIMIT 20");
  $sth->execute();
  $input_last = $sth->fetchAll(PDO::FETCH_ASSOC);
  $sth->nextRowset();
?>