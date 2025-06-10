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

$select = $pdo->prepare("SELECT * from tb_user where id = $useridphp");
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
              <h5 class="m-0 text-white">Change Password Menu</h5>
            </div>
            <!-- card body open -->
            <form action="" method="post">
            <div class="card-body">

<div class="row">

<?php

if (isset($_POST['updatepassword'])) 
{
  $userid = $_POST['userid'];
  $oldpassword = $_POST['oldpassword'];
  $newpassword = $_POST['newpassword'];
  $confirmnewpassword = $_POST['confirmnewpassword'];

  // echo $row->password.' '.$oldpassword;

  if ($row->password == $oldpassword) 
  {
      if ($newpassword == $confirmnewpassword) 
      {

          $update = $pdo->prepare("UPDATE tb_user SET password = '$newpassword' where id = '$userid' ");
          
          if ($update->execute()) 
          {
            $_SESSION['status']="Password changed successfully!";
            $_SESSION['status_code']="success";
          }
          else
          {
            $_SESSION['status']="Password changed failed!";
            $_SESSION['status_code']="error";
          }


      }
      else
      {
          $_SESSION['status']="New password and confirm new password doesnt match!";
          $_SESSION['status_code']="warning";
      }
  }
  else
  {
     
    $_SESSION['status']="Invalid old password!";
    $_SESSION['status_code']="warning";
      
  }

   

}

?>

<div class="col-md-6">

<ul class="list-group">

  <li class="list-group-item">
      <input type="hidden" value="<?= $useridphp ?>" name="userid" >
      <div class="form-group">
          <b>Old password : </b>&emsp;
          <input type="text" class="form-control" autocomplete="off" name="oldpassword" placeholder="Input old password" required="" >
      </div>
      <div class="form-group">
        <b>New password : </b>&emsp;
        <input type="text" class="form-control" autocomplete="off" name="newpassword" placeholder="Input new password" >
      </div>
      <div class="form-group">
        <b>Confirm new password : </b>&emsp;
        <input type="text" class="form-control" autocomplete="off" name="confirmnewpassword" placeholder="Confirm Input new password" >
      </div>
  </li>
</ul>
</div>


</div>


          <div class="card-footer">
              <div class="text-center">      
                <button type="submit" class="btn btn-primary btn-md" name="updatepassword">Update</button>
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

