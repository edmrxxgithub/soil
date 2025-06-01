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
          <h1 class="m-0">Bank Daily Report</h1>
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
                    <h5 class="m-0">From : <font style="font-weight:bold;" ><?php echo $_POST['date_1']; ?>  -- TO -- <?php echo $_POST['date_2']; ?></font></h5>

                    <h5 class="m-0">Bank/Account No. : <font style="font-weight:bold;" ><?php echo $bankname_accountnum ?> </font></h5>
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
                                    <option value="">Select bank</option><?php echo fill_bank($pdo);?>
                              </select>
                            </div>
                          </div>   
                          

                          <div class="col-md-3">
                            <div class="form-group">
                                <!-- <label>Date:</label> -->
                                <div class="input-group date" id="date_1" data-target-input="nearest">
                                    <input type="text" required class="form-control date_1" data-target="#date_1" name="date_1"/>
                                    <div class="input-group-append" data-target="#date_1" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                                <!-- <label>Date:</label> -->
                                  <div class="input-group date" id="date_2" data-target-input="nearest">
                                      <input type="text" required class="form-control date_2" data-target="#date_2"  name="date_2"/>
                                      <div class="input-group-append" data-target="#date_2" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <div class="col-md-2">  
                              <div class="text-center">
                                  <button type="submit" class="btn btn-warning" name="btnfilter">Filter Records</button>
                              </div>
                          </div>

                  </div>


<?php

// echo $_POST['bankid'].' '.$_POST['date_1'].' '.$_POST['date_2'];
      
$date1 = $_POST['date_1'];
$date2 = $_POST['date_2'];

$current = strtotime($date1);
$end = strtotime($date2);

while ($current <= $end) 
{
    $datenowf =  date('Y-m-d', $current);

    $select1 = $pdo->prepare("SELECT * FROM tb_check WHERE bank_id = '$bankid' AND check_date = '$datenowf' AND status_id = '2' ");
    $select1->execute();
    $row1=$select1->fetch(PDO::FETCH_OBJ);
    

    $select4 = $pdo->prepare("SELECT * FROM tb_deposit WHERE bank_id = '$bankid' AND date = '$datenowf' ");
    $select4->execute();
    $row4 = $select4->fetch(PDO::FETCH_OBJ);
    
    if ($row1->amount != '' || $row4->amount != '') 
    {
        $json_withdraw[] = $row1->amount;
        $json_deposit[] = $row4->amount;
        $json_date[] = $datenowf;
    }

$current = strtotime("+1 day", $current);

}


$select2 = $pdo->prepare("SELECT SUM(amount) as total_withdrawf FROM tb_check WHERE check_date BETWEEN '$date1' AND '$date2' AND status_id = '2' ");
$select2->execute();
$row2 = $select2->fetch(PDO::FETCH_OBJ);


$select3 = $pdo->prepare("SELECT SUM(amount) as total_depositf FROM tb_deposit WHERE date BETWEEN '$date1' AND '$date2' ");
$select3->execute();
$row3 = $select3->fetch(PDO::FETCH_OBJ);

?>


<!-- row open -->
<div class="row">

          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon  elevation-1" style="background-color:rgba(16,101,37);">
                <i class="fas fa-file text-white"></i>
              </span>

              <div class="info-box-content">
                <span class="info-box-text">TOTAL DEPOSIT</span>
                <span class="info-box-number"> <h2><?php echo number_format($row3->total_depositf,2);?></h2></span>
              </div>
            </div>
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon  elevation-1" style="background-color:rgba(120, 40, 31);"><i class="fas fa-file text-white"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">TOTAL WITHDRAW</span>
                <span class="info-box-number"> <h2><?php echo number_format($row2->total_withdrawf,2);?></h2></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
         
          <!-- /.col -->

<div class="col-12 col-sm-12 col-md-12">
    <div class="card card-white">
        <div class="card-header" style="background-color:rgba(50,63,81,255);">
          <h3 class="card-title text-white">Bar Graph Data</h3>

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



<div class="col-12 col-sm-12 col-md-12">
    <div class="card card-white">
        <div class="card-header" style="background-color:rgba(50,63,81,255);">
          <h3 class="card-title text-white">Pie Chart Data</h3>

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
            <canvas id="pieChart" style="min-height: 250px; height: 450px; max-height: 450px; max-width: 100%;"></canvas>
          </div>
        </div>
    </div>
</div>

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
      labels  : <?php echo json_encode($json_date);?>,
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
          data                : <?php echo json_encode($json_withdraw);?>
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
          data                : <?php echo json_encode($json_deposit);?>
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
          data: [<?php echo $row3->total_depositf;?>,<?php echo $row2->total_withdrawf;?>],
          backgroundColor : ['rgba(50,63,81,255)','rgba(136,86,86,255)'],
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








