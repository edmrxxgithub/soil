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

$datenow = date('Y-m-d');


// $select = $pdo->prepare("SELECT * from tb_user where id = $id");
// $select->execute();
// $row=$select->fetch(PDO::FETCH_OBJ);

// $userlevel_name = user_level($pdo,$row->user_level_id);

$bankid = $_GET['bankid'];


$bankname = $pdo->prepare("SELECT * FROM tb_bank WHERE id = '$bankid' ");
$bankname->execute();
$bankname = $bankname->fetch(PDO::FETCH_OBJ);

$bankname = $bankname->name.' - '.$bankname->account_num.'';

// function fill_bank($pdo)
// {

//     $output='';
//     $select=$pdo->prepare("SELECT * FROM tb_bank order by id asc");
//     $select->execute();
//     $result=$select->fetchAll();
//     foreach($result as $row)
//     {
//         $output.='<option value="'.$row["id"].'">'.$row["name"].' ('.$row['account_num'].')</option>';
//     }

//     return $output; 

// }


// function fill_payee($pdo)
// {

//     $output='';
//     $select=$pdo->prepare("SELECT * FROM tb_payee order by id asc");
//     $select->execute();
//     $result=$select->fetchAll();
//     foreach($result as $row)
//     {
//         $output.='<option value="'.$row["id"].'">'.$row["name"].'</option>';
//     }

//     return $output; 
// }




if (isset($_POST['confirmdeposit'])) 
{

$bankid = $_POST['bankid'];
$particular = $_POST['particular'];
$date = $_POST['date'];
$amount = $_POST['amount'];
$timestamp = date("Y-m-d H:i:s");


$insert = $pdo->prepare("INSERT INTO tb_deposit

  SET 

  bank_id = '$bankid' , 
  description = '$particular' ,
  date = '$date' ,
  amount = '$amount' ,
  deposit_at = '$timestamp' ,
  user_id = '$userid' ");

// $insert->execute();

if($insert->execute())
  {
    $_SESSION['status']="Deposit created successfully!";
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
                    <h5 class="m-0 text-white" ><a href="bank_account.php" class="text-white">View Bank Accounts</a> / <a href="bank_account_details.php?id=<?= $bankid ?>&datenow=<?= $datenow ?>" class="text-white">Bank Details</a> / Deposit</h5>
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
                            <b>Particular : </b>&emsp;
                            <input type="text" class="form-control" name="particular" autocomplete="off" placeholder="Input particular" required>
                          </div>
                          <div class="form-group">
                            <b>Date : </b>&emsp;
                            <input type="date" class="form-control" name="date" required>
                          </div>
                          <div class="form-group">
                            <b>Amount : </b>&emsp;
                            <input type="text" class="form-control" placeholder="Input amount" name="amount" required="">
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
                      <button type="submit" class="btn btn-primary btn-md" name="confirmdeposit">Deposit</button>
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

