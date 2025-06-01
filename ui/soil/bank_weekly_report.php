<?php
error_reporting(0);
include_once 'connectdb.php';
include_once 'function.php';
session_start();

      $json_date = [];
      $json_withdraw = [];
      $json_deposit = [];

if($_SESSION['userid']=="" )
{

header('location:../../index.php');

}
else
{
  $id = $_SESSION['userid'];
}


include_once "header.php";


function fill_bank($pdo)
{

    $output='';
    $select=$pdo->prepare("SELECT * FROM tb_bank order by id asc");
    $select->execute();
    $result=$select->fetchAll();
    foreach($result as $row)
    {
        $output.='<option value="'.$row["id"].'">'.$row["name"].' ('.$row['account_num'].')</option>';
    }

    return $output; 

}


      $bankid = $_POST['bankid'];
      $select5 = $pdo->prepare("SELECT * FROM tb_bank WHERE id = '$bankid' ");
      $select5->execute();
      $row5 = $select5->fetch(PDO::FETCH_OBJ);

      $bankname_accountnum = $row5->name.' '.$row5->account_num;

      $yearnow = date('Y');


// $month_data = strtotime()


$monthNumber = $_POST['month'];
$monthName = date("F", mktime(0, 0, 0, $monthNumber, 1));




?>

 <!-- daterange picker -->
 <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">

  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Bank Weekly Report</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Starter Page</li> -->
          </ol>
        </div>
        <!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->




  <!-- Main content -->
  <div class="content">
  <!-- container fluid open --> 
    <div class="container-fluid">
      <!-- row open --> 
      <div class="row">
        <!-- col md 12 open --> 
        <div class="col-md-12">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Bank/Account No. : <font style="font-weight:bold;" ><?php echo $bankname_accountnum ?> </font></h5>
                    <h5 class="m-0">Date : <font style="font-weight:bold;" ><?= $monthName ?> - <?= $_POST['year'] ?></font></h5>
                </div>
                <!-- card body open --> 

                <!-- FORM OPEN -->
                <form action="" method="post">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">

                           <div class="col-md-4">
                            <div class="form-group">
                              <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="bankid">
                                    <option value="" disabled selected>Select bank</option><?php echo fill_bank($pdo);?>
                              </select>
                            </div>
                          </div>   
                          

                          <div class="col-md-3">
                            <div class="form-group">
                                <!-- <label for="month">Select a Month:</label> -->
                                    <select class="form-control select3" name="month">
                                        <option value="" disabled selected>Select month</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                            <!-- <b>Select year </b>&emsp; -->
                            <input type="number" class="form-control" value="<?= $yearnow ?>" autocomplete="off" name="year" >
                          </div>
                          </div>

                          <div class="col-md-2">  
                              <div class="text-center">
                                  <button type="submit" class="btn btn-warning" name="btnfilter">Filter Records</button>
                              </div>
                          </div>

                  </div>


<?php

$month = $_POST['month'];
$year = $_POST['year'];


$days_in_a_month = date("t", strtotime("$year-$month-01"));


$datefrom = $year.'-'.$month.'-01';
$dateto = $year.'-'.$month.'-'.$days_in_a_month;

$week1_from = $year.'-'.$month.'-01';
$week1_to = $year.'-'.$month.'-07';


$week2_from = $year.'-'.$month.'-08';
$week2_to = $year.'-'.$month.'-14';

$week3_from = $year.'-'.$month.'-15';
$week3_to = $year.'-'.$month.'-21';

$week3_from = $year.'-'.$month.'-15';
$week3_to = $year.'-'.$month.'-21';

$week4_from = $year.'-'.$month.'-22';
$week4_to = $year.'-'.$month.'-'.$days_in_a_month;

// echo $week4_from.' '.$week4_to;
// echo '<br>';

$sql1 = $pdo->prepare("SELECT * FROM tb_check WHERE bank_id = '$bankid' AND check_date BETWEEN '$datefrom' AND '$dateto' ");
$sql1->execute();
$totalchecks = $sql1->rowCount();




// week 1 deposit
$sql2 = $pdo->prepare("SELECT SUM(amount) as amount FROM tb_deposit WHERE bank_id = '$bankid' AND date BETWEEN '$week1_from' AND '$week1_to' ");
$sql2->execute();
$row2 = $sql2->fetch(PDO::FETCH_OBJ);
$week1_deposit = $row2->amount;

// week 1 withdraw
$sql3 = $pdo->prepare("SELECT SUM(amount) as amount FROM tb_check WHERE bank_id = '$bankid' AND check_date BETWEEN '$week1_from' AND '$week1_to' ");
$sql3->execute();
$row3 = $sql3->fetch(PDO::FETCH_OBJ);
$week1_withdraw = $row3->amount;

// echo $week1_deposit.' '.$week1_withdraw;




// week 2 deposit
$sql2 = $pdo->prepare("SELECT SUM(amount) as amount FROM tb_deposit WHERE bank_id = '$bankid' AND date BETWEEN '$week2_from' AND '$week2_to' ");
$sql2->execute();
$row2 = $sql2->fetch(PDO::FETCH_OBJ);
$week2_deposit = $row2->amount;

// week 2 withdraw
$sql3 = $pdo->prepare("SELECT SUM(amount) as amount FROM tb_check WHERE bank_id = '$bankid' AND check_date BETWEEN '$week2_from' AND '$week2_to' ");
$sql3->execute();
$row3 = $sql3->fetch(PDO::FETCH_OBJ);
$week2_withdraw = $row3->amount;



// week 3 deposit
$sql2 = $pdo->prepare("SELECT SUM(amount) as amount FROM tb_deposit WHERE bank_id = '$bankid' AND date BETWEEN '$week3_from' AND '$week3_to' ");
$sql2->execute();
$row2 = $sql2->fetch(PDO::FETCH_OBJ);
$week3_deposit = $row2->amount;

// week 3 withdraw
$sql3 = $pdo->prepare("SELECT SUM(amount) as amount FROM tb_check WHERE bank_id = '$bankid' AND check_date BETWEEN '$week3_from' AND '$week3_to' ");
$sql3->execute();
$row3 = $sql3->fetch(PDO::FETCH_OBJ);
$week3_withdraw = $row3->amount;



// week 4 deposit
$sql2 = $pdo->prepare("SELECT SUM(amount) as amount FROM tb_deposit WHERE bank_id = '$bankid' AND date BETWEEN '$week4_from' AND '$week4_to' ");
$sql2->execute();
$row2 = $sql2->fetch(PDO::FETCH_OBJ);
$week4_deposit = $row2->amount;

// week 3 withdraw
$sql3 = $pdo->prepare("SELECT SUM(amount) as amount FROM tb_check WHERE bank_id = '$bankid' AND check_date BETWEEN '$week4_from' AND '$week4_to' ");
$sql3->execute();
$row3 = $sql3->fetch(PDO::FETCH_OBJ);
$week4_withdraw = $row3->amount;




      $select2 = $pdo->prepare("SELECT SUM(amount) as amount FROM tb_check WHERE bank_id = '$bankid' AND check_date BETWEEN '$datefrom' AND '$dateto' ");
      $select2->execute();
      $row2 = $select2->fetch(PDO::FETCH_OBJ);
      $totalwithdrawf = $row2->amount;


      $select3 = $pdo->prepare("SELECT SUM(amount) as amount FROM tb_deposit WHERE bank_id = '$bankid' AND date BETWEEN '$datefrom' AND '$dateto' ");
      $select3->execute();
      $row3 = $select3->fetch(PDO::FETCH_OBJ);
      $totaldepositf = $row3->amount;



// echo $week3_deposit.' '.$week3_withdraw;



?>


<!-- row open -->
<div class="row">


          <!-- <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">TOTAL CHECKS</span>
                <span class="info-box-number">
                 <h2><?php echo number_format($totalchecks,2);?></h2>
                </span>
              </div>
            </div>
          </div> -->


          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon  elevation-1" style="background-color:rgba(50,63,81,255);"><i class="fas fa-file text-white"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">TOTAL DEPOSIT</span>
                <span class="info-box-number"> <h2><?= number_format($totaldepositf,2) ?></h2></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon  elevation-1" style="background-color:rgba(136,86,86,255);"><i class="fas fa-file text-white"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">TOTAL WITHDRAW</span>
                <span class="info-box-number"> <h2><?= number_format($totalwithdrawf,2) ?></h2></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
         
          <!-- /.col -->

<div class="col-12 col-sm-12 col-md-12">
    <div class="card card-white">
        <div class="card-header">
          <h3 class="card-title">Bar Graph Data</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button> -->
          </div>
        </div>
        <div class="card-body">
          <div class="chart">
            <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>
    </div>
</div>



<!-- <div class="col-12 col-sm-12 col-md-12">
    <div class="card card-white">
        <div class="card-header">
          <h3 class="card-title">Pie Chart Data</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="chart">
            <canvas id="pieChart" style="min-height: 250px; height: 450px; max-height: 450px; max-width: 100%;"></canvas>
          </div>
        </div>
    </div>
</div> -->

</div>
<!-- row close -->



                  <!-- row close --> 
                </div>  
                <!-- card body close --> 

              </form>
              <!-- FORM CLOSE -->





            </div>

          </div>
          <!-- col md 12 open --> 
        </div>
        <!-- row close --> 
      </div>
      <!-- container fluid close --> 
    </div>
   <!-- Main content close -->


</div>
<!-- /.content-wrapper -->




<?php

include_once "footer.php";

?>


<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>

<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- chart.js -->
<script src="../../plugins/chart.js/Chart.min.js"></script>

<?php
  if(isset($_SESSION['status']) && $_SESSION['status']!='')
 
  {

?>
<script>

  
     Swal.fire({
        icon: '<?php echo $_SESSION['status_code'];?>',
        title: '<?php echo $_SESSION['status'];?>'
      });

</script>
<?php
unset($_SESSION['status']);
  }
  ?>


<script type="text/javascript">
  
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })


 //Date picker
 $('#date_1').datetimepicker({
        format: 'YYYY-MM-DD'
    });



    //Date picker
 $('#date_2').datetimepicker({
        format: 'YYYY-MM-DD'
    });

</script>


<!-- deposit color -->
<!-- rgba(40,166,68,255) -->
<!-- withdraw color -->
<!-- rgba(255,193,9,255) -->
<!-- rgba(50,63,81,255) -->
<!-- rgba(136,86,86,255) -->

<script>
  $(function () 
  {

    var areaChartCanvas = $('#barChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : ['Week1','Week2','Week3','Week4'],
      datasets: 
      [
        {
          label               : 'Withdraw',
          backgroundColor     : 'rgba(136,86,86,255)',
          borderColor         : 'rgba(136,86,86,255)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?= $week1_withdraw ?>,<?= $week2_withdraw ?>,<?= $week3_withdraw ?>,<?= $week4_withdraw ?>]
        },
        {
          label               : 'Deposit',
          backgroundColor     : 'rgba(50,63,81,255)',
          borderColor         : 'rgba(50,63,81,255)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?= $week1_deposit ?>,<?= $week2_deposit ?>,<?= $week3_deposit ?>,<?= $week4_deposit ?>]
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










    var donutChartCanvas = $('#pieChart').get(0).getContext('2d')
    var donutData        = {
      labels: ['Deposit','Withdraw'],
      datasets: [
        {
          data: [<?php echo $row3->amount;?>,<?php echo $row2->amount;?>],
          backgroundColor : ['#00a65a','#ffc109'],
        }
      ]
    }
    // var donutOptions     = {
    //   maintainAspectRatio : false,
    //   responsive : true,
    // }
    // //Create pie or douhnut chart
    // // You can switch between pie and douhnut using the method below.
    // new Chart(donutChartCanvas, {
    //   type: 'doughnut',
    //   data: donutData,
    //   options: donutOptions
    // })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })






    
  })
</script>








