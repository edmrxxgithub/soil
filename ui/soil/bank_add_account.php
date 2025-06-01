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


$select = $pdo->prepare("SELECT * from tb_user where id = $id");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);

$userlevel_name = user_level($pdo,$row->user_level_id);




if (isset($_POST['addbankaccount'])) 
{

  $bankname = $_POST['bankname'];
  $account_num = $_POST['account_num'];
  
  $select = $pdo->prepare("SELECT * FROM tb_bank where name = '$bankname' AND account_num = '$account_num' ");
  $select->execute();
  $num_rows = $select->rowCount();

  if ($num_rows > 0) 
  {
    $_SESSION['status']="Bank details already exists!";
    $_SESSION['status_code']="error";
  }
  else
  {
    $insert = $pdo->prepare("INSERT INTO tb_bank SET name = '$bankname' , account_num = '$account_num' ");

      if($insert->execute())
      {
        $_SESSION['status']="Account created successfully!";
        $_SESSION['status_code']="success";
      }
  
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
                    <h5 class="m-0 text-white" ><a href="bank_account.php" class="text-white">View Bank Accounts</a> / Add Bank Account</h5>
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
                              <b>Bank name : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="bankname" placeholder="Input bank name" required="">
                          </div>
                          <div class="form-group">
                            <b>Account No. : </b>&emsp;
                            <input type="text" class="form-control" autocomplete="off" name="account_num" placeholder="Input account number" required="">
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
                      <button type="submit" class="btn btn-primary btn-md" name="addbankaccount">Add Bank Account</button>
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