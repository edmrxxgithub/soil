<?php
include_once 'connectdb.php';
include_once 'function.php';
session_start();


function fetch_collectables_purchase($pdo,$id)
{
  $select = $pdo->prepare("SELECT SUM(total) as total_gross_collectables FROM tb_account_customer_data where account_customer_id = '$id' ");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);

  return $row->total_gross_collectables;
}


function fetch_total_payment($pdo,$id)
{
  $select = $pdo->prepare("SELECT SUM(amount) as total_paid FROM tb_account_customer_payment where account_customer_id = '$id' ");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);

  return $row->total_paid;
  // return 777;
}


if($_SESSION['userid']=="" )
{

header('location:../../index.php');

}
else
{
  $id = $_SESSION['userid'];
}


include_once "header.php";

$customer_id = $_GET['id'];

$select = $pdo->prepare("SELECT * FROM tb_account_customer where id = '$customer_id' ");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$gross_total_collectables = fetch_collectables_purchase($pdo,$customer_id);


$total_payment = fetch_total_payment($pdo,$customer_id);
$outstanding_balance  = $gross_total_collectables - $total_payment;


?>



<div class="modal fade" id="view_data_modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><?= $row->name ?> Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <!-- <form method="post" id="confirm_payment"> -->
              <!-- <input type="hidden" id="payableid" name="payableid"> -->
                <div class="modal-body">

                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-12">
                          <span id="load_view_data"></span>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <!-- <button type="submit" class="btn btn-primary">Confirm payment</button> -->
                </div>
            <!-- </form> -->
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>












<div class="modal fade" id="pay_payables_modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pay Menu</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="post" id="confirm_payment">

              <input type="hidden" id="payableid" name="payableid">

                <div class="modal-body">

                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                            <b>Date : </b>&emsp;
                            <input type="date" class="form-control" required name="payables_date"  id="payables_date">
                        </div>
                        <div class="form-group">
                            <b>Check Number/ Reference No : </b>&emsp;
                            <input type="text" class="form-control" required autocomplete="off" placeholder="Input check number / reference num" name="payables_reference"  id="payables_reference">
                        </div>
                        <div class="form-group">
                            <b>Amount : </b>&emsp;
                            <input type="text" class="form-control" required autocomplete="off" placeholder="Input amount" name="payables_amount"  id="payables_amount">
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Confirm payment</button>
                </div>
            </form>
          </div>
        </div>
      </div>













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

<input type="hidden" id="customer_id_hidden" value="<?= $customer_id ?>">


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
                    <h5 class="m-0 text-white" ><a href="accounts_receivables.php" class="text-white">View Receivable Customers</a> / <?= $row->name ?></h5>
                </div>
                <!-- card body open --> 
                <div class="card-body">
                  <div class="col-sm-12 col-lg-12">
                    <div class="row">


                      <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="small-box bg-white" >
                          <div class="inner" style="background-color:rgba(50,63,81,255);">
                            <h3 class="text-white"><?= number_format($gross_total_collectables,2) ?></h3>
                            <p class="text-white">TOTAL CREDITS</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-bag"></i>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="small-box bg-white" >
                          <div class="inner" style="background-color:rgba(16,101,37);">
                            <h3 class="text-white"><?= number_format($total_payment,2) ?></h3>
                            <p class="text-white">TOTAL COLLECTION</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-bag"></i>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="small-box bg-white" >
                          <div class="inner" style="background-color:rgb(148,94,16);">
                            <h3 class="text-white">2</h3>
                            <p class="text-white">AVERAGE OUTSTANDING DAYS</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-bag"></i>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="small-box bg-white" >
                          <div class="inner" style="background-color:rgba(120, 40, 31);">
                            <h3 class="text-white"><?= number_format($outstanding_balance,2) ?></h3>
                            <p class="text-white">OUTSTANDING BALANCE</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-bag"></i>
                          </div>
                        </div>
                      </div>


                    </div>
                  </div>
                </div>  
                <!-- card body close -->
            </div>



<!-- card main open -->
<div class="card card-grey card-outline">
               
      <!-- card body open --> 
      <div class="card-body">
        <div class="col-sm-12 col-lg-12">
          <div class="row">

            <div class="col-sm-12">
                <a href="accounts_insert_customer_data.php?id=<?= $customer_id ?>" class="btn btn-md btn-primary float-sm-right"><span class="fa fa-plus"  data-toggle="tooltip" title="View Category" ></span>&nbsp;&nbsp;Add Data</a>
            </div>


            <div class="col-md-12 col-sm-12 col-lg-12 mt-3">


                <div class="table-responsive-sm">
                  <font face="verdana">
                    <table id="accounts_receivables_datatable" class="table table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <td style="font-weight: bold;" align="center">Id</td> 
                                <td style="font-weight: bold;" align="center">Date</td> 
                                <td style="font-weight: bold;" align="center">Invoice Num</td> 

                                <td style="font-weight: bold;" align="center">Qty</td> 
                                <td style="font-weight: bold;" align="center">Price</td> 
                                <td style="font-weight: bold;" align="center">Total</td> 

                                <td style="font-weight: bold;" align="center">Total paid</td> 
                                <td style="font-weight: bold;" align="center">Outstanding balance</td> 

                                <td style="font-weight: bold;" align="center">Action</td> 
                            </tr>
                        </thead>
                      </table>
                    </font>
                </div>


            </div>
          </div>
        </div>
      </div>  
      <!-- card body close -->
</div>
<!-- card main close -->




        </div>
          <!-- col md 12 close --> 




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


    var customer_id = $('#customer_id_hidden').val();

    // alert(customer_id);

    var accounts_receivables_datatable = $('#accounts_receivables_datatable').DataTable(
    {
      "order": [[ 0, 'desc' ]],

        "responsive": true,
         "autoWidth": true,
      "lengthChange": true,
    "iDisplayLength": 10,

          "columnDefs": 
        [
            {
                "targets": [0],
                "visible": false,
                "searchable": true,  
            },

        ], 

        "ajax": 
        {
          // url:"accounts_fetch_payables_data.php?supplier_id="+customer_id,
          url:"accounts_fetch_receivables_data.php?supplier_id="+customer_id,
          type:"post"
        } ,

    });














    $(document).on('click','#pay_payables',function()
    {

      var id = $(this).data('id');

      // alert(id);

      $('#payableid').val(id);

      $('#pay_payables_modal').modal('show');

    })














  $(document).on('submit', '#confirm_payment', function(event)
    {


      event.preventDefault();
      var form_data = $(this).serialize();

      // alert(form_data);

        $.ajax({
        // url: 'accounts_add_payable_supplier_data.php',
          // url: 'accounts_confirm_payment.php',
          url: 'accounts_confirm_customer_payment.php',
        type: 'post',
        data:form_data,
        success: function(data) 
         {  
            // alert(data);
            // $('#accounts_payable_datatable').DataTable().ajax.reload(null, false);
            $('#pay_payables_modal').modal('hide');
            $('#payables_reference').val('');
            $('#payables_amount').val('');
            $('#payables_date').val('00/00/0000');
            $('#accounts_receivables_datatable').DataTable().ajax.reload();

            // $.ajax({
            //   url: 'accounts_fetch_data.php',
            //   type: 'post',
            //   data:'id='+data,
            //   success: function(data) 
            //    {  
                  
            //     $('#load_view_data').html(data);

            //    }
            //   });


            $.ajax({
              // url: 'accounts_fetch_data.php',
              url: 'accounts_view_customer_data.php',
              type: 'post',
              data:'id='+data,
              success: function(data) 
               {  
                  $('#load_view_data').html(data);
               }
              });


           Swal.fire(
           {
              icon: 'success',
              title: 'Data inserted successfully!'
            });

          }
        });

      
    });





    $(document).on('click','#view_payables',function()
    {

      var id = $(this).data('id');

      // alert(id);
      // alert('God is good, life is good! 123444');

      $('#view_data_modal').modal('show')

      $.ajax({
        // url: 'accounts_fetch_data.php',
        url: 'accounts_view_customer_data.php',
        type: 'post',
        data:'id='+id,
        success: function(data) 
         {  
            $('#load_view_data').html(data);
         }
        });

    })


    $(document).on('click','#delete_payables',function()
    {

      var id = $(this).data('id');

      // alert(id);

     Swal.fire({
      title: 'Delete payment?',
      text: "Press yes to confirm!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirm'
        }).then((result) => 
        {
          if (result.isConfirmed) 
          {
            $.ajax({
              // url: 'bank_delete_check.php',
              url: 'accounts_delete_payment.php',
              type: 'post',
              data:'id='+id,
              success: function(data) 
              {
                // alert(data);

                        $.ajax({
                        url: 'accounts_fetch_data.php',
                        type: 'post',
                        data:'id='+data,
                        success: function(data) 
                         {  
                          
                          $('#accounts_payable_datatable').DataTable().ajax.reload();
                          $('#load_view_data').html(data);

                         }
                        });


              }
            });

            Swal.fire(
              'Payment deleted!',
              '',
              'success'
            )
          }
        })


    })


$(document).on('click','#edit_payables',function()
{

var id = $(this).data('id');

// alert(id);
// alert('God is good, life is good!');

})




    })

  </script>