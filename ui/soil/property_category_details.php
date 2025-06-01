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


$propertyid = $_GET['id'];


$select = $pdo->prepare("SELECT * from tb_property_category where id = $propertyid");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);


$select1 = $pdo->prepare("SELECT * from tb_property_data where category_id = $propertyid");
$select1->execute();
$row1=$select1->fetch(PDO::FETCH_OBJ);
$itemcount = $select1->rowCount();


$total_carrying_amount = fetch_property_carrying_amount($pdo,$propertyid);




$yearnow = date('Y');
$monthnow = date('m');
$monthnow_word = date('F');
$days_in_a_month = date("t", strtotime("$yearnow-$monthnow-01"));


$datefrom = $yearnow.'-'.$monthnow.'-1';
$dateto = $yearnow.'-'.$monthnow.'-'.$days_in_a_month;

// echo $datefrom.' to '.$dateto;

$select2 = $pdo->prepare("SELECT SUM(price) as total_acq_amount FROM tb_property_data WHERE acq_date BETWEEN '$datefrom' AND '$dateto' AND category_id = '$propertyid' ");
$select2->execute();
$row2 = $select2->fetch(PDO::FETCH_OBJ);

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
                    <h5 class="m-0 text-white"><a href="property_category_menu.php" class="text-white">View Category</a> / <?= $row->name ?></h5>
                </div>

                <!-- card body open --> 
                <div class="card-body">

                  <!-- row open --> 
                  <div class="row">

                    <input type="hidden" value="<?= $propertyid ?>" id="propertyidhidden">

                    <div class="col-lg-6 col-sm-12">
                      <div class="small-box" style="background-color:rgb(249,249,247);">
                        <div class="inner" >
                          <h3 class="text-black"><?= $row->name ?></h3>
                          <p class="text-black">Category Name</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-bag"></i>
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                      <div class="small-box" style="background-color:rgb(249,249,247);">
                        <div class="inner" >
                          <h3 class="text-black"><?= $itemcount ?></h3>
                          <p class="text-black">Item Count</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-bag"></i>
                        </div>
                      </div>
                    </div>


                    <div class="col-lg-6 col-sm-12">
                      <div class="small-box" style="background-color:rgb(249,249,247);">
                        <div class="inner" >
                          <h3 class="text-black"><?= number_format($row2->total_acq_amount,2) ?></h3>
                          <!-- <p class="text-black">Current Month Acquisition <b>(<?= strtoupper($monthnow_word).' '.$yearnow ?>)</b></p> -->
                          <p class="text-black">Current Month Acquisition</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-bag"></i>
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                      <div class="small-box" style="background-color:rgb(249,249,247);">
                        <div class="inner" >
                          <h3 class="text-black"><?= number_format($total_carrying_amount,2) ?></h3>
                          <p class="text-black">Carrying Amount</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-bag"></i>
                        </div>
                      </div>
                    </div>


                  </div>
                  <!-- row close -->


            <div class="row">

            <div class="col-sm-12">
                <a href="property_category_add_data.php?id=<?= $propertyid ?>" class="btn btn-md btn-primary float-sm-right"><span class="fa fa-plus"  data-toggle="tooltip" title="View Category" ></span>&nbsp;&nbsp;Add Data</a>
            </div>
        

                    <div class="col-md-12 mt-3">
                          <div class="table-responsive-sm">
                            <font face="verdana">
                              <table id="property_fetch_category_details_datatable" class="table table-hover" style="width: 100%">
                                  <thead>
                                      <tr>

                                          <td style="font-weight: bold;" align="center">
                                              <font size="2">Id</font>
                                          </td>

                                          <td style="font-weight: bold;" align="center">
                                            <font size="2">Acq date</font>
                                          </td> 

                                          <td style="font-weight: bold;" align="center">
                                            <font size="2">User</font>
                                          </td> 

                                          <td style="font-weight: bold;" align="center">
                                            <font size="2">Department</font>
                                          </td> 

                                          <td style="font-weight: bold;" align="center">
                                            <font size="2">Brand</font>
                                          </td>

                                          <td style="font-weight: bold;" align="center">
                                            <font size="2">Model #</font>
                                          </td> 

                                          <td style="font-weight: bold;" align="center">
                                            <font size="2">Cost</font>
                                          </td> 

                                          <td style="font-weight: bold;" align="center">
                                            <font size="2">EUL</font>
                                          </td>

                                          <td style="font-weight: bold;" align="center">
                                            <font size="2">DEP'N</font>
                                          </td> 

                                          <td style="font-weight: bold;" align="center">
                                            <font size="2">ACCUM DEP'N</font>
                                          </td> 

                                          <td style="font-weight: bold;" align="center">
                                            <font size="2">Carrying amount</font>
                                          </td>

                                          <td style="font-weight: bold;" align="center">
                                            <font size="2">Status</font>
                                          </td>

                                          <td style="font-weight: bold;" align="center">
                                            <font size="2">Action</font>
                                          </td> 

                                      </tr>
                                  </thead>
                                </table>
                              </font>
                          </div>
                      </div>

              </div>

                </div>  
                <!-- card body close -->







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

    var propertyidhidden = $('#propertyidhidden').val();

    // alert(propertyidhidden);


    var property_fetch_category_details_datatable = $('#property_fetch_category_details_datatable').DataTable(
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
          url:"property_fetch_category_info.php?id="+propertyidhidden,
          type:"post"
        }  

    });



$(document).on('click','#btndeletepropertydata',function()
    {

      var id = $(this).data('id');

      // alert(id);

      Swal.fire({
      title: 'Do you want to delete data?',
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
              url: 'property_delete_data.php',
              type: 'post',
              data:'id='+id,
              success: function(data) 
              {
                $('#property_fetch_category_details_datatable').DataTable().ajax.reload(null, false);
              }
            });

            Swal.fire(
              'Data deleted!',
              '',
              'success'
            )
          }
        })

    })


  })
</script>
