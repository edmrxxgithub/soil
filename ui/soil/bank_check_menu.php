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
                  <h5 class="m-0 text-white">View Checks</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    
                    <div class="col-sm-12">
                        <a href="bank_check_add_menu.php" class="btn btn-md btn-primary float-sm-right">Add check</a>
                    </div>
        
                    <div class="col-md-12 mt-3">
                          <div class="table-responsive-sm">
                            <font face="verdana">
                              <table id="bank_fetch_check_datatable" class="table table-hover" style="width: 100%">
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
    
    $('[data-toggle="tooltip"]').tooltip();

    var bank_fetch_check_datatable = $('#bank_fetch_check_datatable').DataTable(
    {
      "order": [[ 0, 'desc' ]],

        "responsive": true,
         "autoWidth": true,
      "lengthChange": true,
    "iDisplayLength": 25,

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
          url:"bank_fetch_check_datatable.php",
          type:"post"
        }  

    });


//     $(document).on('click','#btn_deactivate_user',function()
//     {

//       var id = $(this).data('id');

//       // alert(id);

//       Swal.fire({
//   title: 'Do you want to deactivate user?',
//   text: "Press yes to confirm!",
//   icon: 'warning',
//   showCancelButton: true,
//   confirmButtonColor: '#3085d6',
//   cancelButtonColor: '#d33',
//   confirmButtonText: 'Confirm'
// }).then((result) => 
// {
//   if (result.isConfirmed) 
//   {

//     $.ajax({
//       url: 'deactivate_account.php',
//       type: 'post',
//       data:'id='+id,
//       success: function(data) 
//       {
//         $('#user_table').DataTable().ajax.reload(null, false);
//         // alert(id);
//       }
//     });

//     Swal.fire(
//       'User deactivated!',
//       '',
//       'success'
//     )
//   }


// })

//     })




//     $(document).on('click','#btn_activate_user',function()
//     {

//       var id = $(this).data('id');

//       // alert(id);

//       Swal.fire({
//   title: 'Do you want to activate user?',
//   text: "Press yes to confirm!",
//   icon: 'warning',
//   showCancelButton: true,
//   confirmButtonColor: '#3085d6',
//   cancelButtonColor: '#d33',
//   confirmButtonText: 'Confirm'
// }).then((result) => 
// {
//   if (result.isConfirmed) 
//   {

//     $.ajax({
//       url: 'activate_account.php',
//       type: 'post',
//       data:'id='+id,
//       success: function(data) 
//       {
//         $('#user_table').DataTable().ajax.reload(null, false);
//         // alert(id);
//       }
//     });

//     Swal.fire(
//       'User Activated!',
//       '',
//       'success'
//     )
//   }


// })

//     })
  

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
                $('#bank_fetch_check_datatable').DataTable().ajax.reload(null, false);
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
                $('#bank_fetch_check_datatable').DataTable().ajax.reload(null, false);
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
                $('#bank_fetch_check_datatable').DataTable().ajax.reload(null, false);
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
                $('#bank_fetch_check_datatable').DataTable().ajax.reload(null, false);
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
                $('#bank_fetch_check_datatable').DataTable().ajax.reload(null, false);
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





  });
</script>