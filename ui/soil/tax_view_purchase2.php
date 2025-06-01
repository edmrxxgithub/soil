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


$purchase_id = $_GET['id'];


$select = $pdo->prepare("SELECT * FROM tb_tax_purchase where id = '$purchase_id' ");
$select->execute();
$rowmain = $select->fetch(PDO::FETCH_OBJ);

$net_of_vat = $rowmain->gross_amount - $rowmain->vat;

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
                    <h5 class="m-0 text-white" ><a href="tax_purchase.php" class="text-white">View Purchase Declaration</a> / View Purchase</h5>
                </div>
                <!-- card body open --> 
                <form action="" method="post">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">


<?php

// echo $purchase_id;

if (isset($_POST['update_purchase'])) 
{

$purchase_id_hidden = $_POST['purchase_id_hidden'];
$clientid = $_POST['clientid'];
$businessid = $_POST['businessid'];
$branchid = $_POST['branchid'];
$supplierid = $_POST['supplierid'];

$date = $_POST['date'];
$tin = $_POST['tin'];

// $order_status = $_POST['order_status'];
// $payment_method = $_POST['payment_method'];
// $net_amount_hidden = $_POST['net_amount_hidden'];
// $vat_amount_hidden = $_POST['vat_amount_hidden'];

$description = $_POST['description'];
$invoice_num = $_POST['invoice_num'];

$timestamp = date("Y-m-d H:i:s");

$gross_amount = $_POST['gross_amount'];
$vat_percent = $_POST['vat_percent'];
$cwt_percent = $_POST['cwt_percent'];
$vwt_percent = $_POST['vwt_percent'];


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



$update = $pdo->prepare("UPDATE tb_tax_purchase SET 

client_id  = '$clientid' ,
business_id  = '$businessid' ,
branch_id  = '$branchid' ,
date   = '$date' ,
tin  = '$tin' ,
description  = '$description' ,
invoice_no   = '$invoice_num' ,


gross_amount  = '$gross_amount'  ,
net_amount   = '$net_of_vat' ,
vat  = '$total_vat' ,

vat_percent = '$vat_percent',
cwt_percent = '$cwt_percent',
vwt_percent = '$vwt_percent',

withholding_total_cwt = '$withholding_total_cwt',
withholding_total_vwt = '$withholding_total_vwt',


input_by_user  = '$userid' ,
created_at = '$timestamp' 

where id = '$purchase_id_hidden'

");

    if ($update->execute()) 
    {
      $_SESSION['status']="Purchase input success!";
      $_SESSION['status_code']="success";
    }
    else
    {
      $_SESSION['status']="Purchase input failed!";
      $_SESSION['status_code']="error";
    }

}

$select = $pdo->prepare("SELECT * FROM tb_tax_purchase where id = '$purchase_id' ");
$select->execute();
$rowmain = $select->fetch(PDO::FETCH_OBJ);

$net_of_vat = $rowmain->gross_amount - $rowmain->vat;

?>




                    <div class="col-md-6">
                        <li class="list-group-item">
                          <input type="hidden" value="<?= $purchase_id ?>" name="purchase_id_hidden" >
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
                                      <option value="">Select business</option>
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
                                      <option value="" disabled >Select branch</option>
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
                              <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="supplierid" id="supplierid">
                                      <option value="" disabled >Select supplier</option>
                                      <?php
                                        $select=$pdo->prepare("SELECT * FROM tb_tax_supplier ");
                                        $select->execute();

                                        while($row1=$select->fetch(PDO::FETCH_OBJ))
                                        {
                                        // extract($row);

                                        ?>
                                          <option <?php if($row1->id == $rowmain->supplier_id  ){ ?>
                                            
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
                              <input type="text" autocomplete="off" class="form-control" id="tin" name="tin" required="" placeholder="Input TIN" value="<?= $rowmain->tin ?>">
                            </div>
                            <div class="form-group mt-3">
                              <b>Description : </b>
                              <input type="text" autocomplete="off" class="form-control" name="description" required="" placeholder="Input description" value="Various Supplier Purchases" value="<?= $rowmain->description ?>">
                            </div>
                            <div class="form-group mt-3">
                              <b>Invoice No. : </b>
                              <input type="text" autocomplete="off" class="form-control" name="invoice_num" required="" placeholder="Input invoice number" value="<?= $rowmain->invoice_no ?>">
                            </div>


                            <div class="form-group mt-5">
                              <b>Gross amount : </b>
                              <input type="text" autocomplete="off" class="form-control" name="gross_amount" required="" placeholder="Input gross amount" id="gross_amount" value="<?= $rowmain->gross_amount ?>">
                            </div>
                            <div class="form-group mt-3">
                              <b>VAT % : </b>
                              <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="vat_percent" id="vat_percent">
                                      <option value="" disabled >Select percent</option>
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
                      <!-- <button type="submit" class="btn btn-primary btn-md" name="update_purchase">Update Purchase</button> -->
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
    url: 'tax_supplier_id.php',
    type: 'post',
    data:'id='+supplierid,
    // dataType:'json',
    success: function(data) 
    {
      $('#tin').val(data);
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









})
</script>



