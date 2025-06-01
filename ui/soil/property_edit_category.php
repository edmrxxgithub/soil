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
  $userid = $_SESSION['userid'];
}


include_once "header.php";

$itemid = $_GET['id'];

$select = $pdo->prepare("SELECT * from tb_property_category where id = $itemid ");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);


if (isset($_POST['updatecategory'])) 
{

  $categoryname = $_POST['categoryname'];

  $f_name        =$_FILES['myfile']['name'];
  $f_tmp         =$_FILES['myfile']['tmp_name'];
  $f_size        =$_FILES['myfile']['size'];
  $f_extension   =explode('.',$f_name);
  $f_extension   =strtolower(end($f_extension));
  $f_newfile     =uniqid().'.'. $f_extension;   
  
  $store = "images/".$f_newfile;
  $productimage = $f_newfile;

 if(!empty($f_name))
 {

    move_uploaded_file($f_tmp,$store);

    $update = $pdo->prepare("UPDATE tb_property_category SET name = '$categoryname' , image = '$productimage' WHERE id = '$itemid' ");

    if($update->execute())
    {
      $_SESSION['status']="Category updated successfully!";
      $_SESSION['status_code']="success";
    }
    else
    {
      $_SESSION['status']="Category updated failed!";
      $_SESSION['status_code']="error";
    }


 }
 else
 {

    $update = $pdo->prepare("UPDATE tb_property_category SET name = '$categoryname' WHERE id = '$itemid' ");

      if($update->execute())
      {
        $_SESSION['status']="Category updated successfully!";
        $_SESSION['status_code']="success";
      }
      else
      {
        $_SESSION['status']="Category updated failed!";
        $_SESSION['status_code']="error";
      }

 }


  
// echo $fullname.' '.$address.' '.$contactnum.' '.$username.' '.$defaultpassword.' '.$userlevelid;



}


$select = $pdo->prepare("SELECT * from tb_property_category where id = $itemid ");
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
                    <h5 class="m-0 text-white" ><a href="property_category_menu.php" class="text-white">View Category</a> / Edit Category</h5>
                </div>


                <!-- card body open --> 
                <form action="" method="post" enctype="multipart/form-data">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">

                    <div class="col-md-6">
                        <li class="list-group-item">
                          <div class="form-group">
                              <b>Category name: </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="categoryname" placeholder="Category name" required="" value="<?= $row->name ?>">
                          </div>
                          <div class="form-group">
                            <label >Product image</label><br />
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
                      <button type="submit" class="btn btn-primary btn-md" name="updatecategory">Update</button>
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