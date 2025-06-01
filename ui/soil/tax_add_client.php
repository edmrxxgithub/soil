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


if (isset($_POST['addclient'])) 
{

  $client_name = $_POST['client_name'];
  $tin_no = $_POST['tin_no'];
  $address_num = $_POST['address_num'];

// echo $client_name.' '.$tin_no.' '.$address_num;
// client_name
// tin_no
// address_num
  
    $insert = $pdo->prepare("INSERT INTO tb_tax_client SET name = '$client_name', tin = '$tin_no', address = '$address_num' ");
    
    if($insert->execute())
    {
      $_SESSION['status']="Client created successfully!";
      $_SESSION['status_code']="success";
    }
    else
    {
      $_SESSION['status']="Client failed successfully!";
      $_SESSION['status_code']="success";
    }
 

}

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
                    <h5 class="m-0 text-white" ><a href="tax_client.php" class="text-white">View Clients</a> / Add Client</h5>
                </div>
                <!-- card body open --> 

<?php




?>


                <form action="" method="post">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">

                    <div class="col-md-6">
                        <li class="list-group-item">
                          <div class="form-group">
                              <b>Client name : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="client_name" placeholder="Input client name" required="">
                          </div>
                          <div class="form-group">
                              <b>TIN : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="tin_no" placeholder="Input TIN" required="">
                          </div>
                          <div class="form-group">
                              <b>Address : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="address_num" placeholder="Input address" required="">
                          </div>
                        </li>
                    </div>
                    
                  </div>
                  <!-- row close --> 
                </div>  
                <!-- card body close --> 

                <!-- card footer open --> 
                <div class="card-footer">
                  <div class="text-center">
                      <button type="submit" class="btn btn-primary btn-md" name="addclient">Add Client</button>
                  </div>
                </div>
                <!-- card footer close --> 

              </form>

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