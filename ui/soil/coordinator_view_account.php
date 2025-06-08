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


$user_id = $_GET['id'];

include_once "header.php";


$select = $pdo->prepare("SELECT * from tb_user where id = $user_id");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);



$selectcoor = $pdo->prepare("SELECT * FROM tb_coordinator WHERE user_id = '$user_id' ");
$selectcoor->execute();
$coornumcount = $selectcoor->rowCount();




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
                    <h5 class="m-0 text-white"><a href="coordinator_view_user.php" class="text-white">View Coordinators</a> / Coordinator data</h5>
                </div>






                <!-- card body open --> 
             

                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">
                    

          <div class="col-lg-4 col-6">
            <div class="small-box bg-white" >
              <div class="inner" >
                <h3 class="text-black"><?= $row->username ?></h3>
                <p class="text-black">Username</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>


          <div class="col-lg-4 col-6">
            <div class="small-box bg-white" >
              <div class="inner" >
                <h3 class="text-black"><?= $row->name ?></h3>
                <p class="text-black">Fullname</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-6">
            <div class="small-box bg-white" >
              <div class="inner" >
                <h3 class="text-black"><?= $coornumcount ?></h3>
                <p class="text-black">Total branch</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>



          <div class="col-lg-12 col-12">
            <!-- <li class="list-group-item"> -->
                         <div class="card card-grey card-outline" >
                <div class="card-header" style="background-color:rgba(50,63,81,255);">
                  <h5 class="m-0 text-white">Branches</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    
                    <div class="col-sm-12">
                        <a href="coordinator_add_branch.php?userid=<?= $user_id ?>" class="btn btn-sm btn-primary float-sm-right">Add branch</a>
                    </div>
        
                    <div class="col-md-12 mt-3">
                          <div class="table-responsive-sm">
                            <font face="verdana">
                              <table id="coordinator_branch_data" class="table table-hover" style="width: 100%">
                                  <thead>
                                      <tr>
                                          <td style="font-weight: bold;" align="center">id</td> 
                                          <td style="font-weight: bold;" align="center">Client name</td> 
                                          <td style="font-weight: bold;" align="center">Business name</td> 
                                          <td style="font-weight: bold;" align="center">Branch name</td> 
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
            <!-- </li> -->
          </div>

          



                  </div>
                  <!-- row close --> 
                </div>  
                <!-- card body close --> 





                <!-- card footer open --> 
                <div class="card-footer">
                  <!-- <div class="text-center">
                      <button type="submit" class="btn btn-primary btn-md" name="addaccount">Add Account</button>
                  </div> -->
                </div>
                <!-- card footer close --> 

           
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


    var coordinator_branch_data = $('#coordinator_branch_data').DataTable(
    {
      // "order": [[ 0, 'desc' ]],

      "columnDefs":
    [
        {
            "targets": [0],
            "visible": false,
            "searchable": true,
        },
    ],

        "responsive": true,
         "autoWidth": true,
      "lengthChange": true,
    "iDisplayLength": 10,

        "ajax": 
        {
          // url:"fetch_user_datatable.php",
          url:"fetch_coordinator_branch_data.php?userid="+<?= $user_id ?>,
          type:"post"
        }  

    });





$(document).on('click','#coordinator_delete_branch',function()
    {

      var id = $(this).data('id');

      // alert(id);

      Swal.fire({
      title: 'Do you want to delete branch?',
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
              url: 'coordinator_confirm_delete_branch.php',
              type: 'post',
              data:'id='+id,
              success: function(data) 
              {
                $('#coordinator_branch_data').DataTable().ajax.reload(null, false);
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



  })
</script>











