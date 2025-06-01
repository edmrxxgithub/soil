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
                    <h5 class="m-0 text-white" ><a href="accounts_receivables.php" class="text-white">View Receivable Customers</a> / Edit Customer</h5>
                </div>
                <!-- card body open --> 
                <form action="" method="post">

<?php

$customer_id = $_GET['id'];

$select = $pdo->prepare("SELECT * FROM tb_account_customer where id = '$customer_id' ");
$select->execute();
$rowmain = $select->fetch(PDO::FETCH_OBJ);



if (isset($_POST['update_customer'])) 
{

$customer_id_hidden = $_POST['customer_id_hidden'];
$name = $_POST['name'];
$address = $_POST['address'];
$contact_num = $_POST['contact_num'];
$tin = $_POST['tin'];
$code = $_POST['code'];

// echo $name.' '.$address.' '.$contact_num.' '.$tin;
// name  address contact_num tin

  $update = $pdo->prepare("

    UPDATE

    tb_account_customer 

    SET 
    name = '$name' , 
    address = '$address' , 
    contact_num = '$contact_num' , 
    tin = '$tin' ,
    code = '$code'

    WHERE

    id = '$customer_id_hidden' ");

  if($update->execute())
  {
    $_SESSION['status']="Customer updated successfully!";
    $_SESSION['status_code']="success";
  }
  else
  {
    $_SESSION['status']="Customer updated failed!";
    $_SESSION['status_code']="error";
  }

}

$select = $pdo->prepare("SELECT * FROM tb_account_customer where id = '$customer_id' ");
$select->execute();
$rowmain = $select->fetch(PDO::FETCH_OBJ);

?>


                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">

                    <div class="col-md-6">
                        <li class="list-group-item">
                          <input type="hidden" value="<?= $customer_id ?>" name="customer_id_hidden">
                          <div class="form-group">
                              <b>Name : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="name" placeholder="Input name" required="" value="<?= $rowmain->name ?>" >
                          </div>
                          <div class="form-group">
                            <b>Address : </b>&emsp;
                            <input type="text" class="form-control" autocomplete="off" name="address" placeholder="Input address" required="" value="<?= $rowmain->address ?>">
                          </div>
                          <div class="form-group">
                            <b>Contact No. : </b>&emsp;
                            <input type="text" class="form-control" autocomplete="off" name="contact_num" placeholder="Input contact number" required="" value="<?= $rowmain->contact_num ?>">
                          </div>
                          <div class="form-group">
                            <b>TIN : </b>&emsp;
                            <input type="text" class="form-control" autocomplete="off" name="tin" placeholder="Input TIN" required="" value="<?= $rowmain->tin ?>">
                          </div>
                          <div class="form-group">
                            <b>Code : </b>&emsp;
                            <input type="text" class="form-control" autocomplete="off" name="code" placeholder="Input code" required="" value="<?= $rowmain->code ?>">
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
                      <button type="submit" class="btn btn-primary btn-md" name="update_customer">Update Customer</button>
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