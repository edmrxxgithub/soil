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


function fetch_customer_data($pdo,$customerid)
{
  $select = $pdo->prepare("SELECT * FROM tb_tax_customer where id = '$customerid' ");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);

  $array['tin'] = $row->tin;
  $array['address'] = $row->address;
  $array['description'] = $row->name;

  return $array;

}


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



function fill_vat_percent($pdo)
{

    $output='';
    $select=$pdo->prepare("SELECT * FROM tb_tax_vat_percent order by id asc");
    $select->execute();
    $result=$select->fetchAll();
    foreach($result as $row)
    {
        $output.='<option value="'.$row["vat_value"].'">'.$row["description"].'</option>';
    }

    return $output; 

}



$sales_id = $_GET['id'];



$select = $pdo->prepare("SELECT * FROM tb_tax_sales where id = '$sales_id' ");
$select->execute();
$rowmain = $select->fetch(PDO::FETCH_OBJ);


$customerdataf = fetch_customer_data($pdo,$rowmain->customer_id);

// $net_of_vat = $rowmain->gross_amount - $rowmain->vat;


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
                    <h5 class="m-0 text-white" ><a href="tax_sales_revenue.php" class="text-white">View Sales Revenue</a> / Edit Sales Revenue</h5>
                </div>
                <!-- card body open --> 
                <form action="" method="post">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">




<?php



if (isset($_POST['update_sales_revenue'])) 
{




// gross_amount
// vat_percent
// cwt_percent
$sales_id_hidden = $_POST['sales_id_hidden'];

$clientid = $_POST['clientid'];
$businessid = $_POST['businessid'];
$branchid = $_POST['branchid'];
$customerid = $_POST['customerid'];
$customerdataf = fetch_customer_data($pdo,$customerid);

$date = $_POST['date'];

// $tin = $_POST['tin'];
// $description = $_POST['description'];

$tin = $customerdataf['tin'];
$description = $customerdataf['description'];

$order_status = $_POST['order_status'];
$payment_method = $_POST['payment_method'];


$invoice_num = $_POST['invoice_num'];

$timestamp = date("Y-m-d H:i:s");

$gross_amount = $_POST['gross_amount'];
$vat_percent = $_POST['vat_percent'];
$cwt_percent = $_POST['cwt_percent'];
$vwt_percent = $_POST['vwt_percent'];



// if ($vat_percent == 0) 
// {
//   $cwt_percent_new = $cwt_percent / 100;
//   $vwt_percent_new = $vwt_percent / 100;

//   $net_of_vat_new = $gross_amount;
//   $total_vat_new = $gross_amount - $net_of_vat_new;

//   $withholding_total_cwt = $cwt_percent_new * $net_of_vat_new;
//   $withholding_total_vwt = $vwt_percent_new * $net_of_vat_new;
// }
// else
// {
//   $cwt_percent_new = $cwt_percent / 100;
//   $vwt_percent_new = $vwt_percent / 100;

//   $net_of_vat_new = $gross_amount / $vat_percent;
//   $total_vat_new = $gross_amount - $net_of_vat_new;

//   $withholding_total_cwt = $cwt_percent_new * $net_of_vat_new;
//   $withholding_total_vwt = $vwt_percent_new * $net_of_vat_new;
// }


// $cwt_rate = $cwt_percent / 100;
// $net_of_vat = ($vat_percent == 0) ? $gross_amount : $gross_amount / $vat_percent;
// $total_vat = $gross_amount - $net_of_vat;
// $withholding_total = $cwt_rate * $net_of_vat;



// Convert percentages to decimal
$cwt_rate = $cwt_percent / 100;
$vwt_rate = $vwt_percent / 100;

// Calculate net of VAT
$net_of_vat = ($vat_percent == 0) ? $gross_amount : $gross_amount / $vat_percent;

// Calculate total VAT
$total_vat = $gross_amount - $net_of_vat;

// Calculate withholding amounts
$withholding_total_cwt = $cwt_rate * $net_of_vat;
$withholding_total_vwt = $vwt_rate * $net_of_vat;


$update = $pdo->prepare("UPDATE tb_tax_sales SET 

client_id  = '$clientid' ,
business_id  = '$businessid' ,
branch_id  = '$branchid' ,
customer_id = '$customerid',
date   = '$date' ,
tin  = '$tin' ,
order_status   = '$order_status' ,
payment_method   = '$payment_method' ,
description  = '$description' ,
invoice_no   = '$invoice_num' ,


gross_amount  = '$gross_amount'  ,
net_amount   = '$net_of_vat' ,
vat  = '$total_vat' ,

vat_percent = '$vat_percent' ,
cwt_percent = '$cwt_percent' ,
vwt_percent = '$vwt_percent' ,

withholding_total_cwt = '$withholding_total_cwt' ,
withholding_total_vwt = '$withholding_total_vwt' ,

input_by_user  = '$userid' ,
created_at = '$timestamp' 

where id = '$sales_id_hidden'

");

    if ($update->execute()) 
    {
      $_SESSION['status']="Sales revenue input success!";
      $_SESSION['status_code']="success";
    }
    else
    {
      $_SESSION['status']="Sales revenue input failed!";
      $_SESSION['status_code']="error";
    }

}



$select = $pdo->prepare("SELECT * FROM tb_tax_sales where id = '$sales_id' ");
$select->execute();
$rowmain = $select->fetch(PDO::FETCH_OBJ);

$net_of_vat = $rowmain->gross_amount - $rowmain->vat;


// id
// client_id
// business_id
// branch_id
// date
// tin
// order_status
// payment_method
// description
// invoice_no


// gross_amount
// net_amount
// vat
// vat_percent
// cwt_percent
// vwt_percent


// withholding_total_cwt
// withholding_total_vwt
// input_by_user
// created_at



?>




                    <div class="col-md-6">
                        <li class="list-group-item">

                          <input type="hidden" value="<?= $sales_id ?>" name="sales_id_hidden" >

                            <div class="form-group">
                                <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="clientid" id="clientid">
                                      <option value="" disabled >Select client</option>
                                      <?php
                                        $select=$pdo->prepare("SELECT * FROM tb_tax_client ");
                                        $select->execute();

                                        while($row1=$select->fetch(PDO::FETCH_OBJ))
                                        {
                                        // extract($row);

                                        ?>
                                          <option <?php if($row1->id == $rowmain->client_id  ){ ?>
                                            
                                            selected="selected"
                                            
                                            
                                            <?php }?> value=<?= $row1->id ?> ><?php echo ucfirst($row1->name) ;?></option>

                                        <?php

                                        }

                                        ?>
                                </select>
                            </div>
                            <div class="form-group mt-3">
                              <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="businessid" id="businessid">
                                      <option value="" disabled >Select business</option>
                                      <?php
                                        $select=$pdo->prepare("SELECT * FROM tb_tax_business ");
                                        $select->execute();

                                        while($row1=$select->fetch(PDO::FETCH_OBJ))
                                        {
                                        // extract($row);

                                        ?>
                                          <option <?php if($row1->id == $rowmain->business_id  ){ ?>
                                            
                                            selected="selected"
                                            
                                            
                                            <?php }?> value=<?= $row1->id ?> ><?php echo ucfirst($row1->name) ;?></option>

                                        <?php

                                        }

                                        ?>
                                </select>
                            </div>
                            <div class="form-group mt-3">
                              <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="branchid" id="branchid">
                                      <option value="" disabled>Select branch</option>
                                      <?php
                                        $select=$pdo->prepare("SELECT * FROM tb_tax_branch ");
                                        $select->execute();

                                        while($row1=$select->fetch(PDO::FETCH_OBJ))
                                        {
                                        // extract($row);

                                        ?>
                                          <option <?php if($row1->id == $rowmain->branch_id  ){ ?>
                                            
                                            selected="selected"
                                            
                                            
                                            <?php }?> value=<?= $row1->id ?> ><?php echo ucfirst($row1->address) ;?></option>

                                        <?php

                                        }

                                        ?>
                                </select>
                            </div>


                            <div class="form-group mt-3">
                              <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="customerid" id="customerid">
                                      <option value="" disabled>Select branch</option>
                                      <?php
                                        $select=$pdo->prepare("SELECT * FROM tb_tax_customer ");
                                        $select->execute();

                                        while($row1=$select->fetch(PDO::FETCH_OBJ))
                                        {
                                        // extract($row);

                                        ?>
                                          <option <?php if($row1->id == $rowmain->customer_id  ){ ?>
                                            
                                            selected="selected"
                                            
                                            
                                            <?php }?> value=<?= $row1->id ?> ><?php echo ucfirst($row1->name) ;?></option>

                                        <?php

                                        }

                                        ?>
                                </select>
                            </div>

                            <div class="form-group mt-5">
                              <b>Date : </b>
                              <input type="date" autocomplete="off" class="form-control" name="date" required="" placeholder="Input date" value="<?= $rowmain->date ?>">
                            </div>
                            <div class="form-group mt-3">
                              <b>TIN : </b>
                              <input type="text" autocomplete="off" class="form-control" id="tin" disabled required="" placeholder="Input TIN" value="<?= $customerdataf['tin'] ?>">
                            </div>
                            <div class="form-group mt-3">
                              <b>Address : </b>
                              <input type="text" autocomplete="off" class="form-control" id="address" disabled required="" placeholder="Input TIN" value="<?= $customerdataf['address'] ?>">
                            </div>
                            <div class="form-group mt-3">
                              <b>Order status : </b>
                              <input type="text" autocomplete="off" class="form-control" name="order_status" required="" placeholder="Input order status" value="<?= $rowmain->order_status ?>">
                            </div>
                            <div class="form-group mt-3">
                              <b>Payment method : </b>
                              <input type="text" autocomplete="off" class="form-control" name="payment_method" required="" placeholder="Input payment method" value="<?= $rowmain->payment_method ?>">
                            </div>
                            <div class="form-group mt-3">
                              <b>Description : </b>
                              <input type="text" autocomplete="off" class="form-control" id="description" disabled required="" placeholder="Input description" value="<?= $customerdataf['description'] ?>">
                            </div>
                            <div class="form-group mt-3">
                              <b>Invoice No. : </b>
                              <input type="text" autocomplete="off" class="form-control" name="invoice_num" required="" placeholder="Input invoice number " value="<?= $rowmain->invoice_no ?>">
                            </div>


                            <div class="form-group mt-5">
                              <b>Gross amount : </b>
                              <input type="text" autocomplete="off" class="form-control" name="gross_amount" required="" placeholder="Input gross amount" id="gross_amount" value="<?= $rowmain->gross_amount ?>">
                            </div>
                            <div class="form-group mt-3">
                              <b>VAT % : </b>
                              <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="vat_percent" id="vat_percent">
                                      <option value="" disabled>Select percent</option>
                                      <?php
                                        $select=$pdo->prepare("SELECT * FROM tb_tax_vat_percent ");
                                        $select->execute();

                                        while($row1=$select->fetch(PDO::FETCH_OBJ))
                                        {
                                        // extract($row);

                                        ?>
                                          <option <?php if($row1->vat_value == $rowmain->vat_percent  ){ ?>
                                            
                                            selected="selected"
                                            
                                            
                                            <?php }?> value=<?= $row1->vat_value ?> ><?php echo ucfirst($row1->description) ;?></option>

                                        <?php

                                        }

                                        ?>
                                </select>
                            </div>
            <div class="form-group mt-3">
              <b>Total vat : </b>
              <input type="text" disabled class="form-control" id="total_vat_amount" name="total_vat_amount" value="<?= number_format($rowmain->vat,2) ?>">
            </div>

              <div class="form-group mt-3">
                <b>Net of vat : </b>
                <input type="text" disabled class="form-control" id="net_of_vat_amount" name="net_of_vat_amount" value="<?= number_format($net_of_vat,2) ?>">
                <input type="hidden" class="form-control" id="net_of_vat_amount_hidden" name="net_of_vat_amount_hidden" value="<?= $net_of_vat ?>">
              </div>

                            <!-- <div class="form-group mt-3">
                              <b>CWT % : </b>
                              <input type="text" class="form-control" id="cwt_percent" name="cwt_percent" value="0">
                            </div> -->

                             <!-- <div class="form-group mt-3">
                              <b>Withholding Amount : </b>
                              <input type="text" disabled class="form-control" id="withholding_amount" name="withholding_amount" >
                            </div> -->

                            <div class="form-group mt-3">
                              <div class="row">
                                  <div class="col-md-6"><b>CWT % : </b>
                                      <input type="text" class="form-control" id="cwt_percent" name="cwt_percent" value="<?= $rowmain->cwt_percent ?>">
                                  </div>
                                  <div class="col-md-6"><b>VWT % : </b>
                                      <input type="text" class="form-control" id="vwt_percent" name="vwt_percent" value="<?= $rowmain->vwt_percent ?>">
                                  </div>
                              </div>
                            </div>

                           


          <div class="form-group mt-3">
            <div class="row">
                <div class="col-md-6">
                     <div class="form-group mt-3">
                        <b>Withholding Amount (CWT) : </b>
                        <input type="text" disabled class="form-control" id="withholding_amount_cwt" name="withholding_amount_cwt" value="<?= number_format($rowmain->withholding_total_cwt,2) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                     <div class="form-group mt-3">
                        <b>Withholding Amount (VWT) : </b>
                        <input type="text" disabled class="form-control" id="withholding_amount_vwt" name="withholding_amount_vwt" value="<?= number_format($rowmain->withholding_total_vwt,2) ?>">
                    </div>
                </div>
            </div>
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
                      <button type="submit" class="btn btn-primary btn-md" name="update_sales_revenue">Update Sales Revenue</button>
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




function computeTax() 
{
    let gross_amount = $('#gross_amount').val();
    let vat_percent = $('#vat_percent').val();
    let net_of_vat_amount_hidden = $('#net_of_vat_amount_hidden').val();

    $.post('tax_compute_netamount2.php', 
    {
        gross_amount: gross_amount,
        vat_percent: vat_percent
    }, function(data) 
    {
        $('#total_vat_amount').val(data.total_vat);
        $('#net_of_vat_amount').val(data.net_of_vat);
        $('#net_of_vat_amount_hidden').val(data.net_of_vat_hidden);
    }, 'json');



}

function computeWithholding(inputId, outputId) 
{

    let percent = $(inputId).val();
    let net_of_vat_amount_hidden = $('#net_of_vat_amount_hidden').val();

    $.post('tax_compute_netamount3.php', 
    {
        cwt_percent: percent,
        net_of_vat_amount_hidden: net_of_vat_amount_hidden

    }, 
    function(data) 
    {
        $(outputId).val(data.withholding_amount);
    }, 

    'json'

    );

}




// Events
$(document).on('keyup', '#gross_amount', computeTax);
$(document).on('change', '#vat_percent', computeTax);

$(document).on('keyup', '#cwt_percent', function() {
    computeWithholding('#cwt_percent', '#withholding_amount_cwt');
});

$(document).on('keyup', '#vwt_percent', function() {
    computeWithholding('#vwt_percent', '#withholding_amount_vwt');
});






$(document).on('change','#customerid',function()
{

  var customerid = $('#customerid').val();

  // alert(customerid);
  
  $.ajax({
    // url: 'tax_fetch_data.php',
    url: 'tb_tax_fetch_data1.php',
    type: 'post',
    data:'id='+customerid,
    dataType:'json',
    success: function(data) 
    {

      $('#tin').val(data.tin);
      $('#address').val(data.address);
      $('#description').val(data.description)
    }
  });

})

// $(document).on('keyup','#gross_amount',function()
// {

// var gross_amount = $('#gross_amount').val();

// $.ajax({
//     url: 'tax_compute_netamount.php',
//     type: 'post',
//     data:'gross_amount='+gross_amount,
//     dataType:'json',
//     success: function(data) 
//     {
//       $('#net_amount').val(data.netamount);
//       $('#vat_amount').val(data.vat);

//       $('#net_amount_hidden').val(data.netamount2);
//       $('#vat_amount_hidden').val(data.vat2);

//     }
//   });


// })










// $(document).on('keyup','#gross_amount',function()
// {

// var gross_amount = $('#gross_amount').val();
// var vat_percent = $('#vat_percent').val();

// $.ajax({
//     url: 'tax_compute_netamount2.php',
//     type: 'post',
//     data:'gross_amount='+gross_amount+
//          '&vat_percent='+vat_percent,
//     dataType:'json',
//     success: function(data) 
//     {
//       $('#total_vat_amount').val(data.total_vat)
//       $('#net_of_vat_amount').val(data.net_of_vat);
//       $('#net_of_vat_amount_hidden').val(data.net_of_vat_hidden);
//     }
//   });


// })






// $(document).on('change','#vat_percent',function()
// {

// var gross_amount = $('#gross_amount').val();
// var vat_percent = $('#vat_percent').val();

// $.ajax({
//     url: 'tax_compute_netamount2.php',
//     type: 'post',
//     data:'gross_amount='+gross_amount+
//          '&vat_percent='+vat_percent,
//     dataType:'json',
//     success: function(data) 
//     {
//       $('#total_vat_amount').val(data.total_vat)
//       $('#net_of_vat_amount').val(data.net_of_vat);
//       $('#net_of_vat_amount_hidden').val(data.net_of_vat_hidden);
//     }
//   });



// })







// $(document).on('keyup','#cwt_percent',function()
// {

// var cwt_percent = $('#cwt_percent').val();
// var net_of_vat_amount_hidden = $('#net_of_vat_amount_hidden').val();


// $.ajax({
//     url: 'tax_compute_netamount3.php',
//     type: 'post',
//     data:'cwt_percent='+cwt_percent+
//          '&net_of_vat_amount_hidden='+net_of_vat_amount_hidden,
//     dataType:'json',
//     success: function(data) 
//     {
//       $('#withholding_amount_cwt').val(data.withholding_amount);
//     }
//   });



// })


// $(document).on('keyup','#vwt_percent',function()
// {

// var vwt_percent = $('#vwt_percent').val();
// var net_of_vat_amount_hidden = $('#net_of_vat_amount_hidden').val();

// $.ajax({
//     url: 'tax_compute_netamount3.php',
//     type: 'post',
//     data:'cwt_percent='+vwt_percent+
//          '&net_of_vat_amount_hidden='+net_of_vat_amount_hidden,
//     dataType:'json',
//     success: function(data) 
//     {
//       $('#withholding_amount_vwt').val(data.withholding_amount);
//     }
//   });



// })






})
</script>



