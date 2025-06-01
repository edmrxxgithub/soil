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

$business_id = $_GET['id'];

function fetch_business_name($pdo,$id)
{
  $select = $pdo->prepare("SELECT * FROM tb_tax_client WHERE id = '$id' ");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);

  return $row->name;
}



$select = $pdo->prepare("SELECT * FROM tb_tax_business WHERE id = '$business_id' ");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$business_name = fetch_business_name($pdo,$row->client_id);


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
                  <h5 class="m-0 text-white">
                    <a href="tax_client.php" class="text-white">View Clients</a> / 
                    <a href="tax_view_client.php?id=<?= $row->client_id ?>" class="text-white"><?= $business_name?></a> / 
                    <?= $row->name ?>
                  </h5>
                </div>
                <div class="card-body">

<input type="hidden" id="businessid" value="<?= $business_id ?>">
                  
                  <!-- row open -->
                  <div class="row">
                    
                    <div class="col-sm-12">
                        <a href="tax_add_branch.php?businessid=<?= $business_id ?>" class="btn btn-md btn-primary float-sm-right">Add branch</a>
                    </div>
        
                    <div class="col-md-12 mt-3">
                          <div class="table-responsive-sm">
                            <font face="verdana">
                              <table id="tax_branch_datatable" class="table table-hover" style="width: 100%">
                                  <thead>
                                      <tr>
                                          <td style="font-weight: bold;" align="center">Id</td> 
                                          <td style="font-weight: bold;" align="center">Branch address</td> 
                                          <td style="font-weight: bold;" align="center">TIN</td> 

                                          <td style="font-weight: bold;" align="center">Sales transaction</td> 
                                          <td style="font-weight: bold;" align="center">Purchase transaction</td> 

                                          <td style="font-weight: bold;" align="center">Action</td> 
                                      </tr>
                                  </thead>
                                </table>
                              </font>
                          </div>
                      </div>

                  </div>
                  <!-- row close -->


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
    
    var businessid = $('#businessid').val();

    // alert(businessid);
    // $('[data-toggle="tooltip"]').tooltip();

    var tax_branch_datatable = $('#tax_branch_datatable').DataTable(
    {
      "order": [[ 3, 'desc' ]],

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
          // url:"tax_fetch_branch.php?businessid="+businessid,
          url:"tax_fetch_branch2.php?businessid="+businessid,
          type:"post"
        } ,

    });


    




    $(document).on('click','#btndeletebranch',function()
    {

      var id = $(this).data('id');

      // alert(id);

      Swal.fire({
      title: 'Confirm delete branch?',
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
              url: 'tax_delete_branch.php',
              type: 'post',
              data:'id='+id,
              success: function(data) 
              {
                $('#tax_branch_datatable').DataTable().ajax.reload(null, false);
              }
            });

            Swal.fire(
              'Branch deleted!',
              '',
              'success'
            )
          }
        })

    })
  





  });
</script>