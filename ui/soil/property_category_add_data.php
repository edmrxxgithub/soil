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

$categoryid = $_GET['id'];

$select = $pdo->prepare("SELECT * from tb_property_category where id = $categoryid");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);

$select1 = $pdo->prepare("SELECT id FROM tb_property_data ORDER BY id DESC LIMIT 1");
$select1->execute();
$numcount=$select1->rowCount();


$lastCode = 'P00-00';

function incrementCode($code) 
{
    preg_match('/(\D+)(\d+)-(\d+)/', $code, $matches);

    if ($matches) {
        $prefix = $matches[1]; // "P"
        $middle = $matches[2]; // "00"
        $number = intval($matches[3]); // Convert "001" to 1

        // Increment the number
        $number++;

        // Format back to the original format
        return sprintf("%s%s-%03d", $prefix, $middle, $number);
    }
    
    return false; // Invalid format
}


$nextppe_code = incrementCode($lastCode);


function fill_user($pdo)
{

    $output='';
    $select=$pdo->prepare("SELECT * FROM tb_property_user order by id asc");
    $select->execute();
    $result=$select->fetchAll();
    foreach($result as $row)
    {
        $output.='<option value="'.$row["id"].'">'.$row["name"].'</option>';
    }

    return $output; 
}


function fill_department($pdo)
{

    $output='';
    $select=$pdo->prepare("SELECT * FROM tb_property_department order by id asc");
    $select->execute();
    $result=$select->fetchAll();
    foreach($result as $row)
    {
        $output.='<option value="'.$row["id"].'">'.$row["name"].'</option>';
    }

    return $output; 
}


function fill_brand($pdo)
{

    $output='';
    $select=$pdo->prepare("SELECT * FROM tb_property_brand order by id asc");
    $select->execute();
    $result=$select->fetchAll();
    foreach($result as $row)
    {
        $output.='<option value="'.$row["id"].'">'.$row["name"].'</option>';
    }

    return $output; 
}



if (isset($_POST['add_property_data'])) 
{

$categoryid = $_POST['categoryidhidden'];
$ppe_code = $_POST['ppe_code'];
$userid = $_POST['userid'];

$departmentid = $_POST['departmentid'];
$brandid = $_POST['brandid'];
$modelnum = $_POST['modelnum'];

$accessorydesc = $_POST['accessories_desc'];
$serial_lot_num = $_POST['serial_lot_num'];
$acq_date = $_POST['acq_date'];

$status = $_POST['status'];
$price = $_POST['price'];
$eul = $_POST['eul'];

$userid_session = $_SESSION['userid'];
$timestamp = date("Y-m-d H:i:s");


// echo $categoryid;
// echo '<br>';
// echo $ppe_code;
// echo '<br>';
// echo $userid;
// echo '<br>';
// echo $departmentid;
// echo '<br>';
// echo $brandid;
// echo '<br>';
// echo $modelnum;
// echo '<br>';
// echo $accessorydesc;
// echo '<br>';
// echo $serial_lot_num;
// echo '<br>';
// echo $acq_date;
// echo '<br>';
// echo $status;
// echo '<br>';
// echo $price;
// echo '<br>';
// echo $eul;
// echo '<br>';
// echo $userid_session;
// echo '<br>';
// echo $timestamp;
// echo '<br>';





$insert = $pdo->prepare("INSERT INTO tb_property_data SET 
ppe_code = '$ppe_code' ,
property_user_id = '$userid'  ,
department_id = '$departmentid' ,
category_id = '$categoryid' ,
brand_id = '$brandid'  ,
model_num = '$modelnum' ,
accessories_desc = '$accessorydesc'  ,
serial_num = '$serial_lot_num'  ,
acq_date = '$acq_date'  ,
status = '$status'  ,
price = '$price' ,
eul = '$eul' ,
input_by_user_id = '$userid_session'  ,
created_at = '$timestamp' ");


// $insert = $pdo->prepare("INSERT INTO tb_property_data SET ppe_code = '$ppe_code' ");

    if ($insert->execute()) 
    {
      $_SESSION['status']="Property data created successfully!";
      $_SESSION['status_code']="success";
    }
    else
    {
      $_SESSION['status']="Property data created failed!";
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
                    <h5 class="m-0 text-white" ><a href="property_category_menu.php" class="text-white">View Category</a> / <a href="property_category_details.php?id=<?= $categoryid ?>" class="text-white"><?= $row->name ?></a> / Add Data</h5>
                </div>

                <!-- card body open --> 
                <form action="" method="post" enctype="multipart/form-data">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">

                    <div class="col-md-6">
                        <li class="list-group-item">
                          <div class="form-group">
                            <input type="hidden" value="<?= $categoryid ?>" name="categoryidhidden">
                              <b>Category name : </b>&emsp;
                              <input type="text" class="form-control" disabled value="<?= $row->name ?>">
                          </div>
                          <div class="form-group">
                              <b>PPE-CODE : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" placeholder="Input ppe code"  required name="ppe_code" value="P00-00">
                          </div>
                          <div class="form-group">
                              <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required name="userid">
                                    <option value="">Select User</option>
                                    <?php echo fill_user($pdo);?>
                              </select>
                          </div>
                          <div class="form-group">
                              <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required name="departmentid">
                                    <option value="">Select Department</option>
                                    <?php echo fill_department($pdo);?>
                              </select>
                          </div> 
                          <div class="form-group">
                              <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required name="brandid">
                                    <option value="">Select Brand</option>
                                    <?php echo fill_brand($pdo);?>
                              </select>
                          </div>
                          <div class="form-group">
                              <b>Model No. : </b>&emsp;
                              <input type="text" class="form-control"  autocomplete="off"  name="modelnum">
                          </div>
                          <div class="form-group">
                              <b>Accessory Description. : </b>&emsp;
                              <input type="text" class="form-control"  autocomplete="off" name="accessories_desc">
                          </div> 
                          <div class="form-group">
                              <b>Serial No. / Lot No. : </b>&emsp;
                              <input type="text" class="form-control"  autocomplete="off" name="serial_lot_num">
                          </div> 
                          <div class="form-group">
                              <b>Acquisition Date : </b>&emsp;
                              <input type="date" class="form-control" required autocomplete="off"  name="acq_date">
                          </div> 
                          <div class="form-group">
                              <b>Status : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="status">
                          </div> 
                          <div class="form-group">
                              <b>Cost : </b>&emsp;
                              <input type="text" class="form-control" required autocomplete="off"  name="price">
                          </div> 
                          <div class="form-group">
                              <b>EUL (Estimate Useful Life) : </b>&emsp;
                              <input type="text" class="form-control" required autocomplete="off"  name="eul">
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
                      <button type="submit" class="btn btn-primary btn-md" name="add_property_data">Add Data</button>
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

