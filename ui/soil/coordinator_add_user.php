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




function fill_client($pdo)
{

    $output='';
    $select=$pdo->prepare("SELECT * FROM tb_tax_client order by id asc");
    $select->execute();
    $result=$select->fetchAll();
    foreach($result as $row)
    {
        $output.='<option value="'.$row["id"].'">'.$row["name"].'</option>';
    }

    return $output; 

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
                    <h5 class="m-0 text-white"><a href="coordinator_view_user.php" class="text-white">View Coordinators</a> / Add Coordinator</h5>
                </div>

<?php

if (isset($_POST['addaccount'])) 
{

$fullname = $_POST['fullname'];
$address = $_POST['address'];
$contactnum = $_POST['contactnum'];

$clientid = $_POST['clientid'];
$businessid = $_POST['businessid'];
$branchid = $_POST['branchid'];

$username = $_POST['username'];
$defaultpassword = $_POST['defaultpassword'];
$userlevelid = $_POST['userlevelid'];

echo $fullname.' '.$address.' '.$contactnum.' '.$clientid.' '.$businessid.' '.$branchid.' '.$username.' '.$defaultpassword.' '.$userlevelid;


$insert = $pdo->prepare("INSERT INTO tb_user SET 

username = '$username' ,
password = '$defaultpassword' ,
name = '$fullname' ,
address = '$address' ,
contact_num = '$contactnum' ,
user_level_id = '$userlevelid' ,
client_id = '$clientid' ,
business_id = '$businessid' ,
branch_id = '$branchid' ,
status = '1' ");



  if($insert->execute())
  {
    $_SESSION['status']="Account created successfully!";
    $_SESSION['status_code']="success";
  }
  else
  {
    $_SESSION['status']="Account created failed!";
    $_SESSION['status_code']="error";
  }

}


?>



                <!-- card body open --> 
                <form action="" method="post">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">



                    <div class="col-md-6">
                        <li class="list-group-item">
                          <input type="hidden" value="soil123" name="defaultpassword" >
                          <input type="hidden" value="3" name="userlevelid" >
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
                                <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="clientid" id="clientid">
                                      <option value="">Select client</option>
                                      <?php echo fill_client($pdo);?>
                                </select>
                            </div>
                            <div class="form-group mt-3">
                              <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="businessid" id="businessid">
                                      <option value="">Select business</option>
                                </select>
                            </div>
                            <div class="form-group mt-3">
                              <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="branchid" id="branchid">
                                      <option value="">Select branch</option>
                                </select>
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
                          <div class="form-group">
                            <b>User level : </b>&emsp;
                            <input type="text" class="form-control" autocomplete="off" name="#" value="Coordinator" disabled>
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



<script type="text/javascript">
  
  //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })


$(document).ready(function()
{

$(document).on('change','#clientid',function()
{

  var clientid = $('#clientid').val();
  
  $.ajax({
    url: 'tax_fetch_data.php',
    type: 'post',
    data:'id='+clientid,
    dataType:'json',
    success: function(data) 
    {
      // alert(data.businessid);
      $('#businessid').html(data.businessid);
    }
  });

})




$(document).on('change','#businessid',function()
{

  var businessid = $('#businessid').val();

  // alert(businessid);
  
  $.ajax({
    url: 'tax_fetch_data.php',
    type: 'post',
    data:'id='+businessid,
    dataType:'json',
    success: function(data) 
    {
      $('#tin').val(data.tin);
      $('#branchid').html(data.branchid);
    }
  });

})



})



</script>
