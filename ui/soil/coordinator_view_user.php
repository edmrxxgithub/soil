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

            <div class="card card-grey card-outline" >
                <div class="card-header" style="background-color:rgba(50,63,81,255);">
                  <h5 class="m-0 text-white">View Coordinators</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    
                    <div class="col-sm-12">
                        <!-- <a href="coordinator_add_user.php" class="btn btn-md btn-primary float-md-right">Add coordinator</a> -->
                    </div>
        
                    <div class="col-md-12 mt-3">
                          <div class="table-responsive-sm">
                            <font face="verdana">
                              <table id="coordinator_table" class="table table-hover" style="width: 100%">
                                  <thead>
                                      <tr>
                                          <td style="font-weight: bold;" align="center">Id</td> 
                                          <td style="font-weight: bold;" align="center">Username</td> 
                                          <td style="font-weight: bold;" align="center">Name</td> 
                                          <td style="font-weight: bold;" align="center">User level</td> 
                                          <td style="font-weight: bold;" align="center">Branch #</td> 
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

    var coordinator_table = $('#coordinator_table').DataTable(
    {
      // "order": [[ 0, 'desc' ]],

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
          // url:"fetch_user_datatable.php",
          url:"fetch_coordinator_user_datatable.php",
          type:"post"
        }  

    });


//     $(document).on('click','#btndelete_user',function()
//     {

//       var id = $(this).data('id');

//       // alert(id);

//       Swal.fire({
//   title: 'Do you want to delete?',
//   text: "You won't be able to revert this!",
//   icon: 'warning',
//   showCancelButton: true,
//   confirmButtonColor: '#3085d6',
//   cancelButtonColor: '#d33',
//   confirmButtonText: 'Yes, delete it!'
// }).then((result) => 
// {
//   if (result.isConfirmed) 
//   {

//     $.ajax({
//       url: 'delete_account.php',
//       type: 'post',
//       data:'id='+id,
//       success: function(data) 
//       {
//         $('#user_table').DataTable().ajax.reload(null, false);
//         alert(id);
//       }
//     });

//     Swal.fire(
//       'Deleted!',
//       'User deleted!',
//       'success'
//     )
//   }


// })

//     })



    $(document).on('click','#btn_deactivate_user',function()
    {

      var id = $(this).data('id');

      // alert(id);

      Swal.fire({
  title: 'Do you want to deactivate user?',
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
      url: 'deactivate_account.php',
      type: 'post',
      data:'id='+id,
      success: function(data) 
      {
        $('#user_table').DataTable().ajax.reload(null, false);
        // alert(id);
      }
    });

    Swal.fire(
      'User deactivated!',
      '',
      'success'
    )
  }


})

    })




    $(document).on('click','#btn_activate_user',function()
    {

      var id = $(this).data('id');

      // alert(id);

      Swal.fire({
  title: 'Do you want to activate user?',
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
      url: 'activate_account.php',
      type: 'post',
      data:'id='+id,
      success: function(data) 
      {
        $('#user_table').DataTable().ajax.reload(null, false);
        // alert(id);
      }
    });

    Swal.fire(
      'User Activated!',
      '',
      'success'
    )
  }


})

    })

  });
</script>