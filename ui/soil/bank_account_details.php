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


$bankid = $_GET['id'];
$datenow = $_GET['datenow'];

$select = $pdo->prepare("SELECT * from tb_bank where id = $bankid");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);



$bankheader = $row->name.' - '.$row->account_num;
$checkinfo = checksdata($pdo,$bankid,$datenow);



?>



<!--MODAL OPEN -->
<div class="modal fade" id="modal_show_check_details">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <form method="post" id="confirm_check_update">

            <div class="modal-header">
              <h4 class="modal-title">Check Details</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary float-sm-right">Save changes</button>
            </div>


            </form>

          </div>
        </div>
      </div>
<!--MODAL CLOSE -->





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
                  <h5 class="m-0 text-white"><a href="bank_account.php" class="text-white">View Bank Accounts</a> / Bank Details</h5>
                </div>
                <div class="card-body">
                  <div class="row">

                    <input type="hidden" value="<?= $bankid ?>" id="bankidhidden">

                    <div class="col-lg-6 col-6">
                      <div class="small-box bg-grey" style="background-color:rgba(50,63,81,255);">
                        <div class="inner">
                          <h3 class="text-white">
                            <?= $row->name ?>
                            <span class="float-right"><?= number_format($checkinfo['totaloverall'],2) ?></span>
                          </h3>
                            <p class="text-white">
                              Account #: <font style="font-weight:bold;"><?= $row->account_num ?></font>
                              <span class="float-right">BALANCE</span>
                            </p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-bag"></i>
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-6 col-6">
                      <a href="#">
                          <div class="small-box bg-grey" style="background-color:rgb(148,94,16);">
                            <div class="inner">
                              <h3 class="text-white">
                                  <?= $checkinfo['total_outstandingcheck'] ?>
                                  <span class="float-right"><?= number_format($checkinfo['total_outstanding_check_amount'],2) ?></span>
                              </h3>
                              <p class="text-white">OUTSTANDING CHECKS
                                  <span class="float-right">OUTSTANDING BALANCE</span>
                              </p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                          </div>
                      </a>
                    </div>

                    
                    <div class="col-lg-6 col-6">
                      <a href="#">
                          <div class="small-box bg-grey" style="background-color:rgba(12, 51, 21);">
                            <div class="inner">
                              <h3 class="text-white"><?= number_format($checkinfo['totaldeposit'],2) ?></h3>
                              <p class="text-white">TOTAL DEPOSIT</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                          </div>
                      </a>
                    </div>


                    <div class="col-lg-6 col-6">
                      <a href="#">
                          <div class="small-box bg-grey" style="background-color:rgba(120, 40, 31);">
                            <div class="inner">
                              <h3 class="text-white"><?= number_format($checkinfo['totalwithdraw'],2) ?></h3>
                              <p class="text-white">TOTAL WITHDRAW</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                          </div>
                      </a>
                    </div>

                    
                    
                  </div>
                </div>
            </div>



            <div class="card card-grey card-outline mt-5">
                <div class="card-header" style="background-color:rgba(50,63,81,255);">
                  <h5 class="m-0 text-white">Deposit</h5>
                </div>
                <div class="card-body">
                  <div class="row">

                    <div class="col-sm-12">
                        <a href="bank_details_add_deposit.php?bankid=<?= $bankid ?>" class="btn btn-md btn-primary text-white float-sm-right" >Deposit</a>
                    </div>
                    
                    <div class="col-md-12 mt-3">
                        <div class="table-responsive-sm">
                            <font face="verdana">
                              <table id="depost_fetch_datatable" class="table table-hover" style="width: 100%">
                                  <thead>
                                      <tr>
                                          <td style="font-weight: bold;" align="center">Id</td> 
                                          <td style="font-weight: bold;" align="center">Bank / Account No.</td> 
                                          <td style="font-weight: bold;" align="center">Particular</td> 
                                          <td style="font-weight: bold;" align="center">Date</td> 
                                          <td style="font-weight: bold;" align="center">Amount</td> 
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




            <div class="card card-grey card-outline mt-5">
                <div class="card-header" style="background-color:rgb(148,94,16);">
                  <h5 class="m-0 text-white">Check details</h5>
                </div>
                <div class="card-body">
                  <div class="row">

                    <div class="col-sm-12">
                        <a href="bank_details_add_check.php?bankid=<?= $bankid ?>" class="btn btn-md float-sm-right text-white btn-primary" >Add check</a>
                    </div>
                    
                    <div class="col-md-12 mt-3">
                          <div class="table-responsive-sm">
                            <font face="verdana">
                              <table id="bank_details_check_datatable" class="table table-hover" style="width: 100%">
                                  <thead>
                                      <tr>
                                          <td style="font-weight: bold;" align="center">Id</td> 
                                          <td style="font-weight: bold;" align="center">Bank / Account No.</td> 
                                          <td style="font-weight: bold;" align="center">Payee</td> 
                                          <td style="font-weight: bold;" align="center">Check num</td> 
                                          <td style="font-weight: bold;" align="center">Amount</td> 
                                          <td style="font-weight: bold;" align="center">Date</td> 
                                          <td style="font-weight: bold;" align="center">Status</td>
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


    var bankid = $('#bankidhidden').val();

    // alert(bankidhidden);

    var bank_details_check_datatable = $('#bank_details_check_datatable').DataTable(
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
          url:"bank_details_fetch_datatable.php?bankid="+bankid,
          type:"post"
        }  

    });



    var depost_fetch_datatable = $('#depost_fetch_datatable').DataTable(
    {
      // "order": [[ 0, 'desc' ]],

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
          // url:"bank_fetch_check_datatable.php",
          // url:"deposit_fetch_data.php",
          url:"bank_details_fetch_deposit.php?bankid="+bankid,
          type:"post"
        }  

    });



    $(document).on('click','#btn_change_status',function(){

      var id = $(this).data('id');
      
      $('#modal_show_check_details').modal('show');

    })




    $(document).on('click','#btn_delete_check',function()
    {

      var id = $(this).data('id');

      // alert(id);

      Swal.fire({
      title: 'Do you want to delete check?',
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
              url: 'bank_delete_check.php',
              type: 'post',
              data:'id='+id,
              success: function(data) 
              {
                $('#bank_details_check_datatable').DataTable().ajax.reload(null, false);
              }
            });

            Swal.fire(
              'Check deleted!',
              '',
              'success'
            )
          }


        })

    })









$(document).on('click','#pendingstatus',function()
{

  var checkid = $(this).data('id');

  // alert(id);

      Swal.fire({
      title: 'Change status to pending?',
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
              url: 'change_status_pending.php',
              type: 'post',
              data:'checkid='+checkid+'&statusid=1',
              success: function(data) 
              {
                $('#bank_details_check_datatable').DataTable().ajax.reload(null, false);
              }
            });

            Swal.fire(
              'Check status change to pending!',
              '',
              'success'
            )
          }
        })

})






$(document).on('click','#clearstatus',function()
{

  var checkid = $(this).data('id');

  // alert(checkid);

      Swal.fire({
      title: 'Change status to clear?',
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
              url: 'change_status_pending.php',
              type: 'post',
              data:'checkid='+checkid+'&statusid=2',
              success: function(data) 
              {
                $('#bank_details_check_datatable').DataTable().ajax.reload(null, false);
              }
            });

            Swal.fire(
              'Check status change to clear!',
              '',
              'success'
            )
          }
        })

})









$(document).on('click','#holdstatus',function()
{

  var checkid = $(this).data('id');

  // alert(checkid);

      Swal.fire({
      title: 'Change status to hold?',
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
              url: 'change_status_pending.php',
              type: 'post',
              data:'checkid='+checkid+'&statusid=3',
              success: function(data) 
              {
                $('#bank_details_check_datatable').DataTable().ajax.reload(null, false);
              }
            });

            Swal.fire(
              'Check status change to hold!',
              '',
              'success'
            )
          }
        })

})









$(document).on('click','#cancelstatus',function()
{

  var checkid = $(this).data('id');

  // alert(checkid);

      Swal.fire({
      title: 'Change status to cancelled?',
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
              url: 'change_status_pending.php',
              type: 'post',
              data:'checkid='+checkid+'&statusid=4',
              success: function(data) 
              {
                $('#bank_details_check_datatable').DataTable().ajax.reload(null, false);
              }
            });

            Swal.fire(
              'Check status change to cancelled!',
              '',
              'success'
            )
          }
        })

})




$(document).on('click','#btn_delete_deposit',function()
    {

      var id = $(this).data('id');

      // alert(id);

      Swal.fire({
      title: 'Do you want to deposit data?',
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
              url: 'deposit_delete.php',
              type: 'post',
              data:'id='+id,
              success: function(data) 
              {
                $('#depost_fetch_datatable').DataTable().ajax.reload(null, false);
              }
            });

            Swal.fire(
              'Deposit deleted!',
              '',
              'success'
            )
          }
        })

    })






  });
</script>








