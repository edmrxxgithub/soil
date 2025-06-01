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


$property_data_id = $_GET['id'];


$select = $pdo->prepare("SELECT * FROM tb_property_data WHERE id = '$property_data_id' ");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);


$categoryname = fetch_property_category_name($pdo,$row->category_id);


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


if (isset($_POST['update_property_data'])) 
{

$propertydata_id = $_POST['propertydataidhidden'];
$categoryid = $_POST['categoryid'];
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





$update = $pdo->prepare("UPDATE tb_property_data SET 
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
eul = '$eul' WHERE id = '$propertydata_id' ");


// $insert = $pdo->prepare("INSERT INTO tb_property_data SET ppe_code = '$ppe_code' ");

    if ($update->execute()) 
    {
      $_SESSION['status']="Property data updated successfully!";
      $_SESSION['status_code']="success";
    }
    else
    {
      $_SESSION['status']="Property data updated failed!";
      $_SESSION['status_code']="error";
    }


}


$select = $pdo->prepare("SELECT * FROM tb_property_data WHERE id = '$property_data_id' ");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);


$categoryname = fetch_property_category_name($pdo,$row->category_id);

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
                    <h5 class="m-0 text-white" ><a href="property_category_menu.php" class="text-white">View Category</a> / <a href="property_category_details.php?id=<?= $row->category_id ?>" class="text-white"><?= $categoryname ?></a> / Edit Data</h5>
                </div>

<?php

// echo $row->category_id;

?>

                <!-- card body open --> 
                <form action="" method="post" enctype="multipart/form-data">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">

                    <div class="col-md-6">
                        <li class="list-group-item">
                          <div class="form-group">
                            <input type="hidden" value="<?= $property_data_id ?>" name="propertydataidhidden">
                              <select class="form-control select2" data-dropdown-css-class="select2-purple" name="categoryid" required>
                              <option value="" disabled selected>Select category</option>
                              <?php
                                $select=$pdo->prepare("SELECT * FROM tb_property_category ");
                                $select->execute();

                                while($row1=$select->fetch(PDO::FETCH_OBJ))
                                {
                                // extract($row);

                                ?>
                                  <option <?php if($row1->id == $row->category_id){ ?>
                                    
                                    selected="selected"
                                    
                                    
                                    <?php }?> value=<?= $row1->id ?> ><?= ucfirst($row1->name) ;?></option>

                                <?php

                                }

                                ?>
                            </select>
                          </div>
                          <div class="form-group">
                              <b>PPE-CODE : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" placeholder="Input ppe code"  required name="ppe_code" value="<?= $row->ppe_code ?>">
                          </div>
                          <div class="form-group">
                              <select class="form-control select2" data-dropdown-css-class="select2-purple" name="userid" required>
                              <option value="" disabled selected>Select user</option>
                              <?php
                                $select=$pdo->prepare("SELECT * FROM tb_property_user");
                                $select->execute();

                                while($row1=$select->fetch(PDO::FETCH_OBJ))
                                {
                                // extract($row);

                                ?>
                                  <option <?php if($row1->id == $row->property_user_id){ ?>
                                    
                                    selected="selected"
                                    
                                    
                                    <?php }?> value=<?= $row1->id ?> ><?= ucfirst($row1->name) ;?></option>

                                <?php

                                }

                                ?>
                            </select>
                          </div>
                          <div class="form-group">
                              <select class="form-control select2" data-dropdown-css-class="select2-purple" name="departmentid" required>
                              <option value="" disabled selected>Select department</option>
                              <?php
                                $select=$pdo->prepare("SELECT * FROM tb_property_department");
                                $select->execute();

                                while($row1=$select->fetch(PDO::FETCH_OBJ))
                                {
                                // extract($row);

                                ?>
                                  <option <?php if($row1->id == $row->department_id){ ?>
                                    
                                    selected="selected"
                                    
                                    
                                    <?php }?> value=<?= $row1->id ?> ><?= ucfirst($row1->name) ;?></option>

                                <?php

                                }

                                ?>
                            </select>
                          </div> 
                          <div class="form-group">
                              <select class="form-control select2" data-dropdown-css-class="select2-purple" name="brandid" required>
                              <option value="" disabled selected>Select brand</option>
                              <?php
                                $select=$pdo->prepare("SELECT * FROM tb_property_brand");
                                $select->execute();

                                while($row1=$select->fetch(PDO::FETCH_OBJ))
                                {
                                // extract($row);

                                ?>
                                  <option <?php if($row1->id == $row->brand_id){ ?>
                                    
                                    selected="selected"
                                    
                                    
                                    <?php }?> value=<?= $row1->id ?> ><?= ucfirst($row1->name) ;?></option>

                                <?php

                                }

                                ?>
                            </select>
                          </div>
                          <div class="form-group">
                              <b>Model No. : </b>&emsp;
                              <input type="text" class="form-control"  autocomplete="off" name="modelnum" value="<?= $row->model_num ?>">
                          </div>
                          <div class="form-group">
                              <b>Accessory Description. : </b>&emsp;
                              <input type="text" class="form-control"  autocomplete="off" name="accessories_desc" value="<?= $row->accessories_desc ?>">
                          </div> 
                          <div class="form-group">
                              <b>Serial No. / Lot No. : </b>&emsp;
                              <input type="text" class="form-control"  autocomplete="off" name="serial_lot_num" value="<?= $row->serial_num ?>">
                          </div> 
                          <div class="form-group">
                              <b>Acquisition Date : </b>&emsp;
                              <input type="date" class="form-control" required autocomplete="off"  name="acq_date" value="<?= $row->acq_date ?>">
                          </div> 
                          <div class="form-group">
                              <b>Status : </b>&emsp;
                              <input type="text" class="form-control" autocomplete="off" name="status" value="<?= $row->status ?>">
                          </div> 
                          <div class="form-group">
                              <b>Cost : </b>&emsp;
                              <input type="text" class="form-control" required autocomplete="off" name="price" value="<?= $row->price ?>">
                          </div> 
                          <div class="form-group">
                              <b>EUL (Estimate Useful Life) : </b>&emsp;
                              <input type="text" class="form-control" required autocomplete="off"  name="eul" value="<?= $row->eul ?>">
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
                      <button type="submit" class="btn btn-primary btn-md" name="update_property_data">Update Data</button>
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

