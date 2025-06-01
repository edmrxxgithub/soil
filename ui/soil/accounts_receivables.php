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
                  <h5 class="m-0 text-white">View Receivable Customers</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    
                    <div class="col-sm-12">
                        <a href="accounts_receivables_add_customer.php" class="btn btn-md btn-primary float-sm-right">Add customer</a>
                    </div>
        
      <div class="col-md-12 mt-3">
            <div class="table-responsive-sm">
              <font face="verdana">
                <table id="account_customer_datatable" class="table table-hover" style="width: 100%">
                    <thead>
                        <tr>
                            <td style="font-weight: bold;" align="center">Id</td> 
                            <td style="font-weight: bold;" align="center">Name</td> 
                            <td style="font-weight: bold;" align="center">Customer code</td> 
                            <td style="font-weight: bold;" align="center">Total credits</td> 
                            <td style="font-weight: bold;" align="center">Total collection</td> 
                            <td style="font-weight: bold;" align="center">Average outstanding days</td> 
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





<script>
  $(document).ready(function() 
  {
    
    $('[data-toggle="tooltip"]').tooltip();

    var account_customer_datatable = $('#account_customer_datatable').DataTable(
    {
      "order": [[ 0, 'desc' ]],

        "responsive": true,
         "autoWidth": true,
      "lengthChange": true,
    "iDisplayLength": 10,

        //   "columnDefs": 
        // [
        //     {
        //         "targets": [0],
        //         "visible": false,
        //         "searchable": true,  
        //     },

        // ], 

        "ajax": 
        {
          // url:"accounts_fetch_supplier_data.php",
          url:"accounts_fetch_customer_data.php",
          type:"post"
        } ,

    });


    $(document).on('click','#accounts_payables_add_data',function()
    {

      var id = $(this).data('id');

      $('#payableid_hidden').val(id);

      $('#add_data_modal').modal('show');

      $.ajax({
        // url: 'deactivate_account.php',
        url: 'accounts_fetch_payable_supplier_data.php',
        type: 'post',
        data:'id='+id,
        dataType:'json',
        success: function(data) 
        {
          $('#supplier_name').val(data.name);
          $('#supplier_address').val(data.address);
          $('#supplier_contact_num').val(data.contact_num);
          $('#supplier_tin').val(data.tin);
          $('#supplier_code').val(data.code);
        }
      });


    })




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





    $(document).on('click','#accounts_receivable_delete_customer',function()
    {

      var id = $(this).data('id');

      // alert(id);

        Swal.fire({
          title: 'Do you want to delete customer?',
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

            // $.ajax({
            //   // url: 'deactivate_account.php',
            //   url: 'accounts_delete_payables.php',
            //   type: 'post',
            //   data:'id='+id,
            //   success: function(data) 
            //   {
            //     $('#account_payable_supplier_datatable').DataTable().ajax.reload(null, false);
            //   }
            // });

            Swal.fire(
              'Customer deleted!',
              '',
              'success'
            )
          }

        })

    })




    
  $(document).on('submit', '#confirm_add_supplier_data', function(event)
    {


      event.preventDefault();
      var form_data = $(this).serialize();

      // alert(form_data);

        $.ajax({
        url: 'accounts_add_payable_supplier_data.php',
        type: 'post',
        data:form_data,
        success: function(data) 
         {  

            // alert(data);
            $('#add_data_modal').modal('hide');
            $('#account_payable_supplier_datatable').DataTable().ajax.reload(null, false);

           Swal.fire({
              icon: 'success',
              title: 'Data inserted successfully!'
            });

          }
        });

      
    });





  });
</script>