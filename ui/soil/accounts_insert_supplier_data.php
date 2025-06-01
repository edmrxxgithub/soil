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
  $user_id = $_SESSION['userid'];
}


include_once "header.php";

$id = $_GET['id'];


$select = $pdo->prepare("SELECT * FROM tb_account_supplier where id = '$id' ");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);




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



<?php

if (isset($_POST['add_payable'])) 
{
    

$id = $_POST['payableid_hidden'];
$date = $_POST['supplier_date'];
$invoice_num = $_POST['supplier_invoice_num'];

$qty = $_POST['supplier_qty'];
$price = $_POST['supplier_price'];
$total = $_POST['supplier_total_hidden'];

$timestamp = date("Y-m-d H:i:s");
$net_of_vat = $total / 1.12;

$vat = $total - $net_of_vat;


// echo $id.' '.$date.'  '.$invoice_num.' '.$qty.' '.$price.' '.$total.' '.$user_id.' '.$timestamp.' '.$net_of_vat.' '.$vat;



$insert = 

$pdo->prepare("INSERT INTO tb_account_supplier_data SET

account_supplier_id  = '$id' , 
date = '$date' , 
invoice_num = '$invoice_num' , 
qty = '$qty' , 
price = '$price' , 
total = '$total' , 
vat = '$vat' , 
net_of_vat = '$net_of_vat' , 
created_at = '$timestamp' , 
user_id = '$user_id' , 
status  = '0' ");



  if ($insert->execute()) 
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



            <div class="card card-grey card-outline">
                <div class="card-header" style="background-color:rgba(50,63,81,255);">
                    <h5 class="m-0 text-white" ><a href="accounts_payables.php" class="text-white">View Payable Suppliers</a> / <a href="accounts_payables_view_supplier.php?id=<?= $id ?>" class="text-white"><?= $row->name ?></a> / Add data</h5>
                </div>
                <!-- card body open --> 
                <form action="" method="post">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">



                    <div class="col-md-6">
                        <li class="list-group-item">

                          <input type="hidden" value="<?= $id ?>" name="payableid_hidden" >
                            <div class="form-group">
                                <b>Date: </b>&emsp;
                                <input type="date"  class="form-control" required  id="supplier_date"  name="supplier_date">
                            </div>
                            <div class="form-group">
                                <b>Invoice No. : </b>&emsp;
                                <input type="text"  class="form-control" required autocomplete="off" id="supplier_invoice_num"  name="supplier_invoice_num">
                            </div>
                            <div class="form-group">
                                <b>Unit of measure / Qty : </b>&emsp;
                                <input type="text"  class="form-control" required autocomplete="off" value="0" id="supplier_qty" name="supplier_qty">
                            </div>
                            <div class="form-group">
                                <b>Price : </b>&emsp;
                                <input type="text"  class="form-control" required autocomplete="off" value="0" id="supplier_price"  name="supplier_price">
                            </div>
                            <div class="form-group">
                                <b>Total : </b>&emsp;
                                <input type="text" disabled class="form-control" id="supplier_total"  >
                                <input type="hidden" class="form-control" value="0" id="supplier_total_hidden"  name="supplier_total_hidden">
                            </div>
                            <div class="form-group">
                                <b>Vat (12%) </b>&emsp;
                                <input type="text"  class="form-control" disabled id="supplier_vat" >
                            </div>
                            <div class="form-group">
                                <b>Net of Vat</b>&emsp;
                                <input type="text"  class="form-control" disabled id="supplier_net_of_vat">
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
                      <button type="submit" class="btn btn-primary btn-md" name="add_payable">Add Payable</button>
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
  $(document).ready(function()
  {

$(document).on('keyup','#supplier_qty',function()
{

      var supplier_qty = $('#supplier_qty').val();
      var supplier_price = $('#supplier_price').val();

      total = supplier_qty * supplier_price;

      net_of_vat = total / 1.12;

      vat = total - net_of_vat;

      formatted_price = total.toLocaleString('en-US', 
      {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });


      formatted_net_of_vat = net_of_vat.toLocaleString('en-US', 
      {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });

      formatted_vat = vat.toLocaleString('en-US', 
      {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });

      $('#supplier_total_hidden').val(total);
      $('#supplier_total').val(formatted_price);
      $('#supplier_net_of_vat').val(formatted_net_of_vat);
      $('#supplier_vat').val(formatted_vat);

})

$(document).on('keyup','#supplier_price',function()
{

      var supplier_qty = $('#supplier_qty').val();
      var supplier_price = $('#supplier_price').val();

      total = supplier_qty * supplier_price;

      net_of_vat = total / 1.12;

      vat = total - net_of_vat;

      formatted_price = total.toLocaleString('en-US', 
      {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });


      formatted_net_of_vat = net_of_vat.toLocaleString('en-US', 
      {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });

      formatted_vat = vat.toLocaleString('en-US', 
      {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });

      $('#supplier_total_hidden').val(total);
      $('#supplier_total').val(formatted_price);
      $('#supplier_net_of_vat').val(formatted_net_of_vat);
      $('#supplier_vat').val(formatted_vat);

})



  })
</script>


