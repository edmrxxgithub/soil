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

$supplierid = $_GET['id'];



$select = $pdo->prepare("SELECT * FROM tb_tax_supplier WHERE id = '$supplierid' ");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);


if (isset($_POST['update_supplier'])) 
{

  $supplierid = $_POST['supplierid'];
  $suppliername = $_POST['suppliername'];
  $tin = $_POST['tin'];
  $address = $_POST['address'];

    $update = $pdo->prepare("UPDATE tb_tax_supplier SET name = '$suppliername', tin = '$tin', address = '$address' WHERE id = '$supplierid' ");
    
    if($update->execute())
    {
      $_SESSION['status']="Supplier updated successfully!";
      $_SESSION['status_code']="success";
    }
    else
    {
      $_SESSION['status']="Supplier updated failed!";
      $_SESSION['status_code']="error";
    }
 

}



$select = $pdo->prepare("SELECT * FROM tb_tax_supplier WHERE id = '$supplierid' ");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

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
                    <h5 class="m-0 text-white" ><a href="tax_supplier.php" class="text-white">View Supplier</a> / Edit Supplier</h5>
                </div>
                <!-- card body open --> 


                <form action="" method="post">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">

                    <input type="hidden" name="supplierid" value="<?= $supplierid ?>">

                    <div class="col-md-6">
                        <li class="list-group-item">
                          <div class="form-group">
                              <b>Client name : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="suppliername" placeholder="Input supplier name" required="" value="<?= $row->name ?>" >
                          </div>
                          <div class="form-group">
                              <b>TIN : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="tin" placeholder="Input TIN" required="" value="<?= $row->tin ?>">
                          </div>
                          <div class="form-group">
                              <b>Address : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="address" placeholder="Input address" required="" value="<?= $row->address ?>">
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
                      <button type="submit" class="btn btn-primary btn-md" name="update_supplier">Update Supplier</button>
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