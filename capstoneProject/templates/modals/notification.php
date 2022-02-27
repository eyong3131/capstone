<?php 
    include('modal_query/notify.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal-Notification</title>
    <style>

    </style>
</head>
<body>
    <div class="modal fade " id="notification" tabindex="-1" role="dialog" aria-labelledby="notif" aria-hidden="true"  data-backdrop="false">
        <div class="modal-dialog" role="">
          <div class="modal-content">
            <div class="modal-header notifications">
              <h2 class="modal-title notifications" id="notif"> <i class="fa fa-exclamation-triangle"></i> Alert</h2>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
              <div id="notification" class="modal-body">
                <ul class="list-group list-group-flush ">
                  <li class="list-group-item"> 
                    <h2 class="">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </h2>
                      <?php echo $sentence;
                      ?>
                  </li>
                  <li class="list-group-item">
                    <h2 class="">
                      <i class="fas fa-eye fa-2x"></i>
                    </h2>
                    <?php echo $prediction_sentence; ?>
                  </li>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary"  onclick="download();">PDF</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
          </div>
        </div>
      </div>
      <div style="position:absolute;left:-9999px;top:-9999px;">
              <div>
                <h2 class="content-header">Charts</h2>
                <canvas class="w-100 chartjs-render-monitor" id="myChart4" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              <div>
                <h2 class="content-header">District 4 Brgy</h2>
                <canvas class="w-100 chartjs-render-monitor" id="myChart3" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              <div>
                <h2 class="content-header">Yearly Record</h2>
                <canvas class="w-100 chartjs-render-monitor" id="year" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              <div >
                <h2 class="content-header">Monthly Record</h2>
                <canvas class="w-100 chartjs-render-monitor" id="month" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              <div >
                <h2 class="content-header">Yearly Deceased</h2>
                <canvas class="w-100 chartjs-render-monitor" id="deceased_year" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
              <div >
                <h2 class="content-header">Monthly Deceased</h2>
                <canvas class="w-100 chartjs-render-monitor" id="deceased_month" width="5rem" height="3rem" style="display: block; width: 535px; height: 225px;"></canvas>
              </div>
        </div>
            <div id="districtPie" hidden></div>
            <div id="charts" hidden></div>
            <div id="yearPie" hidden></div>
            <div id="monthlyBrackets" hidden></div>
            <div id="deceasedYear" hidden></div>
            <div id="deceasedMonth" hidden></div>
</body>
</html>
<?php 
    //include('asset/pdfmake/graphs/graphs.php');
    
?>

             