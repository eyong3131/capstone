<?php
  //graph query
  $graph_query = $connection->prepare("SELECT patient_details.illness,COUNT(*) as count 
                                        FROM `patient_details` 
                                        WHERE MONTH(date) = MONTH(CURRENT_DATE())
                                        GROUP BY illness 
                                        ORDER BY count DESC LIMIT 10");
  $graph_query -> execute();
  $graph_assoc = array();
  while($get_result = $graph_query->fetch(PDO::FETCH_ASSOC)){
    $graph_assoc += array($get_result['illness'] => $get_result['count']);
  }
  //brgy listing
  $brgy_query = $connection->prepare("SELECT COUNT(*) AS count, patient_profile.address FROM patient_details
                                    LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
                                    WHERE MONTH(date) = MONTH(CURRENT_DATE())
                                    GROUP BY patient_profile.address ORDER BY COUNT(*) DESC");
  $brgy_query -> execute();
  $brgy_assoc = array();
  while($get_result = $brgy_query->fetch(PDO::FETCH_ASSOC)){
  $brgy_assoc += array($get_result['address'] => $get_result['count']);
  }
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script>
  /*********Graphs Rank*************/
  var ctx2 = document.getElementById("myChart2");
  var myChart2 = new Chart(ctx2, {
    type: 'horizontalBar',
    data: {
      labels: [
        <?php
          asort($graph_assoc);
          foreach($graph_assoc as $key => $value){
            echo "\"$key\"" . "," ;
          }
        ?>
      ],
      datasets: [{
        data: [
          <?php
          foreach($graph_assoc as $key => $value){
            echo "$value" . "," ;
          }
        ?>
        ],
        backgroundColor: ["#FF6384", "#FFCD56", "#FF9F40", "#36A2EB","#B0BF1A","#FF3956","#FF9560", "#C46210","#F19CBB","#3B7A57"]
      }]
    },
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
      },
    }
  });
  /*******End Rank*********/
  /*********Viral Rank*************/
  const data_labels = [
    <?php 
                  asort($brgy_assoc);
                  foreach($brgy_assoc as $key => $value){
                    echo "\"$key\"" . "," ;
                  }
    ?>
  ];
  const data_value = [
    <?php
              foreach($brgy_assoc as $key => $value){
                echo "$value" . "," ;
              }  
    ?>
  ];

  const data = {
    labels: data_labels,
    datasets: [
      {
        label: 'Dataset',
        fillColor: "rgba(220,220,220,0.5)", 
        strokeColor: "rgba(220,220,220,0.8)", 
        highlightFill: "rgba(220,220,220,0.75)",
        highlightStroke: "rgba(220,220,220,1)",
        backgroundColor: ["#FF6384", "#FFCD56", "#FF9F40", "#36A2EB","#B0BF1A","#FF3956","#FF9560", "#C46210","#F19CBB","#3B7A57"],
        data: data_value
      }
    ]
  };
  var ctx1 = document.getElementById("myChart1");
  var myChart1 = new Chart(ctx1, {
    type: 'pie',
    data: data,
    options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Chart.js Pie Chart'
      }
    }
  },
  });
  /*****End Rank********/
</script>
<?php
//ksort() -> key assending key sorting
//krsort() -> key decend key sort
//asort() -> value accending sort
//arsort() -> value reverse sort
?>