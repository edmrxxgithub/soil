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


$clientid = $_GET['id'];


function fetch_num_branch($pdo,$id)
{
  $select = $pdo->prepare("SELECT * FROM tb_tax_branch where business_id = '$id' ");
  $select->execute();
  $num = $select->rowCount();

  return $num;
}


$select = $pdo->prepare("SELECT * FROM tb_tax_client WHERE id = '$clientid' ");
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

          <input type="hidden" id="clientid" value="<?= $clientid ?>">

            <div class="card card-grey card-outline">
                <div class="card-header" style="background-color:rgba(50,63,81,255);">
                  <h5 class="m-0 text-white"><a href="tax_client.php" class="text-white">View Clients</a> / <?= $row->name ?></h5>
                </div>
                <div class="card-body">



                  <!-- row open -->
                  <div class="row">
                    
                    <div class="col-sm-12">
                        <a href="tax_add_business.php?clientid=<?= $clientid ?>" class="btn btn-md btn-primary float-sm-right">Add business</a>
                    </div>
                      

                    <!-- <div class="col-md-12 mt-3">
                          <div class="table-responsive-sm">
                            <font face="verdana">
                              <table id="client_business_datatable" class="table table-hover" style="width: 100%">
                                  <thead>
                                      <tr>
                                          <td style="font-weight: bold;" align="center">Id</td> 
                                          <td style="font-weight: bold;" align="center">Business name</td> 
                                          <td style="font-weight: bold;" align="center">TIN</td> 
                                          <td style="font-weight: bold;" align="center">Address</td> 
                                          <td style="font-weight: bold;" align="center">Action</td> 
                                      </tr>
                                  </thead>
                                </table>
                              </font>
                          </div>
                      </div> -->

<?php

$select1 = $pdo->prepare("SELECT * FROM tb_tax_business WHERE client_id = '$clientid' ");
$select1->execute();
while ($row1 = $select1->fetch(PDO::FETCH_OBJ))
{

  $numofbranch = fetch_num_branch($pdo,$row1->id);

?>

<div class="col-md-12 col-lg-6 mt-4">
  <div class="small-box" style="background-color:rgb(249,249,247);">
    <div class="inner">
      <h3 class="text-black">
          <center>
            <a href="tax_view_client_business.php?id=<?= $row1->id ?>">
                <image src="images/<?php echo $row1->image;?>" class="img-rounded" width="200px" height="150px/">
            </a>
          </center>
      </h3>

      <!-- <span id=""><?= $row1->image ?></span> -->
      
<!--       <center>
      <p class="text-black" style="font-weight:bold;"><font size="5"><?= strtoupper($row->name) ?></font></p>
      </center> -->

      <table border="0" width="100%">
        <tr>
          <td width="40%">Business name : </td>
          <td style="font-weight:bold;">&emsp;<?= $row1->name ?></td>
        </tr>
        <tr>
          <td width="40%">Address : </td>
          <td style="font-weight:bold;">&emsp;<?= $row1->address ?></td>
        </tr>
        <tr>
          <td>No of branch : </td>
          <td style="font-weight:bold;">&emsp;<?= $numofbranch ?></td>
        </tr>
        <tr>
          <td>TIN : </td>
          <td style="font-weight:bold;">&emsp;<?= $row1->tin ?></td>
        </tr>
        <tr>
          <td>Action : </td>
          <td  align="left">
            &emsp;
            <a href="tax_edit_business.php?id=<?= $row1->id ?>" class="text-success">Edit</a>
            &nbsp;
            <!-- <a href="#" data-id="<?= $row1->id ?>" id="delete_business" class="text-danger">Delete</a> -->
            <font data-id="<?= $row1->id ?>" id="delete_business" class="text-warning" style="cursor: pointer;">Archive</font>

          </td>
        </tr>
      </table>

      
      
    </div>
    <div class="icon">
      <i class="ion ion-bag"></i>
    </div>
  </div>
</div>

<?php
}
?>





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
    
    $('[data-toggle="tooltip"]').tooltip();


    var clientid = $('#clientid').val();

    // alert(clientid);

    var client_business_datatable = $('#client_business_datatable').DataTable(
    {
      "order": [[ 3, 'desc' ]],

        "responsive": true,
         "autoWidth": true,
      "lengthChange": true,
    "iDisplayLength": 25,

        "ajax": 
        {
          // url:"tax_fetch_client.php",
          url:"tax_fetch_client_business.php?clientid="+clientid,
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


    // $(document).on('click','#delete_business',function()
    // {

    //   var id = $(this).data('id');

    //   alert(id);

    // })


$(document).on('click','#delete_business',function()
    {

      var id = $(this).data('id');

      // alert(id);

      Swal.fire({
      title: 'Archive business?',
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
            //   url: 'bank_delete_check.php',
            //   type: 'post',
            //   data:'id='+id,
            //   success: function(data) 
            //   {
            //     $('#bank_fetch_check_datatable').DataTable().ajax.reload(null, false);
            //   }
            // });

            Swal.fire(
              'Business arhived!',
              '',
              'success'
            )
          }
        })

    })


  });
</script>























