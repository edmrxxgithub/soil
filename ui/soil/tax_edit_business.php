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


$business_id = $_GET['id'];


$select = $pdo->prepare("SELECT * FROM tb_tax_business WHERE id = '$business_id' ");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);


$clientid = $row->client_id;


$select2 = $pdo->prepare("SELECT * FROM tb_tax_client WHERE id = '$clientid' ");
$select2->execute();
$row2 = $select2->fetch(PDO::FETCH_OBJ);

if (isset($_POST['updatebusiness'])) 
{

$businessid = $_POST['businessid'];
$businessname = $_POST['businessname'];
$tin = $_POST['tin'];
$address = $_POST['address'];

  $f_name        =$_FILES['myfile']['name'];
  $f_tmp         =$_FILES['myfile']['tmp_name'];
  $f_size        =$_FILES['myfile']['size'];
  $f_extension   =explode('.',$f_name);
  $f_extension   =strtolower(end($f_extension));
  $f_newfile     =uniqid().'.'. $f_extension;   
  
  $store = "images/".$f_newfile;
  move_uploaded_file($f_tmp,$store);
  $productimage=$f_newfile;
  
if(!empty($f_name))
 {

    move_uploaded_file($f_tmp,$store);

    $update = $pdo->prepare("UPDATE tb_tax_business SET name = '$businessname' , image = '$productimage', tin = '$tin' , address = '$address' WHERE id = '$businessid' ");

    if($update->execute())
    {
      $_SESSION['status']="Business updated successfully!";
      $_SESSION['status_code']="success";
    }
    else
    {
      $_SESSION['status']="Business updated failed!";
      $_SESSION['status_code']="error";
    }


 }
 else
 {

    $update = $pdo->prepare("UPDATE tb_tax_business SET name = '$businessname' , tin = '$tin' , address = '$address' WHERE id = '$businessid' ");

      if($update->execute())
      {
        $_SESSION['status']="Business updated successfully!";
        $_SESSION['status_code']="success";
      }
      else
      {
        $_SESSION['status']="Business updated failed!";
        $_SESSION['status_code']="error";
      }

 }
 

}


$select = $pdo->prepare("SELECT * FROM tb_tax_business WHERE id = '$business_id' ");
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
                    <h5 class="m-0 text-white" ><a href="tax_client.php" class="text-white">View Clients</a> / <a href="tax_view_client.php?id=<?= $clientid ?>" class="text-white"><?= $row2->name ?></a> / Edit Business</h5>
                </div>
                <!-- card body open --> 




                <form action="" method="post" enctype="multipart/form-data">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">

                    <input type="hidden" value="<?= $business_id ?>" name="businessid">

                    <div class="col-md-6">
                        <li class="list-group-item">
                          <div class="form-group">
                              <b>Business name : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="businessname" placeholder="Input business name" required="" value="<?= $row->name ?>">
                          </div>
                          <div class="form-group">
                              <b>TIN : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="tin" placeholder="Input TIN" required="" value="<?= $row->tin ?>">
                          </div>
                          <div class="form-group">
                              <b>Address : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="address" placeholder="Input address" required="" value="<?= $row->address ?>">
                          </div>

                          <!-- <div class="form-group">
                            <label >Upload image</label>
                            <input type="file" class="input-group"  name="myfile" required>
                            <p>Upload image</p>
                          </div>  -->

                          <div class="form-group">
                            <label >Business image</label><br />
                            <image src="images/<?php echo $row->image;?>" class="img-rounded" width="50px" height="50px/">


                            <input type="file" class="input-group" name="myfile" >
                            <p>Upload image</p>

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
                      <button type="submit" class="btn btn-primary btn-md" name="updatebusiness">Update Business</button>
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