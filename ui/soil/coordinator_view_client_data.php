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
  $userlevelid = $_SESSION['user_level_id'];
  $useridphp = $_SESSION['userid'];
  $businessid = $_GET['businessid'];
}




if ($userlevelid == 3) 
{
  // include_once "header.php";
  include_once "coordinator_header.php";
}
else
{
  header('location:logout.php');
}

$select = $pdo->prepare("SELECT * from tb_tax_business where id = $businessid");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);


?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0">Admin Dashboard</h1> -->
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
        

        <div class="card card-grey card-outline">
            <div class="card-header" style="background-color:rgba(50,63,81,255);">
              <h5 class="m-0 text-white"><a href="dashboard_coordinator.php" class="text-white">Clients</a> / <?= $row->name ?></h5>
            </div>
            <!-- card body open -->
            <form action="" method="post">
            <div class="card-body">

<div class="row">

<?php



?>

<div class="col-md-12">

<div class="table-responsive-sm">
  <font face="verdana">
    <table id="branch_datatable_registered" class="table table-hover" style="width: 100%">
        <thead>
            <tr>
                <td style="font-weight: bold;" align="center">Id</td> 
                <td style="font-weight: bold;" align="center">Branch address</td> 
                <td style="font-weight: bold;" align="center">TIN</td> 
            </tr>
        </thead>
      </table>
    </font>
</div>

</div>


</div>


          <div class="card-footer">
              <div class="text-center">      
                <!-- <button type="submit" class="btn btn-primary btn-md" name="updatepassword">Update</button> -->
              </div>
          </div>
             



            </div>
          </form>
            <!-- card body close -->
          </div>
     

       
        </div>
        <!-- /.col-md-6 -->
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
  $(document).ready(function()
  {

// alert('God is good, life is good!');
// useridphp
// businessid

    var branch_datatable_registered = $('#branch_datatable_registered').DataTable(
    {
      // "order": [[ 0, 'desc' ]],

        "responsive": true,
         "autoWidth": true,
      "lengthChange": true,
    "iDisplayLength": 25,


    "columnDefs": 
    [
        {
            "targets": [0],
            "visible": false,
            "searchable": true,  
        },


    ], 

        

        "ajax": 
        {
          // url:"fetch_user_datatable.php",
          url:"coordinator_fetch_branch_data_per_user.php?useridphp="+<?= $useridphp ?>+'&businessid='+<?= $businessid ?>,
          type:"post"
        }  

    });

  })
</script>









