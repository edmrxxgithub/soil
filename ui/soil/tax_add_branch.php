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


$businessid = $_GET['businessid'];

function fetch_data($pdo,$id)
{
  $select = $pdo->prepare("SELECT * FROM tb_tax_business WHERE id = '$id' ");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);

  $select1 = $pdo->prepare("SELECT * FROM tb_tax_client WHERE id = '".$row->client_id."' ");
  $select1->execute();
  $row1 = $select1->fetch(PDO::FETCH_OBJ);

  $array['clientname'] = $row1->name;
  $array['clientid'] = $row->client_id;
  $array['businessname'] = $row->name;


  return $array;
}


$data = fetch_data($pdo,$businessid);


if (isset($_POST['addbranch'])) 
{

$clientid = $_POST['clientid'];
$businessid = $_POST['businessid'];
$tin = $_POST['tin'];
$address = $_POST['address'];

// echo $clientid.' '.$businessid.' '.$tin.' '.$address;

$insert = $pdo->prepare("INSERT INTO tb_tax_branch SET client_id = '$clientid', business_id = '$businessid', tin = '$tin', address = '$address' ");

  if ($insert->execute()) 
  {
    $_SESSION['status']="Branch input successfully!";
    $_SESSION['status_code']="success";
  }
  else
  {
    $_SESSION['status']="Business input failed!";
    $_SESSION['status_code']="error";
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
                    <h5 class="m-0 text-white">
                    <a href="tax_client.php" class="text-white">View Clients</a> / 
                    <a href="tax_view_client.php?id=<?= $data['clientid'] ?>" class="text-white"><?= $data['clientname'] ?></a> / 
                    <a href="tax_view_client_business.php?id=<?= $businessid ?>" class="text-white"><?= $data['businessname'] ?></a> / Add branch
                  </h5>
                </div>
                <!-- card body open --> 

                <form action="" method="post" enctype="multipart/form-data">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">

                    <input type="hidden" value="<?= $data['clientid'] ?>" name="clientid">
                    <input type="hidden" value="<?= $businessid ?>" name="businessid">

                    <div class="col-md-6">
                        <li class="list-group-item">
                          <div class="form-group">
                              <b>Business name : </b>&emsp;
                              <input type="text" class="form-control" value="<?= $data['businessname'] ?>" disabled>
                          </div>
                          <div class="form-group">
                              <b>Address : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="address" placeholder="Input address" required="">
                          </div>
                          <div class="form-group">
                              <b>TIN : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="tin" placeholder="Input TIN" required="">
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
                      <button type="submit" class="btn btn-primary btn-md" name="addbranch">Add Branch</button>
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