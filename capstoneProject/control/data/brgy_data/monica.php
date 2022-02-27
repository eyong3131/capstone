<?php
  //brgy listing
  $monica_query = 
  $connection->prepare("SELECT illness AS P_ILLNESS, COUNT(*) as count, patient_profile.address  
  FROM patient_details 
  LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
  WHERE MONTH(date)=MONTH(CURRENT_DATE()) AND
  YEAR(date)=YEAR(CURRENT_DATE()) AND patient_profile.address LIKE '%Sta Monica'
  GROUP BY patient_details.illness 
  ORDER BY count DESC LIMIT 10");
  $monica_query -> execute();
  $monica_assoc = array();
  while($get_result = $monica_query->fetch(PDO::FETCH_ASSOC)){
  $monica_assoc += array($get_result['P_ILLNESS'] => $get_result['count']);
  }
  $monica_query -> nextRowset();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script>
  /*********Graphs Rank*************/

  /*******End Rank*********/
  /*********Viral Rank*************/
  const monica_labels = [
    <?php 
                  asort($monica_assoc);
                  foreach($monica_assoc as $key => $value){
                    echo "\"$key\"" . "," ;
                  }
    ?>
  ];
  const monica_values = [
    <?php
              foreach($monica_assoc as $key => $value){
                echo "$value" . "," ;
              }  
    ?>
  ];

  const monica_data = {
    labels: monica_labels,
    datasets: [
      {
        label: "This Month",
        data: monica_values,
        fillColor: "rgba(220,220,220,0.5)", 
        strokeColor: "rgba(220,220,220,0.8)", 
        highlightFill: "rgba(220,220,220,0.75)",
        highlightStroke: "rgba(220,220,220,1)",
        backgroundColor: ["#FF6384", "#FFCD56", "#FF9F40", "#36A2EB","#B0BF1A","#FF3956","#FF9560", "#C46210","#F19CBB","#3B7A57"],
        
      }
    ]
  };
  var monica1 = document.getElementById("monica1");
  var monica1Chart = new Chart(monica1, {
    type: 'horizontalBar',
    data: monica_data,
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
  $monica_date_values = array();
  $monica_death_values = array();
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
  /*********monthly positive****************** */
    $sql_sth = $connection->prepare("SELECT DATE_FORMAT(date,'%b') AS month,COUNT(*) as count, patient_profile.address
    FROM patient_details 
    LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
    WHERE MONTH(date) AND 
    YEAR(date)=YEAR(CURRENT_DATE()) AND patient_profile.address LIKE '%sta monica'
    GROUP BY YEAR(date), MONTH(date)
    ORDER BY YEAR(date), MONTH(date);");
    $sql_sth->execute();
      while($get_result = $sql_sth->fetch(PDO::FETCH_ASSOC)){
        $monica_date_values += array($get_result['month'] => $get_result['count']);
      }
    $sql_sth->nextRowset();
    /*********monthly dead************ */
    $sql_sth = $connection->prepare("
    SELECT DATE_FORMAT(date,'%b') AS month,COUNT(*) as count, patient_profile.address
    FROM patient_details 
    LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
    WHERE MONTH(date) AND 
    YEAR(date)=YEAR(CURRENT_DATE()) AND patient_details.status = 'deceased' AND patient_profile.address LIKE '%Sta Monica'
    GROUP BY YEAR(date), MONTH(date)
    ORDER BY YEAR(date), MONTH(date);
    ");
    $sql_sth->execute();
      while($get_result = $sql_sth->fetch(PDO::FETCH_ASSOC)){
        $monica_death_values += array($get_result['month'] => $get_result['count']);
      }
    $sql_sth->nextRowset();
    /********************************/
    $monica_monthly = array_replace($calendar,$monica_date_values);
    $monica_death = array_replace($calendar_death,$monica_death_values);
    //print_r($brgy_assoc);
    //print_r($brgy_assoc);
    //echo json_encode($brgy_assoc);
    ?>
    /**********change name************/
    const monica_month_labels = [
        <?php
              foreach($monica_monthly as $key => $value){
                echo "\"$key\"" . "," ;
              }  
        ?>
    ];
    const monica_monthly_record = [
      <?php
            foreach($monica_monthly as $key => $value){
              echo "\"$value\"" . "," ;
            }  
      ?>
    ];
    const monica_monthly_death = [
      <?php
            foreach($monica_death as $key => $value){
              echo "\"$value\"" . "," ;
            }  
      ?>
    ];
    /********Change data*********/
    const monica_monthly_data = {
      labels: monica_month_labels,
      datasets: [ {
        label: "Monthly Records",
        data: monica_monthly_record,
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        //tension: 0.1
      },
      {
        label: "Monthly Death Records",
        data: monica_monthly_death,
        fill: true,
        borderColor: 'red',
        //tension: 0.1
      }
    ]
    };
    /**********Change ID*****************/
    var monica2 = document.getElementById("monica2");
    var monicaLine = new Chart(monica2,{
      type: 'line',
      data: monica_monthly_data,
      
    });
</script>
<?php
//ksort() -> key assending key sorting
//krsort() -> key decend key sort
//asort() -> value accending sort
//arsort() -> value reverse sort
?>