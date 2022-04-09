<?php
  //graph query
  $graph_query = $connection->prepare("SELECT patient_details.illness,COUNT(*) as count 
                                        FROM `patient_details` 
                                        WHERE MONTH(date) = MONTH(CURRENT_DATE())
                                        GROUP BY illness 
                                        ORDER BY count DESC");
  $graph_query -> execute();
  $graph_assoc = array();
  while($get_result = $graph_query->fetch(PDO::FETCH_ASSOC)){
    $graph_assoc += array($get_result['illness'] => $get_result['count']);
  }
  //brgy listing
  $brgy_query = $connection->prepare("SELECT COUNT(*) AS count, patient_profile.address FROM patient_details
                                    LEFT JOIN `patient_profile` ON patient_details.P_id = patient_profile.id 
                                    WHERE MONTH(date) = MONTH(CURRENT_DATE())
                                    GROUP BY patient_profile.address");
  $brgy_query -> execute();
  $brgy_assoc = array();
  while($get_result = $brgy_query->fetch(PDO::FETCH_ASSOC)){
  $brgy_assoc += array($get_result['address'] => $get_result['count']);
  }
?>
<script>
  /*********Graphs Rank*************/
  var ctx4 = document.getElementById("myChart4");
  var myChart4 = new Chart(ctx4, {
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
        backgroundColor: ["#FF6384", "#FFCD56", "#FF9F40", "#36A2EB","yellow","#FF6384 ","red"],
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
      animation:{
        onComplete : function(){
          document.getElementById("charts").innerHTML = myChart4.toBase64Image();
          //document.getElementById("basetest").innerHTML = "<img id='districtIV'value='" + myChart1.toBase64Image() + "' />";
        }
    }
    }

  });
  /*******End Rank*********/
  /*********Viral Rank*************/
  const data_labels_PDF = [
    <?php 
                  asort($brgy_assoc);
                  foreach($brgy_assoc as $key => $value){
                    echo "\"$key\"" . "," ;
                  }
    ?>
  ];
  const data_value_PDF = [
    <?php
              foreach($brgy_assoc as $key => $value){
                echo "$value" . "," ;
              }  
    ?>
  ];

  const data_PDF= {
    labels: data_labels_PDF,
    datasets: [
      {
        label: 'Dataset',
        fillColor: "rgba(220,220,220,0.5)", 
        strokeColor: "rgba(220,220,220,0.8)", 
        highlightFill: "rgba(220,220,220,0.75)",
        highlightStroke: "rgba(220,220,220,1)",
        backgroundColor: ["#FF6384", "#FFCD56", "#FF9F40", "#36A2EB","blue","green","red"],
        data: data_value_PDF
      }
    ]
  };
  var ctx3 = document.getElementById("myChart3");
  var myChart3 = new Chart(ctx3, {
    type: 'pie',
    data: data_PDF,
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
    },
    animation:{
        onComplete : function(){
          document.getElementById("districtPie").innerHTML = myChart3.toBase64Image();
          //document.getElementById("basetest").innerHTML = "<img id='districtIV'value='" + myChart1.toBase64Image() + "' />";
        }
    }
  }
  });
  /*****End Rank********/
</script>
<?php
//ksort() -> key assending key sorting
//krsort() -> key decend key sort
//asort() -> value accending sort
//arsort() -> value reverse sort
?>