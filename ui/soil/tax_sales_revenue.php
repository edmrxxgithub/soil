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

function fill_client($pdo)
{

    $output='';
    $select=$pdo->prepare("SELECT * FROM tb_tax_client order by id asc");
    $select->execute();
    $result=$select->fetchAll();
    foreach($result as $row)
    {
        $output.='<option value="'.$row["id"].'">'.$row["name"].'</option>';
    }

    return $output;

}


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
                  <h5 class="m-0 text-white">View Sales Revenue</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <!-- <div class="col-sm-3 col-lg-3">
                                <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="clientid" id="clientid">
                                              <option value="">Select client</option>
                                              <?php echo fill_client($pdo);?>
                                </select>
                    </div>
                    <div class="col-sm-3 col-lg-3">
                                <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="businessid" id="businessid">
                                      <option value="">Select business</option>
                                </select>
                    </div>
                    <div class="col-sm-3 col-lg-3">
                                <select class="form-control select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required="" name="branchid" id="branchid">
                                      <option value="">Select branch</option>
                                </select>
                    </div> -->


                    <div class="col-sm-3 col-lg-12">
                      <a href="tax_add_sales_revenue.php" class="btn btn-md btn-primary float-md-right">Add sales revenue</a>
                      <!-- <button class="btn btn-sm btn-warning float-sm-right" id="clearfilter">Clear filter</button> -->
                    </div>


                    <div class="col-md-12 mt-3">
                          <div class="table-responsive-sm">
                            <font face="verdana">
                              <table id="sales_revenue_datatable" class="table table-hover" style="width: 100%">
                                  <thead>
                                      <tr>
                                          <td style="font-weight: bold;" align="center">Id</td>
                                          <td style="font-weight: bold;" align="center"><font size="2">Date</font></td>

                                          <td style="font-weight: bold;" align="center"><font size="2">Client id</font></td>
                                          <td style="font-weight: bold;" align="center"><font size="2">Business id</font></td>
                                          <td style="font-weight: bold;" align="center"><font size="2">Branch id</font></td>

                                          <td style="font-weight: bold;" align="center"><font size="2">Client</font></td>
                                          <td style="font-weight: bold;" align="center"><font size="2">Business</font></td>
                                          <td style="font-weight: bold;" align="center"><font size="2">Branch</font></td>

                                          <td style="font-weight: bold;" align="center"><font size="2">Gross</font></td>
                                          <td style="font-weight: bold;" align="center"><font size="2">Vat</font></td>
                                          <td style="font-weight: bold;" align="center"><font size="2">Vat net</font></td>

                                          <td style="font-weight: bold;" align="center"><font size="2">Withhold(CWT)</font></td>
                                          <td style="font-weight: bold;" align="center"><font size="2">Withhold(VWT)</font></td>

                                           <td style="font-weight: bold;" align="center"><font size="2">Collectible</font></td>

                                          <td style="font-weight: bold;" align="center"><font size="2">Action</font></td>
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

      //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    $('[data-toggle="tooltip"]').tooltip();



    // var sales_revenue_datatable = $('#sales_revenue_datatable').DataTable(
    // {
    //   "order": [[ 0, 'desc' ]],

    //     "responsive": true,
    //      "autoWidth": true,
    //   "lengthChange": true,
    // "iDisplayLength": 10,

    // "columnDefs":
    //     [
    //         {
    //             "targets": [0,2,3,4],
    //           // "targets": [0,1,2,3],
    //             "visible": false,
    //             "searchable": true,
    //         },
    //     ],




    //     "ajax":
    //     {
    //       // url:"tax_fetch_sales_revenue_data.php",
    //       url:"tax_fetch_sales_revenue_data2.php",
    //       type:"post"
    //     } ,


    // });



    // $('#sales_revenue_datatable').DataTable({
    //     "processing": true,
    //     "serverSide": true,
    //     "ajax": "tax_fetch_sales_revenue_data3.php", // updated backend
    //     "pageLength": 25,
          

    //     "order": [[ 0, 'desc' ]],
    //     "columnDefs":
    //     [
    //         {
                
    //             "targets": [2,3,4],
    //             // "targets": [0,2,3,4],
    //             "visible": false,
    //             "searchable": true,
    //         },
    //     ],


    //     "columns": 
    //     [
    //         { "data": 0 },
    //         { "data": 1 },
    //         { "data": 2 },
    //         { "data": 3 },
    //         { "data": 4 },
    //         { "data": 5 },
    //         { "data": 6 },
    //         { "data": 7 },
    //         { "data": 8 },
    //         { "data": 9 },
    //         { "data": 10 },
    //         { "data": 11 },
    //         { "data": 12 },
    //         { "data": 13 },
    //         { "data": 14 }
    //     ]

    // });





// $(document).on('change','#clientid',function()
// {

//   var clientid = $('#clientid').val();

//   alert(clientid);

//   sales_revenue_datatable.columns(2).search(clientid).draw();

//   $.ajax({
//     url: 'tax_fetch_data.php',
//     type: 'post',
//     data:'id='+clientid,
//     dataType:'json',
//     success: function(data)
//     {
//       // alert(data.businessid);
//       $('#businessid').html(data.businessid);
//     }
//   });

// })




// $(document).on('change','#businessid',function()
// {

//   var businessid = $('#businessid').val();

//   sales_revenue_datatable.columns(3).search(businessid).draw();

//   $.ajax({
//     url: 'tax_fetch_data.php',
//     type: 'post',
//     data:'id='+businessid,
//     dataType:'json',
//     success: function(data)
//     {
//       $('#tin').val(data.tin);
//       $('#branchid').html(data.branchid);
//     }
//   });

// })




// $(document).on('change','#branchid',function()
// {

//   var branchid = $('#branchid').val();

//   sales_revenue_datatable.columns(4).search(branchid).draw();

// })



// $(document).on('click','#clearfilter',function()
// {

//     reset_filter();

// })


var sales_revenue_datatable = $('#sales_revenue_datatable').DataTable({
  "processing": true,
  "serverSide": true,
  "ajax": "tax_fetch_sales_revenue_data3.php",
  "pageLength": 25,
  
  "order": [[ 0, 'desc' ]],

  "columnDefs": [
    {
      "targets": [2, 3, 4],
      "visible": false,
      "searchable": true,
    },
  ],


  "columns": [
    { "data": 0 }, { "data": 1 }, { "data": 2 }, { "data": 3 }, { "data": 4 },
    { "data": 5 }, { "data": 6 }, { "data": 7 }, { "data": 8 }, { "data": 9 },
    { "data": 10 }, { "data": 11 }, { "data": 12 }, { "data": 13 }, { "data": 14 }
  ]
});








// reset_filter();
function reset_filter()
{

  // alert('helloworld!');

    // sales_revenue_datatable.columns(1).search('').draw();
    // sales_revenue_datatable.columns(2).search('').draw();
    // sales_revenue_datatable.columns(3).search('').draw();

    sales_revenue_datatable.columns(2).search('').draw();
    sales_revenue_datatable.columns(3).search('').draw();
    sales_revenue_datatable.columns(4).search('').draw();

    $.ajax({
    url: 'tax_fetch_client_data.php',
    type: 'post',
    success: function(data)
    {
      $('#clientid').html(data);
      $('#businessid').html('');
      $('#branchid').html('');
    }
  });


}



$(document).on('click','#btn_delete_sales_revenue',function()
    {

      var id = $(this).data('id');

      // alert(id);

          Swal.fire({
          title: 'Delete sales revenue data?',
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
                  url: 'tax_delete_sales_revenue.php',
                  type: 'post',
                  data:'id='+id,
                  success: function(data)
                  {
                    $('#sales_revenue_datatable').DataTable().ajax.reload(null, false);
                  }
                });

                Swal.fire(
                  'Sales revenue data deleted!',
                  '',
                  'success'
                )
              }
            })

        })





  });
</script>
