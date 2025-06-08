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
  $id = $_GET['id'];
}


include_once "header.php";


$select = $pdo->prepare("SELECT * from tb_user where id = $id");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);

// $userlevel_name = user_level($pdo,$row->user_level_id);

if (isset($_POST['updateaccount'])) 
{

  $userid = $_POST['userid'];

  $fullname = $_POST['fullname'];
  $address = $_POST['address'];
  $contactnum = $_POST['contactnum'];
  $username = $_POST['username'];
  $userlevelid = $_POST['userlevelid'];
  $statusid = $_POST['statusid'];

// echo $fullname.' '.$address.' '.$contactnum.' '.$username.' '.$defaultpassword.' '.$userlevelid;

  $update = $pdo->prepare("UPDATE tb_user SET name = '$fullname' , address = '$address' , contact_num = '$contactnum' , user_level_id = '$userlevelid' , username = '$username' , status = '$statusid' WHERE id = '$userid' ");

  if($update->execute())
  {
    $_SESSION['status']="Account updated successfully!";
    $_SESSION['status_code']="success";
  }
  else
  {
    $_SESSION['status']="Account updated failed!";
    $_SESSION['status_code']="error";
  }

}


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
                    <h5 class="m-0 text-white" ><a href="view_accounts.php" class="text-white">View Accounts</a> / Edit Accounts</h5>
                </div>
                <!-- card body open --> 
                <form action="" method="post">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">

                    <div class="col-md-6">
                        <li class="list-group-item">
                          <input type="hidden" value="<?= $id ?>" name="userid" >
                          <div class="form-group">
                              <b>Full name : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="fullname" placeholder="Input fullname" required="" value="<?= $row->name ?>">
                          </div>
                          <div class="form-group">
                            <b>Address : </b>&emsp;
                            <input type="text" class="form-control" autocomplete="off" name="address" placeholder="Input address" value="<?= $row->address ?>">
                          </div>
                          <div class="form-group">
                            <b>Contact No. : </b>&emsp;
                            <input type="text" class="form-control" autocomplete="off" name="contactnum" placeholder="Input contact number" value="<?= $row->contact_num ?>">
                          </div>
                        </li>

                        <br>

                        <li class="list-group-item">
                          <div class="form-group">
                              <b>Username : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="username" placeholder="Input username" required="" value="<?= $row->username ?>">
                          </div>
                          <div class="form-group">
                            <b>Default Password : </b>&emsp;
                            <input type="password" class="form-control" value="soil123" name="password" disabled placeholder="Input password">
                          </div>
                        </li>

                        <br>

                    <li class="list-group-item"><b>User level : </b>&emsp;
                        <select class="form-control" name="userlevelid" required>
                          <option value="" disabled selected>Select user level</option>
                          <?php
                            $select=$pdo->prepare("SELECT * FROM tb_user_level ");
                            $select->execute();

                            while($row1=$select->fetch(PDO::FETCH_OBJ))
                            {
                            // extract($row);

                            ?>
                              <option <?php if($row1->id == $row->user_level_id  ){ ?>
                                
                                selected="selected"
                                
                                
                                <?php }?> value=<?= $row1->id ?> ><?php echo ucfirst($row1->name) ;?></option>

                            <?php

                            }

                            ?>
                        </select>

                        <br>

                        <b>Status : </b>&emsp;
                        <select class="form-control" name="statusid" required>
                          <option value="" disabled selected>Select status</option>

                          <?php
                            if ($row->status == 1) 
                            {
                          ?>
                            <option selected="selected" value="1">Activate</option>
                            <option  value="0">Deactivate</option>
                          <?php
                            }
                            else
                            {
                            ?>
                            <option selected="selected" value="0">Deactivate</option>
                            <option  value="1">Activate</option>
                          <?php
                            }
                          ?>
                        </select>
                    </li>

                    </div>
                    
                  </div>
                  <!-- row close --> 
                </div>  
                <!-- card body close --> 

                <!-- card footer open --> 
                <div class="card-footer">
                  <div class="text-center">
                      <button type="submit" class="btn btn-success btn-md" name="updateaccount">Update Account</button>
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




  