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
                    <h5 class="m-0 text-white" ><a href="accounts_payables.php" class="text-white">View Payable Suppliers</a> / Add Payable Supplier</h5>
                </div>
                <!-- card body open --> 
                <form action="" method="post">

<?php

if (isset($_POST['add_payable_supplier'])) 
{

$name = $_POST['name'];
$address = $_POST['address'];
$contact_num = $_POST['contact_num'];
$tin = $_POST['tin'];
$code = $_POST['code'];

// echo $name.' '.$address.' '.$contact_num.' '.$tin;
// name  address contact_num tin

  $insert = $pdo->prepare("INSERT INTO 
            tb_account_supplier 
            SET 
            name = '$name' , 
            address = '$address' , 
            contact_num = '$contact_num' , 
            tin = '$tin' ,
            code = '$code' ");

  if($insert->execute())
  {
    $_SESSION['status']="Supplier created successfully!";
    $_SESSION['status_code']="success";
  }
  else
  {
    $_SESSION['status']="Supplier created failed!";
    $_SESSION['status_code']="error";
  }

}


?>


                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">

                    <div class="col-md-6">
                        <li class="list-group-item">

                          <div class="form-group">
                              <b>Name : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="name" placeholder="Input name" required="">
                          </div>
                          <div class="form-group">
                            <b>Address : </b>&emsp;
                            <input type="text" class="form-control" autocomplete="off" name="address" placeholder="Input address" required="">
                          </div>
                          <div class="form-group">
                            <b>Contact No. : </b>&emsp;
                            <input type="text" class="form-control" autocomplete="off" name="contact_num" placeholder="Input contact number" required="">
                          </div>
                          <div class="form-group">
                            <b>TIN : </b>&emsp;
                            <input type="text" class="form-control" autocomplete="off" name="tin" placeholder="Input TIN" required="">
                          </div>
                          <div class="form-group">
                            <b>Code : </b>&emsp;
                            <input type="text" class="form-control" autocomplete="off" name="code" placeholder="Input code" required="">
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
                      <button type="submit" class="btn btn-primary btn-md" name="add_payable_supplier">Add Supplier</button>
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