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


$checkid = $_GET['id'];
$bankid = $_GET['bankid'];

$select = $pdo->prepare("SELECT * from tb_check where id = $checkid");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);



if (isset($_POST['updatecheck'])) 
{

$checkid = $_POST['checkid'];
$bankid = $_POST['bankid'];
$payeeid = $_POST['payeeid'];
$checknum = $_POST['checknum'];
$description = $_POST['description'];
$checkdate = $_POST['checkdate'];
$checkamount = $_POST['checkamount'];
$checkstatusid = $_POST['checkstatusid'];

$timestamp = date("Y-m-d H:i:s");

// id
// bank_id
// payee_id
// check_date
// payment_date
// check_num
// description
// amount
// created_at
// cleared_at
// cancelled_at
// hold_at
// status_id
// user_id


$update = $pdo->prepare("UPDATE tb_check SET bank_id = '$bankid', payee_id = '$payeeid', check_date = '$checkdate', check_num = '$checknum', description = '$description', amount = '$checkamount', status_id = '$checkstatusid' WHERE id = '$checkid' ");

if($update->execute())
  {
    echo update_check_status($pdo,$checkstatusid,$timestamp,$checkid);
    $_SESSION['status']="Check updated successfully!";
    $_SESSION['status_code']="success";
  }

}


$select = $pdo->prepare("SELECT * from tb_check where id = $checkid");
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
                    <h5 class="m-0 text-white" ><a href="bank_account.php" class="text-white">View Bank Accounts</a> / <a href="bank_account_details.php?id=<?= $bankid ?>&datenow=<?= $datenow ?>" class="text-white">Bank Details</a> / Edit Check</h5>
                </div>
                <!-- card body open --> 
                <form action="" method="post">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">

                    <div class="col-md-6">
                        <li class="list-group-item">
                          <input type="hidden" value="<?= $checkid ?>" name="checkid" >
                          <div class="form-group">
                              <select class="form-control" name="bankid" required>
                              <option value="" disabled selected>Select bank</option>
                              <?php
                                $select=$pdo->prepare("SELECT * FROM tb_bank ");
                                $select->execute();

                                while($row1=$select->fetch(PDO::FETCH_OBJ))
                                {
                                // extract($row);

                                ?>
                                  <option <?php if($row1->id == $row->bank_id  ){ ?>
                                    
                                    selected="selected"
                                    
                                    
                                    <?php }?> value=<?= $row1->id ?> ><?php echo ucfirst($row1->name).' ('.$row1->account_num.')' ;?></option>

                                <?php

                                }

                                ?>
                            </select>
                          </div>
                          <div class="form-group">
                              <select class="form-control" name="payeeid" required>
                              <option value="" disabled selected>Select payee</option>
                              <?php
                                $select=$pdo->prepare("SELECT * FROM tb_payee ");
                                $select->execute();

                                while($row1=$select->fetch(PDO::FETCH_OBJ))
                                {
                                // extract($row);

                                ?>
                                  <option <?php if($row1->id == $row->payee_id  ){ ?>
                                    
                                    selected="selected"
                                    
                                    
                                    <?php }?> value=<?= $row1->id ?> ><?php echo ucfirst($row1->name) ;?></option>

                                <?php

                                }

                                ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <b>Check number : </b>&emsp;
                            <input type="text" autocomplete="off" class="form-control" name="checknum" required="" placeholder="Input check number" value="<?= $row->check_num ?>">
                          </div>
                          <div class="form-group">
                            <b>Description : </b>&emsp;
                            <input type="text" class="form-control" name="description" autocomplete="off" placeholder="Input description" value="<?= $row->description ?>">
                          </div>
                          <div class="form-group">
                            <b>Check date. : </b>&emsp;
                            <input type="date" class="form-control" name="checkdate" required="" value="<?= $row->check_date ?>">
                          </div>
                          <div class="form-group">
                            <b>Amount : </b>&emsp;
                            <input type="text" class="form-control" name="checkamount" autocomplete="off" placeholder="Input amount" required="" value="<?= $row->amount ?>">
                          </div>
                        </li>

                        <br>

                        <li class="list-group-item"><b>User level : </b>&emsp;
                            <select class="form-control" name="checkstatusid" required>
                              <option value="" disabled selected>Check status</option>
                              <?php
                                $select=$pdo->prepare("SELECT * FROM tb_status ");
                                $select->execute();

                                while($row1=$select->fetch(PDO::FETCH_OBJ))
                                {
                                // extract($row);

                                ?>
                                  <option <?php if($row1->id == $row->status_id  ){ ?>
                                    
                                    selected="selected"
                                    
                                    
                                    <?php }?> value=<?= $row1->id ?> ><?php echo ucfirst($row1->name) ;?></option>

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
                      <button type="submit" class="btn btn-success btn-md" name="updatecheck">Update Check</button>
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

