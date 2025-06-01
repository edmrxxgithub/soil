<?php

include_once 'connectdb.php';
session_start();


if($_SESSION['userid']=="" )
{

header('location:../../index.php');

}


include_once "header.php";



$select =$pdo->prepare("select sum(total) as gt , count(invoice_id) as invoice from tbl_invoice");
$select->execute();

$row=$select->fetch(PDO::FETCH_OBJ);

$total_order=$row->invoice;
$grand_total=$row->gt;



$select =$pdo->prepare("select count(product) as pname from tbl_product");
$select->execute();

$row=$select->fetch(PDO::FETCH_OBJ);

$total_product=$row->pname;



$select =$pdo->prepare("select count(category) as cate from tbl_category");
$select->execute();

$row=$select->fetch(PDO::FETCH_OBJ);

$total_category=$row->cate;









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
          <h1 class="m-0">Admin Dashboard</h1>
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

          <div class="col-lg-3 col-6">
            <div class="small-box bg-white" >
              <div class="inner" style="background-color:rgba(50,63,81,255);">
                <h3 class="text-white"><?php echo $total_order;?></h3>
                <p class="text-white">TOTAL CHECKS</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>


          <div class="col-lg-3 col-6">
            <div class="small-box bg-white" >
              <div class="inner" style="background-color:rgba(50,63,81,255);">
                <h3 class="text-white">13</h3>
                <p class="text-white">TOTAL BANK ACCOUNTS</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-white" >
              <div class="inner" style="background-color:rgba(50,63,81,255);">
                <h3 class="text-white">75,000.00</h3>
                <p class="text-white">TOTAL WITHDRAW</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>


          <div class="col-lg-3 col-6">
            <div class="small-box bg-white" >
              <div class="inner" style="background-color:rgba(50,63,81,255);">
                <h3 class="text-white">210,000.00</h3>
                <p class="text-white">TOTAL DEPOSIT</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          
          
          
        </div>
        <!-- /.row -->










        <div class="card card-grey card-outline">
            <div class="card-header">
              <h5 class="m-0">Deposit chart</h5>
            </div>
            <div class="card-body">
            
<?php

$select = $pdo->prepare("select order_date , total  from tbl_invoice  group by order_date LIMIT 50");

$select->execute();

$ttl=[];
$date=[];

while ($row = $select->fetch(PDO::FETCH_ASSOC)) 
{
extract($row);

$ttl[]=$total;
$date[]=$order_date;

}

// echo json_encode($total);


?>






<div >
  <canvas id="myChart" style="height: 250px"></canvas>
</div>




            </div>

            <script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($date);?>,
      datasets: [{
        label: 'Total deposit',
       backgroundColor:'rgba(136,86,86,255)',
       borderColor:'rgba(136,86,86,255)',
        data: <?php echo json_encode($ttl);?>,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
          
        }
      }
    }
  });
</script>





            </div>




<div class="card card-grey card-outline">
      <div class="card-header">
          <h5 class="m-0">Area chart</h5>
      </div>
      <div class="card-body">

        <div class="chart">
            <canvas id="areaChart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
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


?>

<script>
  $(document).ready(function() 
  {
    $('#table_recentorder').DataTable({

      "order":[[0,"desc"]]
    });
  });

  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Deposit',
          backgroundColor     : 'rgba(50,63,81,255)',
          borderColor         : 'rgba(50,63,81,255)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label               : 'Withdraw',
          backgroundColor     : 'rgba(136,86,86,255)',
          borderColor         : 'rgba(136,86,86,255)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,
      options: areaChartOptions
    })




  })
</script>


