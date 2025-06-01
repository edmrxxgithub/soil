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


function fill_supplier($pdo)
{

    $output='';
    $select=$pdo->prepare("SELECT * FROM tb_tax_supplier order by id asc");
    $select->execute();
    $result=$select->fetchAll();
    foreach($result as $row)
    {
        $output.='<option value="'.$row["id"].'">'.$row["name"].'</option>';
    }

    return $output; 

}


// $_SESSION['status']="Purchase input success!";
// $_SESSION['status_code']="success";

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
                    <h5 class="m-0 text-white" ><a href="tax_vat_purchase.php" class="text-white">View VAT Purchase</a> / Add VAT Purchase</h5>
                </div>
                <!-- card body open --> 
                <form action="" method="post">

<?php

if (isset($_POST['addvarpurchase'])) 
{

$clientid = $_POST['clientid'];
$businessid = $_POST['businessid'];
$branchid = $_POST['branchid'];
$supplierid = $_POST['supplierid'];


$date = $_POST['date'];
$exp_classification = $_POST['exp_classification'];
$exp_type = $_POST['exp_type'];
$reference_num = $_POST['reference_num'];


$gross_amount = $_POST['gross_amount'];
$net_amount = $_POST['net_amount_hidden'];
$vat = $_POST['vat_amount_hidden'];

$userid = $_SESSION['userid'];
$timestamp = date("Y-m-d H:i:s");



$insert = $pdo->prepare("INSERT INTO tb_tax_vat_purchase 
SET 

client_id = '$clientid', 
business_id = '$businessid' , 
branch_id = '$branchid' ,
supplier_id =  '$supplierid' ,

date =  '$date' ,
exp_class =  '$exp_classification' ,
exp_type =  '$exp_type' ,
reference_num =  '$reference_num' ,

gross_amount =  '$gross_amount' ,
net_amount =  '$net_amount' ,
vat =  '$vat' ,


created_at = '$timestamp' ,
input_by_user = '$userid' ");

if ($insert->execute()) 
  {
    $_SESSION['status']="Vat purchase input success!";
    $_SESSION['status_code']="success";
  }
  else
  {
    $_SESSION['status']="Vat purchase input fail!";
    $_SESSION['status_code']="error";
  }

  

}

?>



                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">


                    <div class="col-md-6">
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


                          
                            <div class="form-group mt-3">
                                <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="supplierid" id="supplierid">
                                      <option value="">Select supplier</option>
                                      <?php echo fill_supplier($pdo);?>
                                </select>
                            </div>

                            
                            <div class="form-group mt-3">
                              <b>TIN : </b>
                              <input type="text" class="form-control" id="tin_display" disabled>
                            </div>

                            <div class="form-group mt-3">
                              <b>ADDRESS : </b>
                              <input type="text" class="form-control" id="address_display" disabled>
                            </div>


                            <div class="form-group mt-3">
                              <b>Date : </b>
                              <input type="date" class="form-control" name="date" required="" value="2025-03-06">
                            </div>
                            
                            

                            <div class="form-group mt-3">
                              <b>Expenditure Classification : </b>
                              <input type="text" autocomplete="off" class="form-control" name="exp_classification" required="" placeholder="Input expenditure classification" id="exp_classification" value="ADVERTISING AND PROMOTION">
                            </div>
                            <div class="form-group mt-3">
                              <b>Expense Type : </b>
                              <input type="text" autocomplete="off" class="form-control" name="exp_type" required="" placeholder="Input expense type" id="exp_type" value="GOODS">
                            </div>
                            <div class="form-group mt-3">
                              <b>Reference No. : </b>
                              <input type="text" autocomplete="off" class="form-control" name="reference_num" required="" placeholder="Input reference num" id="reference_num" value="310957">
                            </div>
                            
                            <div class="form-group mt-3">
                              <b>Gross Amount : </b>
                              <input type="text" autocomplete="off" class="form-control" name="gross_amount" required="" placeholder="Input gross amount" id="gross_amount" value="">
                            </div>
                            <div class="form-group mt-3">
                              <b>12% VAT : </b>
                              <input type="text" disabled class="form-control" id="vat_amount" name="vat_amount" >
                              <input type="hidden" class="form-control" id="vat_amount_hidden" name="vat_amount_hidden" >
                            </div>
                            <div class="form-group mt-3">
                              <b>Net amount : </b>
                              <input type="text" disabled class="form-control" id="net_amount" name="net_amount" >
                              <input type="hidden" class="form-control" id="net_amount_hidden" name="net_amount_hidden" >
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
                      <button type="submit" class="btn btn-primary btn-md" name="addvarpurchase">Add Vat purchase</button>
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

      // alert('God is good , life is good!');

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





$(document).on('change','#supplierid',function()
{

  var supplierid = $('#supplierid').val();

  // alert(supplierid);
  
  $.ajax({
    // url: 'tax_fetch_data.php',
    url: 'tax_fetch_supplier_data.php',
    type: 'post',
    data:'id='+supplierid,
    dataType:'json',
    success: function(data) 
    {
      // alert(data.supplierid);
      $('#tin_display').val(data.tin);
      $('#address_display').val(data.address);
    }
  });

})

$(document).on('keyup','#gross_amount',function()
{

var gross_amount = $('#gross_amount').val();

$.ajax({
    url: 'tax_compute_netamount.php',
    type: 'post',
    data:'gross_amount='+gross_amount,
    dataType:'json',
    success: function(data) 
    {
      $('#net_amount').val(data.netamount);
      $('#vat_amount').val(data.vat);

      $('#net_amount_hidden').val(data.netamount2);
      $('#vat_amount_hidden').val(data.vat2);

    }
  });


})



})
</script>



