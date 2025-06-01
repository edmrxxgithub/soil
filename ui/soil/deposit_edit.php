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


$depositid = $_GET['id'];


$select = $pdo->prepare("SELECT * from tb_deposit where id = '$depositid' ");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);






if (isset($_POST['updatedeposit'])) 
{

$depositid = $_POST['depositid'];
$bankid = $_POST['bankid'];
$particular = $_POST['particular'];
$amount = $_POST['amount'];
$timestamp = date("Y-m-d H:i:s");

// echo $fullname.' '.$address.' '.$contactnum.' '.$username.' '.$defaultpassword.' '.$userlevelid;

  $insert = $pdo->prepare("UPDATE tb_deposit SET bank_id = '$bankid' , description = '$particular' , amount = '$amount' , user_id = '$userid' WHERE id = '$depositid' ");

  if($insert->execute())
  {
    $_SESSION['status']="Deposit updated successfully!";
    $_SESSION['status_code']="success";
  }
  else
  {
    $_SESSION['status']="Deposit updated failed!";
    $_SESSION['status_code']="error";
  }

}


$select = $pdo->prepare("SELECT * from tb_deposit where id = '$depositid' ");
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
                    <h5 class="m-0 text-white" ><a href="deposit.php" class="text-white">View Deposits</a> / Edit Deposit</h5>
                </div>
                <!-- card body open --> 
                <form action="" method="post">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">

                    <div class="col-md-6">
                        <li class="list-group-item">
                          <input type="hidden" value="<?= $depositid ?>" name="depositid" >
                          <div class="form-group">
                              <select class="form-control select2" name="bankid" data-dropdown-css-class="select2-purple" required>
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
                            <b>Particular : </b>&emsp;
                            <input type="text" class="form-control" value="<?= $row->description ?>" required="" autocomplete="off" name="particular" placeholder="Input particular">
                          </div>
                          <div class="form-group">
                            <b>Amount : </b>&emsp;
                            <input type="text" class="form-control" value="<?= $row->amount ?>" required="" autocomplete="off" name="amount" placeholder="Input amount">
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
                      <button type="submit" class="btn btn-primary btn-md" name="updatedeposit">Update deposit</button>
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

