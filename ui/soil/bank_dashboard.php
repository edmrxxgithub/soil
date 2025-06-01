<?php
// error_reporting(0);

include_once 'connectdb.php';
include_once 'function.php';
session_start();


if($_SESSION['userid']=="" )
{

header('location:../../index.php');

}


include_once "header.php";

$yearnow = $_GET['yearnow'];
$bankdashboard_data = fetch_bank_dashboard_data($pdo,$yearnow);

// $yearnow = date('Y');


for ($i=1; $i <= 12 ; $i++) 
{ 
 
  $monthnowf = date("M", strtotime("$yearnow-$i-01"));

  $days_in_a_month = date("t", strtotime("$yearnow-$i-01"));
  $monthnow = date("M", strtotime("$yearnow-$i-01"));
  $bankdataf = fetch_bank_deposit_withdraw_overall($pdo,$days_in_a_month,$i,$yearnow);

  $monthnowdata[] = $monthnowf;
  $monthdeposit[] = $bankdataf['totaldeposit'];
  $monthwithdraw[] = $bankdataf['totalwithdraw'];

  // echo $monthnowf.' '.$bankdataf['datefromto'].' '.$bankdataf['totaldeposit'].' '.$bankdataf['totalwithdraw'].'<br>';
  // echo $monthnowf.' = '.$bankdataf['datefromto'].' '.$bankdataf['totaldeposit'].' '.$bankdataf['totalwithdraw'].'<br>';

}

?>



<!-- ChartJS -->
<script src="../../plugins/chart.js/Chart.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Bank Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Starter Page</li> -->
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">

        <div class="row">

          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-white" >
              <div class="inner" style="background-color:rgba(50,63,81,255);">
                <h3 class="text-white"><?php echo $bankdashboard_data['totalbank'] ;?></h3>
                <p class="text-white">BANK ACCOUNTS</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>


          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-white" >
              <div class="inner" style="background-color:rgba(50,63,81,255);">
                <h3 class="text-white"><?php echo $bankdashboard_data['totalcheck'] ;?></h3>
                <p class="text-white">TOTAL CHECKS</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>


          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-white" >
              <div class="inner" style="background-color:rgba(12, 51, 21);">
                <h3 class="text-white"><?= number_format($bankdashboard_data['totaldeposit'],2) ?></h3>
                <p class="text-white">TOTAL DEPOSIT (<?= $bankdashboard_data['monthnow_word'] ?>)</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-white" >
              <div class="inner" style="background-color:rgba(120, 40, 31);">
                <h3 class="text-white"><?= number_format($bankdashboard_data['totelwithdraw'],2) ?></h3>
                <p class="text-white">TOTAL WITHDRAW (<?= $bankdashboard_data['monthnow_word'] ?>)</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>


          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="small-box bg-white" >
              <div class="inner" style="background-color:rgb(148,94,16);">
                <h3 class="text-white"><?= number_format($bankdashboard_data['overall_balance']) ?></h3>
                <p class="text-white">OVER-ALL BALANCE</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          
          
          
        </div>
        <!-- /.row -->


<div class="card card-grey card-outline">
      <div class="card-header" style="background-color:rgba(50,63,81,255);">
          <h5 class="m-0 text-white">Monthly Bank Statements</h5>
      </div>
      <div class="card-body">
        <div class="col-lg-12">
          <div class="row">


            <?php

            $selectbank = $pdo->prepare("SELECT * FROM tb_bank ");
            $selectbank->execute();
            while ($row = $selectbank->fetch(PDO::FETCH_OBJ)) 
            {

                $dayone_of_the_year = $yearnow.'-1-1';
                $lastmonth_number_of_days = date("t", strtotime("$yearnow-12-01"));
                $lastday_of_the_year = $yearnow.'-12-'.$lastmonth_number_of_days;

                // echo $dayone_of_the_year.' '.$lastday_of_the_year;

              $check_bank_data = fetch_bank_data_status($pdo,$dayone_of_the_year,$lastday_of_the_year,$row->id);

              if ($check_bank_data != '0') 
              {
                
              

            ?>

                <div class="col-sm-12 col-md-12 col-lg-6">
                  <table  border="1" width="100%">
                    <tr align="center">
                      <th colspan="6" style="background-color:rgba(12,25,60,255);"><font class="text-white"><?= $row->name ?></font></th>
                    </tr>
                    <tr align="center">
                      <td colspan="6" ><a href="bank_account_details.php?id=<?= $row->id ?>" target="_blank">Acct No. : <?= $row->account_num ?></td>
                    </tr>
                    <tr align="center">
                      <td>Date</td>
                      <td>Particulars</td>
                      <td>Debit</td>

                      <td>Date</td>
                      <td>Particulars</td>
                      <td>Credit</td>
                    </tr>

                      <?php

                      $total_deposit = 0;
                      $total_withdraw = 0;

                      for ($i=1; $i <= 12 ; $i++) 
                      {

                        $days_in_a_month = date("t", strtotime("$yearnow-$i-01"));
                        $monthnow = date("M", strtotime("$yearnow-$i-01"));
                        $bankdata = fetch_bank_deposit_withdraw($pdo,$days_in_a_month,$i,$yearnow,$row->id);

                        $depositf = $bankdata['deposit'];
                        $withdrawf = $bankdata['withdraw'];

                        $total_deposit += $bankdata['deposit'];
                        $total_withdraw += $bankdata['withdraw'];

                        if ($depositf != '') 
                        {
                          $particular_deposit = 'Various deposit';
                          $depositf = number_format($bankdata['deposit'],2);
                        }
                        else
                        { 
                          $particular_deposit = '';
                        }

                        if ($withdrawf != '') 
                        {
                          $particular_withdraw = 'Various drawings';
                          $withdrawf = number_format($bankdata['withdraw'],2);
                        }
                        else
                        { 
                          $particular_withdraw = '';
                        }

                    ?>

                    <tr align="center">
                      <td><font size="2"><?= $monthnow ?> <?= $yearnow ?></font></td>
                      <td><font size="2"><?= $particular_deposit ?></font></td>
                      <td><font size="2" class="text-success"><?= $depositf ?></font></td>

                      <td><font size="2"><?= $monthnow ?> <?= $yearnow ?></font></td>
                      <td><font size="2"><?= $particular_withdraw ?></font></td>
                      <td><font size="2" class="text-danger"><?= $withdrawf ?></font></td>
                    </tr>

                    <?php
                    $finalbalance = $total_deposit - $total_withdraw;

                      }
                    ?>

                    <tr align="center">
                      <td></td>
                      <td><font size="2" style="font-weight:bold;">TOTAL</font></td>
                      <td><font size="2" class="text-success" style="font-weight:bold"><?= number_format($total_deposit,2) ?></font></td>

                      <td></td>
                      <td><font size="2" style="font-weight:bold;">TOTAL</font></td>
                      <td><font size="2" class="text-danger" style="font-weight:bold"><?= number_format($total_withdraw,2) ?></font></td>
                    </tr>

                  </table>

                  <table border="0" width="100%">
                    <tr align="left">
                      <td>Balance&emsp;:&emsp;<font class="text-warning" style="font-weight:bold;"><?= number_format($finalbalance,2) ?></font></td>
                    </tr>
                  </table>

                  

                  <br><br>
                </div>

            <?php
              }
            }
            ?>

            

          </div>
          
        </div>
      </div>
</div>
<style>
    table tr:last-child td {
        border-bottom: none;
    }
</style>


<div class="card card-grey card-outline">
      <div class="card-header" style="background-color:rgba(50,63,81,255);">
          <h5 class="m-0 text-white">Current Year Data <?= $yearnow ?></h5>
      </div>
      <div class="card-body">
          <div class="chart">
            <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
      </div>
</div>









            
          </div>
     

       
        </div>
        <!-- /.col-md-6 -->



<div class="row">

    <div class="col-md-6"></div>
    <div class="col-md-6"></div>

</div>




      </div>
      <!-- /.row -->











    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php

include_once "footer.php";

//navy blue
// style="background-color:rgba(50,63,81,255);"

//maroon
// style="background-color:rgba(136,86,86,255);"

?>

<script>
  $(document).ready(function() {
    $('#table_recentorder').DataTable({

      "order":[[0,"desc"]]
    });
  });
</script>



<script>
  $(function () 
  {

    // var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = 
    {
      labels  : <?= json_encode($monthnowdata) ?>,
      datasets: 
      [
        {
          label               : 'Withdraw',
          backgroundColor     : 'rgba(136,86,86,255)',
          borderColor         : 'rgba(136,86,86,255)',
          pointRadius         : false,
          pointColor          : 'rgba(50,63,81,255)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : <?= json_encode($monthwithdraw) ?>
        },

        {
          label               : 'Deposit',
          backgroundColor     : 'rgba(50,63,81,255)',
          borderColor         : 'rgba(50,63,81,255)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(136,86,86,255)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : <?= json_encode($monthdeposit) ?>
        },

        
      ]
    }


    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })


  })
</script>