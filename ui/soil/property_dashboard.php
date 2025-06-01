<?php
include_once 'connectdb.php';
include_once 'function.php';

session_start();


if($_SESSION['userid']=="" )
{

header('location:../../index.php');

}
else
{
  $id = $_SESSION['userid'];
}


include_once "header.php";
$total_overall_carrying_amount = fetch_property_total_carrying_amount_all_category($pdo);



$select1 = $pdo->prepare("SELECT * FROM tb_property_category ");
$select1->execute();
while ($row = $select1->fetch(PDO::FETCH_OBJ)) 
{
    $carryingamount = fetch_property_carrying_amount($pdo,$row->id);
    $categorynamejson[] = $row->name;
    $carryingamountjson[] = number_format($carryingamount, 2, '.', '');
}


$select2 = $pdo->prepare("SELECT SUM(price) as totaloverall FROM tb_property_data ");
$select2->execute();
$row2 = $select2->fetch(PDO::FETCH_OBJ)



?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0">Admin Dashboard</h1> -->
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

            <div class="card card-grey card-outline">
                <div class="card-header" style="background-color:rgba(50,63,81,255);">
                    <h5 class="m-0 text-white" style="height:35px;">
                      Property Dashboard
                      <span class="float-right text-white">
                        <font size="6">TOTAL&emsp;:&emsp;<?= number_format($total_overall_carrying_amount,2) ?></font>
                      </span>
                    </h5>
                </div>
                  <!-- card body open -->
                  <div class="card-body" style="background-color:rgb(249,249,247);">
                    <!-- row open --> 
                    <div class="row">

<?php

$select = $pdo->prepare("SELECT * FROM tb_property_category ");
$select->execute();
while ($row = $select->fetch(PDO::FETCH_OBJ)) 
{

$carryingamount = fetch_property_carrying_amount($pdo,$row->id);
$itemcount = fetch_property_item_count($pdo,$row->id);

$percentage = $carryingamount /  $total_overall_carrying_amount ;
$percentage = $percentage * 100;
$percentage = number_format($percentage,2).'%';

?>
<div class="col-md-12 col-lg-6">
  <div class="small-box bg-white">
    <div class="inner">
      <h3 class="text-black">
          <center>
            <a href="property_category_details.php?id=<?= $row->id ?>">
                <image src="images/<?php echo $row->image;?>" class="img-rounded" width="200px" height="150px/">
            </a>
          </center>
      </h3>
      
      <center>
      <p class="text-black" style="font-weight:bold;"><font size="5"><?= strtoupper($row->name) ?></font></p>
      </center>

      <table border="0" width="100%">
        <tr>
          <td width="40%">Item count : </td>
          <td style="font-weight:bold;">&emsp;<?= $itemcount ?></td>
        </tr>
        <tr>
          <td>Carrying amount : </td>
          <td style="font-weight:bold;">&emsp;<?= number_format($carryingamount,2) ?></td>
        </tr>
        <!-- <tr>
          <td>Percentage : </td>
          <td>&emsp;<?= $percentage ?></td>
        </tr> -->
      </table>

      <table border="0" width="100%">
          <thead>
            <td align="center"><font size="10" style="font-weight:bold;"><?= $percentage ?></font></td>
          </thead>
      </table>
      
    </div>
    <div class="icon">
      <i class="ion ion-bag"></i>
    </div>
  </div>
</div>

<?php
}
?>



                    


                      
                      
                    </div>
                    <!-- row close --> 
                  </div>  
                  <!-- card body close --> 
            </div>



      <!-- card body open -->
      <div class="card card-grey card-outline">
            <div class="card-header" style="background-color:rgba(50,63,81,255);">
                <h5 class="m-0 text-white">Property Data</h5>
            </div>
            <div class="card-body">

              <div class="chart">
                  <canvas id="myChart" style="min-height: 550px; height: 550px; max-height: 550px; max-width: 100%;"></canvas>
              </div>

            </div>
      </div>
      <!-- card body close -->


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
<script src="../../plugins/chart.js/Chart.min.js"></script>

<?php

include_once "footer.php";

?>





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









<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels  : <?php echo json_encode($categorynamejson);?>,
      datasets: [{
        label: 'Total Carrying Amount',
       backgroundColor:'rgba(136,86,86,255)',
       borderColor:'rgba(136,86,86,255)',
        data : <?php echo json_encode($carryingamountjson);?>,
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

