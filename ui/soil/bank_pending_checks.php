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

$bankid = $_GET['id'];





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

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0" ><a href="bank_account_details.php?id=<?= $bankid ?>" class="text-primary">Bank Details</a> / Pending Checks</h5>
                </div>
                <!-- card body open --> 
                <form action="" method="post">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">



                    <div class="col-md-6">
                        <li class="list-group-item">
                          <input type="hidden" value="soil123" name="defaultpassword" >
                          <div class="form-group">
                              <b>Full name : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="fullname" placeholder="Input fullname" required="">
                          </div>
                          <div class="form-group">
                            <b>Address : </b>&emsp;
                            <input type="text" class="form-control" autocomplete="off" name="address" placeholder="Input address">
                          </div>
                          <div class="form-group">
                            <b>Contact No. : </b>&emsp;
                            <input type="text" class="form-control" autocomplete="off" name="contactnum" placeholder="Input contact number">
                          </div>
                        </li>

                        <br>

                        <li class="list-group-item">
                          <div class="form-group">
                              <b>Username : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="username" placeholder="Input username" required="">
                          </div>
                          <div class="form-group">
                            <b>Default Password : </b>&emsp;
                            <input type="text" class="form-control" value="soil123" name="password" disabled placeholder="Input password">
                          </div>
                        </li>

                        <br>

                        <li class="list-group-item">
                          <b>User level : </b>&emsp;
                          <select class="form-control" name="userlevelid" required="">
                          <option value="" disabled selected>Select user level</option>
                          <?php
                            $select=$pdo->prepare("SELECT * FROM tb_user_level ");
                            $select->execute();
                            while($row=$select->fetch(PDO::FETCH_OBJ))
                            {
                            ?>
                              <option value=<?= $row->id ?> ><?php echo ucfirst($row->name) ;?></option>
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
                      <button type="submit" class="btn btn-primary btn-md" name="addaccount">Add Account</button>
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