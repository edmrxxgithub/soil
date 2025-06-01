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

$datenow = date('Y-m-d');

include_once "header.php";


// $select = $pdo->prepare("SELECT * from tb_user where id = $id");
// $select->execute();
// $row=$select->fetch(PDO::FETCH_OBJ);

// $userlevel_name = user_level($pdo,$row->user_level_id);

$bankid = $_GET['bankid'];


$bankname = $pdo->prepare("SELECT * FROM tb_bank WHERE id = '$bankid' ");
$bankname->execute();
$bankname = $bankname->fetch(PDO::FETCH_OBJ);

$bankname = $bankname->name.' - '.$bankname->account_num.'';

function fill_bank($pdo)
{

    $output='';
    $select=$pdo->prepare("SELECT * FROM tb_bank order by id asc");
    $select->execute();
    $result=$select->fetchAll();
    foreach($result as $row)
    {
        $output.='<option value="'.$row["id"].'">'.$row["name"].' ('.$row['account_num'].')</option>';
    }

    return $output; 

}


function fill_payee($pdo)
{

    $output='';
    $select=$pdo->prepare("SELECT * FROM tb_payee order by id asc");
    $select->execute();
    $result=$select->fetchAll();
    foreach($result as $row)
    {
        $output.='<option value="'.$row["id"].'">'.$row["name"].'</option>';
    }

    return $output; 
}




if (isset($_POST['addcheck'])) 
{

$bankid = $_POST['bankid'];
$payeeid = $_POST['payeeid'];
$checknum = $_POST['checknum'];
$description = $_POST['description'];
$checkdate = $_POST['checkdate'];
$checkamount = $_POST['checkamount'];

$timestamp = date("Y-m-d H:i:s");

// bank_id payee_id  check_date  payment_date  check_num description amount  created_at  cleared_at  cancelled_at  hold_at status_id user_id

$insert = $pdo->prepare("INSERT INTO tb_check

  SET 

  bank_id = '$bankid' , 
  payee_id = '$payeeid' ,
  check_date = '$checkdate' ,

  payment_date = '$checkdate' ,
  check_num = '$checknum' ,
  description = '$description' ,

  amount = '$checkamount' ,
  created_at = '$timestamp' ,
  user_id = '$userid',
  status_id = '1'
   ");

// $insert->execute();

if($insert->execute())
  {
    $_SESSION['status']="Check created successfully!";
    $_SESSION['status_code']="success";
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
                    <h5 class="m-0 text-white"><a href="bank_account.php" class="text-white">View Bank Accounts</a> / <a href="bank_account_details.php?id=<?= $bankid ?>&datenow=<?= $datenow ?>" class="text-white">Bank Details</a> / Add Check</h5>
                </div>
                <!-- card body open --> 
                <form action="" method="post">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">

                    <div class="col-md-6">
                        <li class="list-group-item">
                          <input type="hidden" value="<?= $bankid ?>" name="bankid" >
                          <div class="form-group">
                            <b>Bank name : </b>&emsp;
                            <input type="text" class="form-control" name="#" value="<?= $bankname ?>" disabled>
                          </div>
                          <div class="form-group">
                              <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="payeeid">
                                    <option value="">Select payee</option><?php echo fill_payee($pdo);?>
                              </select>
                          </div>
                          <div class="form-group">
                            <b>Check number : </b>&emsp;
                            <input type="text" autocomplete="off" class="form-control" name="checknum" required="" placeholder="Input check number">
                          </div>
                          <div class="form-group">
                            <b>Description : </b>&emsp;
                            <input type="text" class="form-control" name="description" autocomplete="off" placeholder="Input description">
                          </div>
                          <div class="form-group">
                            <b>Check date. : </b>&emsp;
                            <input type="date" class="form-control" name="checkdate" required="">
                          </div>
                          <div class="form-group">
                            <b>Amount : </b>&emsp;
                            <input type="text" class="form-control" name="checkamount" autocomplete="off" placeholder="Input amount" required="">
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
                      <button type="submit" class="btn btn-primary btn-md" name="addcheck">Add Check</button>
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




<script type="text/javascript">
  
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

</script>

