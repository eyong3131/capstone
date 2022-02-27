<?php
  //brgy listing
  $bartolome_query = 
  $connection->prepare("SELECT illness AS P_ILLNESS, COUNT(*) as count, patient_profile.address  
  FROM patient_details 
  LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
  WHERE MONTH(date)=MONTH(CURRENT_DATE()) AND
  YEAR(date)=YEAR(CURRENT_DATE()) AND patient_profile.address LIKE '%bartolome'
  GROUP BY patient_details.illness 
  ORDER BY count DESC LIMIT 10");
  $bartolome_query -> execute();
  $bartolome_assoc = array();
  while($get_result = $bartolome_query->fetch(PDO::FETCH_ASSOC)){
  $bartolome_assoc += array($get_result['P_ILLNESS'] => $get_result['count']);
  }
  $bartolome_query -> nextRowset();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script>
  /*********Graphs Rank*************/

  /*******End Rank*********/
  /*********Viral Rank*************/
  const bartolome_label = [
    <?php 
                  asort($bartolome_assoc);
                  foreach($bartolome_assoc as $key => $value){
                    echo "\"$key\"" . "," ;
                  }
    ?>
  ];
  const bartolome_values = [
    <?php
              foreach($bartolome_assoc as $key => $value){
                echo "$value" . "," ;
              }  
    ?>
  ];

  const bartolome_data = {
    labels: bartolome_label,
    datasets: [
      {
        label: "Monthly Viral Disease",
        fillColor: "rgba(220,220,220,0.5)", 
        strokeColor: "rgba(220,220,220,0.8)", 
        highlightFill: "rgba(220,220,220,0.75)",
        highlightStroke: "rgba(220,220,220,1)",
        backgroundColor: ["#FF6384", "#FFCD56", "#FF9F40", "#36A2EB","#B0BF1A","#FF3956","#FF9560", "#C46210","#F19CBB","#3B7A57"],
        data: bartolome_values
      }
    ]
  };
  var bartolome1 = document.getElementById("bartolome1");
  var bartolomeChart = new Chart(bartolome1, {
    type: 'horizontalBar',
    data: bartolome_data,
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

  /******Line Chart****/
  <?php
  //brgy listing
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
    YEAR(date)=YEAR(CURRENT_DATE()) AND patient_profile.address LIKE '%bartolome'
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
    YEAR(date)=YEAR(CURRENT_DATE()) AND patient_details.status = 'deceased' AND patient_profile.address LIKE '%bartolome'
    GROUP BY YEAR(date), MONTH(date)
    ORDER BY YEAR(date), MONTH(date);
    ");
    $sql_sth->execute();
      while($get_result = $sql_sth->fetch(PDO::FETCH_ASSOC)){
        $death_values += array($get_result['month'] => $get_result['count']);
      }
    $sql_sth->nextRowset();
    /********************************/
    $bartolome_monthly = array_replace($calendar,$date_values);
    $bartolome_death = array_replace($calendar_death,$death_values);

    ?>
    const month_labels = [
        <?php
              foreach($bartolome_monthly as $key => $value){
                echo "\"$key\"" . "," ;
              }  
        ?>
    ];
    const monthly_record = [
      <?php
            foreach($bartolome_monthly as $key => $value){
              echo "\"$value\"" . "," ;
            }  
      ?>
    ];
    const monthly_death = [
      <?php
            foreach($bartolome_death as $key => $value){
              echo "\"$value\"" . "," ;
            }  
      ?>
    ];
    const monthly_data = {
      labels: month_labels,
      datasets: [ {
        label: "Monthly Records",
        data: monthly_record,
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.1
      },
      {
        label: "Monthly Death Records",
        data: monthly_death,
        fill: true,
        borderColor: 'red',
        //tension: 0.1
      }
    ]
    };
    var bartolome2 = document.getElementById("bartolome2");
    var bartolomeLine = new Chart(bartolome2,{
      type: 'line',
      data: monthly_data
    });
  /********************/
</script>
<?php
//ksort() -> key assending key sorting
//krsort() -> key decend key sort
//asort() -> value accending sort
//arsort() -> value reverse sort
?>