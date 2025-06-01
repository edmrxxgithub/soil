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

if (isset($_POST['addcategory'])) 
{

  $categoryname = $_POST['categoryname'];

  $f_name        =$_FILES['myfile']['name'];
  $f_tmp         =$_FILES['myfile']['tmp_name'];
  $f_size        =$_FILES['myfile']['size'];
  $f_extension   =explode('.',$f_name);
  $f_extension   =strtolower(end($f_extension));
  $f_newfile     =uniqid().'.'. $f_extension;   
  
  $store = "images/".$f_newfile;
  move_uploaded_file($f_tmp,$store);
  $productimage=$f_newfile;
  
// echo $fullname.' '.$address.' '.$contactnum.' '.$username.' '.$defaultpassword.' '.$userlevelid;

  $insert = $pdo->prepare("INSERT INTO tb_property_category SET name = '$categoryname' , image = '$productimage' ");

  if($insert->execute())
  {
    $_SESSION['status']="Category created successfully!";
    $_SESSION['status_code']="success";
  }
  else
  {
    $_SESSION['status']="Category created failed!";
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
                    <h5 class="m-0 text-white" ><a href="property_category_menu.php" class="text-white">View Category</a> / Add Category</h5>
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
                              <input type="text" class="form-control" autocomplete="off" name="categoryname" placeholder="Category name" required="">
                          </div>
                          <div class="form-group">
                            <label >Category image</label>
                            <input type="file" class="input-group"  name="myfile" required>
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
                      <button type="submit" class="btn btn-primary btn-md" name="addcategory">Add</button>
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