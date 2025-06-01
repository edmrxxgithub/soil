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
                  <h5 class="m-0 text-white">View Supplier</h5>
                </div>
                <div class="card-body">
                  <div class="row">

                    <div class="col-sm-12">
                        <a href="tax_add_supplier.php" class="btn btn-md btn-primary float-sm-right">Add supplier</a>
                    </div>

                    <div class="col-md-12 mt-3">
                          <div class="table-responsive-sm">
                            <font face="verdana">
                              <table id="supplier_datatable" class="table table-hover" style="width: 100%">
                                  <thead>
                                      <tr>
                                          <td style="font-weight: bold;" align="center">Id</td>
                                          <td style="font-weight: bold;" align="center">Supplier</td>
                                          <td style="font-weight: bold;" align="center">TIN</td>
                                          <td style="font-weight: bold;" align="center">Address</td>
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

    var supplier_datatable = $('#supplier_datatable').DataTable(
    {
      // "order": [[ 3, 'desc' ]],

        "responsive": true,
         "autoWidth": true,
      "lengthChange": true,
    "iDisplayLength": 25,

        "ajax":
        {
          // url:"tax_fetch_client.php",
          url:"tax_fetch_supplier.php",
          type:"post"
        } ,

          "columnDefs":
        [
            {
                "targets": [0],
                "visible": false,
                "searchable": true,
            },
        ],

    });



  });
</script>
