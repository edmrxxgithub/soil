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


$salesrevenueid_php = $_GET['id'];


$selectmain = $pdo->prepare("SELECT * FROM tb_tax_purchase WHERE id = '$salesrevenueid_php' ");
$selectmain->execute();
$rowmain = $selectmain->fetch(PDO::FETCH_OBJ);

$net_of_vat = $rowmain->gross_amount - $rowmain->vat;

if ($rowmain->vat_percent == 1.12) 
{
  $vat_percent = '12%';
}
else
{
  $vat_percent = '0%';
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

                    <input type="hidden"  name="salesrevenueid" value="<?= $salesrevenueid_php ?>">

                    <div class="col-md-6">
                        <li class="list-group-item">
                          <input type="hidden" value="soil123" name="defaultpassword" >
                            <div class="form-group">
                                <select class="form-control select2" disabled data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="clientid" id="clientid">
                                      <option value="" disabled selected>Select client</option>
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
                              <select class="form-control select2" disabled data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="businessid" id="businessid">
                                      <option value="" disabled selected>Select business</option>
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
                              <select class="form-control select2" disabled data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="branchid" id="branchid">
                                      <option value="" disabled selected>Select branch</option>
                                      <?php
                                        $select=$pdo->prepare("SELECT * FROM tb_tax_branch");
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


                            <div class="form-group mt-5">
                              <b>Date : </b>
                              <input type="date" autocomplete="off" disabled class="form-control" name="date" required="" placeholder="Input date" value="<?= $rowmain->date ?>">
                            </div>
                            <div class="form-group mt-3">
                              <b>TIN : </b>
                              <input type="text" autocomplete="off" disabled  class="form-control" id="tin" name="tin" required="" placeholder="Input TIN" value="<?= $rowmain->tin ?>">
                            </div>
                            <!-- <div class="form-group mt-3">
                              <b>Order status : </b>
                              <input type="text" autocomplete="off" disabled  class="form-control" name="order_status" required="" placeholder="Input order status" value="<?= $rowmain->order_status ?>">
                            </div>
                            <div class="form-group mt-3">
                              <b>Payment method : </b>
                              <input type="text" autocomplete="off" disabled  class="form-control" name="payment_method" required="" placeholder="Input payment method" value="<?= $rowmain->payment_method ?>">
                            </div> -->
                            <div class="form-group mt-3">
                              <b>Description : </b>
                              <input type="text" autocomplete="off" disabled  class="form-control" name="description" required="" placeholder="Input description" value="<?= $rowmain->description ?>">
                            </div>
                            <div class="form-group mt-3">
                              <b>Invoice No. : </b>
                              <input type="text" autocomplete="off"  disabled class="form-control" name="invoice_num" required="" placeholder="Input invoice number " value="<?= $rowmain->invoice_no ?>">
                            </div>


            <div class="form-group mt-5">
              <b>Gross amount : </b>
              <input type="text" autocomplete="off" disabled  class="form-control" name="gross_amount" required="" placeholder="Input gross amount" id="gross_amount" value="<?= number_format($rowmain->gross_amount,2) ?>">
            </div>
            <div class="form-group mt-3">
              <b>VAT % : </b>
              <input type="text" disabled class="form-control" id="vat_amount" name="vat_amount" value="<?= $vat_percent ?>">
            </div>
            <div class="form-group mt-3">
              <b>Vat total : </b>
              <input type="text" disabled class="form-control" id="net_amount" name="net_amount" value="<?= number_format($rowmain->vat,2) ?>">
            </div>
            <div class="form-group mt-3">
              <b>Net of vat : </b>
              <input type="text" disabled class="form-control" id="net_amount" name="net_amount" value="<?= number_format($net_of_vat,2) ?>">
            </div>
            <div class="form-group mt-3">
              <b>CWT % : </b>
              <input type="text" disabled class="form-control" id="net_amount" name="net_amount" value="<?= $rowmain->cwt_percent ?>%">
            </div>
            <div class="form-group mt-3">
              <b>Withholding amount : </b>
              <input type="text" disabled class="form-control" id="net_amount" name="net_amount" value="<?= number_format($rowmain->withholding_total,2) ?>">
            </div>


                        </li>

                    </div>
                    
                  </div>
                  <!-- row close --> 
                </div>  
                <!-- card body close --> 

                <!-- card footer open --> 
                <!-- <div class="card-footer">
                  <div class="text-center">
                      <button type="submit" class="btn btn-primary btn-md" name="updatesalesrevenue">B</button>
                  </div>
                </div> -->
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



