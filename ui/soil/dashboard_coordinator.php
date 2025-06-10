<?php
include_once 'connectdb.php';
include_once 'function.php';
session_start();


if($_SESSION['userid']=="")
{

header('location:../../index.php');

}
else
{
  $userlevelid = $_SESSION['user_level_id'];
  $useridphp = $_SESSION['userid'];
}


if ($userlevelid == 3) 
{
  // include_once "header.php";
  include_once "coordinator_header.php";
}
else
{
  // header('location:../../logout.php');
  header('location:logout.php');
}


function fetch_num_branch($pdo,$id)
{
  $select = $pdo->prepare("SELECT * FROM tb_tax_branch where business_id = '$id' ");
  $select->execute();
  $num = $select->rowCount();

  return $num;
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
          <!-- <h1 class="m-0">Coordinator Dashboard</h1> -->
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

          
          
          
          
        </div>
        <!-- /.row -->





<?php



?>




        <div class="card card-grey card-outline">
            <div class="card-header" style="background-color:rgba(50,63,81,255);">
              <h5 class="m-0 text-white" >Clients</h5>
            </div>
            <div class="card-body">
            

<div class="row">

<?php

// $select1 = $pdo->prepare("SELECT * FROM tb_tax_business WHERE client_id = '$clientid' ");
$select1 = $pdo->prepare("SELECT * FROM tb_tax_business  ");
$select1->execute();
while ($row1 = $select1->fetch(PDO::FETCH_OBJ))
{

  $numofbranch = fetch_num_branch($pdo,$row1->id);

  $select2 = $pdo->prepare("SELECT * FROM tb_coordinator WHERE user_id = '$useridphp' AND business_id = '".$row1->id."' ");
  $select2->execute();
  $select2num = $select2->rowCount();

  if ($select2num > 0) 
  {
    
  

?>

<div class="col-md-6 col-lg-6 mt-4">
  <div class="small-box" style="background-color:rgb(249,249,247);">
    <div class="inner">
      <h3 class="text-black">
          <center>
            <!-- <a href="tax_view_client_business.php?id=<?= $row1->id ?>"> -->
            <a href="coordinator_view_client_data.php?businessid=<?= $row1->id ?>">
                <image src="images/<?php echo $row1->image;?>" class="img-rounded" width="200px" height="150px/">
            </a>
          </center>
      </h3>

      <table border="0" width="100%">
        <tr>
          <td width="20%">Business name : </td>
          <td style="font-weight:bold;">&emsp;<?= $row1->name ?></td>
        </tr>
        <tr>
          <td width="20%">Address : </td>
          <td style="font-weight:bold;">&emsp;<?= $row1->address ?></td>
        </tr>
        <tr>
          <td width="20%">No of branch : </td>
          <td style="font-weight:bold;">&emsp;<?= $select2num ?></td>
        </tr>
        <tr>
          <td width="20%">TIN : </td>
          <td style="font-weight:bold;">&emsp;<?= $row1->tin ?></td>
        </tr>
        
      </table>

      
      
    </div>
    <div class="icon">
      <i class="ion ion-bag"></i>
    </div>
  </div>
</div>

<?php
 }
}
?>


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


<?php include_once "footer.php"; ?>



