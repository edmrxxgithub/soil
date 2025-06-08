<?php
include_once 'connectdb.php';
session_start();


if($_SESSION['userid']=="" )
{

header('location:../index.php');

}
else
{
  $id = $_SESSION['userid'];
}


include_once "header.php";


$id = $_GET['id'];
$select = $pdo->prepare("SELECT * from tb_user where id = $id");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);

$userlevelid = $row->user_level_id;



if (isset($_POST['updateprofile'])) 
{
  $userid      = $_POST['userid'];
  $fullname    = $_POST['fullname'];
  $address     = $_POST['address'];
  $contactnum  = $_POST['contactnum'];
  $userlevelid = $_POST['userlevelid'];

  // echo $fullname.' '.$address.' '.$contactnum.' '.$userlevelid.' '.$userid;

  $update = $pdo->prepare("UPDATE tb_user set name ='$fullname' , address='$address' , contact_num='$contactnum' , user_level_id='$userlevelid' where id= '$userid' ");

  if($update->execute())
  {
    $_SESSION['status']="Profile Updated Successfully";
    $_SESSION['status_code']="success";
  }
  else
  {
    $_SESSION['status']="Product Update Failed";
    $_SESSION['status_code']="error";
  }

}


$id = $_GET['id'];
$select = $pdo->prepare("SELECT * from tb_user where id = $id");
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
                <h5 class="m-0 text-white" ><a href="viewprofile.php" class="text-white">View Profile</a> / Edit Profile</h5>
              </div>
            <div class="card-body">

<div class="row">



<div class="col-md-6">

<form action="" method="post" name="formeditproduct" >

<!-- list group open -->
<ul class="list-group">

  <input type="hidden"   class="form-control"  value="<?= $id ?>" name="userid" >

  <li class="list-group-item">

    <b><span class="mt-3">Full name :</span>  </b>&emsp;<input type="text"   class="form-control"  value="<?= $row->name ?>"  name="fullname"    placeholder="Input full name" autocomplete="off">

    <br>

    <b>Address :</b>&emsp;<input type="text"   class="form-control"  value="<?= $row->address ?>"  name="address"     placeholder="Input address" autocomplete="off">

    <br>

    <b>Contact No. : </b>&emsp;<input type="text"  class="form-control"  value="<?= $row->contact_num ?>" name="contactnum"  placeholder="Input contact number" autocomplete="off">

</li>

  <br>

<li class="list-group-item">

  <b><span class="mt-3">Username :</span>  </b>&emsp;<input type="text"   class="form-control"  value="<?= $row->username ?>"  name="username"    placeholder="Input full name" autocomplete="off">

  <br>

  <b><span class="mt-3">Password :</span>  </b>&emsp;<input type="text"   class="form-control"  value="<?= $row->password ?>"  name="password"    placeholder="Input full name" autocomplete="off">

</li>

<br>

  <li class="list-group-item"><b>User level : </b>&emsp;
      <select class="form-control" name="userlevelid" required>
        <option value="" disabled selected>Select user level</option>
        <?php
          $select=$pdo->prepare("SELECT * FROM tb_user_level ");
          $select->execute();

          while($row=$select->fetch(PDO::FETCH_ASSOC))
          {
          extract($row);

          ?>
            <option <?php if($row['id']==$userlevelid  ){ ?>
              
              selected="selected"
              
              
              <?php }?> value=<?= $row['id'] ?> ><?php echo ucfirst($row['name']) ;?></option>

          <?php

          }

          ?>
      </select>
  </li>

</ul>
<!-- list group close -->

</div>


</div>



    <div class="card-footer">
      <div class="text-center">
          <button type="submit" class="btn btn-primary btn-md" name="updateprofile">Update Profile</button>
      </div>
    </div>
</div>
             


</form>



             
            </div>
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