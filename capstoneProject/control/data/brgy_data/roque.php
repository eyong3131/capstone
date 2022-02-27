<?php
  //brgy listing
  $roque_query = 
  $connection->prepare("SELECT illness AS P_ILLNESS, COUNT(*) as count, patient_profile.address  
  FROM patient_details 
  LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
  WHERE MONTH(date)=MONTH(CURRENT_DATE()) AND
  YEAR(date)=YEAR(CURRENT_DATE()) AND patient_profile.address LIKE '%Roque'
  GROUP BY patient_details.illness 
  ORDER BY count DESC LIMIT 10");
  $roque_query -> execute();
  $roque_assoc = array();
  while($get_result = $roque_query->fetch(PDO::FETCH_ASSOC)){
  $roque_assoc += array($get_result['P_ILLNESS'] => $get_result['count']);
  }
?>

<script>
  /*********Graphs Rank*************/

  /*******End Rank*********/
  /*********Viral Rank*************/
  const roque_labels = [
    <?php 
                  asort($roque_assoc);
                  foreach($roque_assoc as $key => $value){
                    echo "\"$key\"" . "," ;
                  }
    ?>
  ];
  const roque_values = [
    <?php
              foreach($roque_assoc as $key => $value){
                echo "$value" . "," ;
              }  
    ?>
  ];

  const roque_data = {
    labels: roque_labels,
    datasets: [
      {
        label: "Monthly Disease",
        fillColor: "rgba(220,220,220,0.5)", 
        strokeColor: "rgba(220,220,220,0.8)", 
        highlightFill: "rgba(220,220,220,0.75)",
        highlightStroke: "rgba(220,220,220,1)",
        backgroundColor: ["#FF6384", "#FFCD56", "#FF9F40", "#36A2EB","#B0BF1A","#FF3956","#FF9560", "#C46210","#F19CBB","#3B7A57"],
        data: roque_values
      }
    ]
  };
  var roque1 = document.getElementById("roque1");
  var roqueChart = new Chart(roque1, {
    type: 'horizontalBar',
    data: roque_data,
    options: {
      scales: {
        xAxes: [{
                ticks: {
            		beginAtZero: true
                }
            }],
        yAxes: [{
          ticks: {
            stack:true
          }
        }]
      },
      legend: {
         display: false,
      }
    }
  });   
  /*****End Rank********/
  /**********************/
  <?php
  //brgy listing
  /********change virable name************** */
  $getMonth = getdate();
  $month = (int)$getMonth['mon'];
  $date_values = array();
  $death_values = array();
  $month_name = array(
     0 => "Jan",
     1 => "Feb",
     2 => "Mar",
     3 => "Apr",
     4 => "May",
     5 => "Jun",
     6 => "Jul",
     7 => "Aug",
     8 => "Sep",
     9 => "Oct",
     10 => "Nov",
     11 => "Dec"
  );
  $calendar = array();
  $calendar_death = array();
  for($i = 0; $i < $month; $i++){
    $calendar += array($month_name[$i] => 0);
    $calendar_death += array($month_name[$i] => 0);
  }
    $sql_sth = $connection->prepare("SELECT DATE_FORMAT(date,'%b') AS month,COUNT(*) as count, patient_profile.address
    FROM patient_details 
    LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
    WHERE MONTH(date) AND 
    YEAR(date)=YEAR(CURRENT_DATE()) AND patient_profile.address LIKE '%roque'
    GROUP BY YEAR(date), MONTH(date)
    ORDER BY YEAR(date), MONTH(date);");
    $sql_sth->execute();
      while($get_result = $sql_sth->fetch(PDO::FETCH_ASSOC)){
        $date_values += array($get_result['month'] => $get_result['count']);
      }
    $sql_sth->nextRowset();
    
    /*********monthly dead************ */
    $sql_sth = $connection->prepare("
    SELECT DATE_FORMAT(date,'%b') AS month,COUNT(*) as count, patient_profile.address
    FROM patient_details 
    LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
    WHERE MONTH(date) AND 
    YEAR(date)=YEAR(CURRENT_DATE()) AND patient_details.status = 'deceased' AND patient_profile.address LIKE '%roque'
    GROUP BY YEAR(date), MONTH(date)
    ORDER BY YEAR(date), MONTH(date);
    ");
    $sql_sth->execute();
      while($get_result = $sql_sth->fetch(PDO::FETCH_ASSOC)){
        $death_values += array($get_result['month'] => $get_result['count']);
      }
    $sql_sth->nextRowset();
    /********************************/
    $month_record = array_replace($calendar,$date_values);
    $month_death = array_replace($calendar_death,$death_values);
    //print_r($brgy_assoc);
    //print_r($brgy_assoc);
    //echo json_encode($brgy_assoc);
    ?>
    /**********change name************/
    const roque_month_labels = [
        <?php
              foreach($month_record as $key => $value){
                echo "\"$key\"" . "," ;
              }  
        ?>
    ];
    const roque_monthly_record = [
      <?php
            foreach($month_record as $key => $value){
              echo "\"$value\"" . "," ;
            }  
      ?>
    ];
    const roque_monthly_death = [
      <?php
            foreach($month_death as $key => $value){
              echo "\"$value\"" . "," ;
            }  
      ?>
    ];
    /********Change data*********/
    const roque_monthly_data = {
      labels: roque_month_labels,
      datasets: [ {
        label: "Monthly Records",
        data: roque_monthly_record,
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.1
      },
      {
        label: "Monthly Death Records",
        data: roque_monthly_death,
        fill: true,
        borderColor: 'red',
        //tension: 0.1
      }
    ]
    };
    /**********Change ID*****************/
    var roque2 = document.getElementById("roque2");
    var roque2Line = new Chart(roque2,{
      type: 'line',
      data: roque_monthly_data
    });
</script>
<?php
//ksort() -> key assending key sorting
//krsort() -> key decend key sort
//asort() -> value accending sort
//arsort() -> value reverse sort
?>