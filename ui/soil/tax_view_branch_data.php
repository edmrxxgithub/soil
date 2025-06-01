<?php
include_once 'connectdb.php';
include_once 'function.php';

session_start();

function fetch_month_data($pdo,$yearnow,$monthnum,$branchid)
{
  $days_in_a_month = date("t", strtotime("$yearnow-$monthnum-01"));
  $date_from = $yearnow.'-'.$monthnum.'-01';
  $date_to = $yearnow.'-'.$monthnum.'-'.$days_in_a_month;

  $select = $pdo->prepare("SELECT SUM(gross_amount) as total_gross_amount FROM tb_tax_sales where date between '$date_from' and '$date_to' and branch_id = '$branchid' ");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);

  return $row->total_gross_amount;

  
}


function fetch_data($pdo,$id)
{
  $select = $pdo->prepare("SELECT * FROM tb_tax_branch WHERE id = '$id' ");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);

  $businessid = $row->business_id;

  $select1 = $pdo->prepare("SELECT * FROM tb_tax_business WHERE id = '$businessid' ");
  $select1->execute();
  $row1 = $select1->fetch(PDO::FETCH_OBJ);

  $clientid = $row1->client_id;

  $select2 = $pdo->prepare("SELECT * FROM tb_tax_client WHERE id = '$clientid' ");
  $select2->execute();
  $row2 = $select2->fetch(PDO::FETCH_OBJ);

  $array['clientid'] = $clientid;
  $array['clientname'] = $row2->name;

  $array['businessid'] = $businessid;
  $array['businessname'] = $row1->name;

  $array['address'] = $row->address;

  return $array;

}


if($_SESSION['userid']=="" )
{

header('location:../../index.php');

}
else
{
  $id = $_SESSION['userid'];
}

include_once "header.php";

$branchid = $_GET['id'];
$yearnow = $_GET['yearnow'];

$data = fetch_data($pdo,$branchid);




?>


<div class="modal fade" id="1_upload_data_modal">
  <div class="modal-dialog">

    <form method="post" id="SubmitUploadSales">

    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Upload data menu</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <div class="modal-body">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-12 mt-3">
                 <div class="form-group"> 
                    <label style="font-weight: bold;">Select file</label>
                    <input type="file"  class="form-control" required="" id="SalesUploadFile"  name="SalesUploadFile" />
                  </div>
                  <span id="load_upload_excel_data"></span>
                </div>
              </div>
            </div>
        </div>

      </div>



      <div class="modal-footer justify-content-between">
        <input type="submit" id="confirmupload_button_excel" class="btn btn-sm btn-primary float-end" value="CONFIRM UPLOAD" >
      </div>
    </div>    
  </form>

  </div>
</div>













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
                    <a href="tax_view_client.php?id=<?= $data['clientid'] ?>" class="text-white"><?= $data['clientname'] ?></a> / 
                    <a href="tax_view_client_business.php?id=<?= $data['businessid'] ?>" class="text-white"><?= $data['businessname'] ?></a> / <?= $data['address'] ?></a> 
                  </h5>
                </div>


<?php

// echo $data['clientid'].' '.$data['businessid'].' '.$branchid;

?>

                <!-- card body open -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">


<input type="hidden" id="branchid_php" value="<?= $branchid ?>">
<input type="hidden" id="yearnow_php" value="<?= $yearnow ?>">



<ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#dashboard_data" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Dashboard</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#tax_return_data" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Tax return</a>
    </li>

  
<!--     <li class="nav-item">
      <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#purchases_data" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Purchases</a>
    </li> -->


    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#january_data" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Jan</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-messages-tab" data-toggle="pill" href="#february_data" role="tab" aria-controls="custom-content-below-messages" aria-selected="false">Feb</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#march_data" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">Mar</a>
    </li>




    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#april_data" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">Apr</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#may_data" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">May</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#june_data" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">Jun</a>
    </li>


    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#july_data" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">Jul</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#aug_data" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">Aug</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#sep_data" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">Sep</a>
    </li>


    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#oct_data" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">Oct</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#nov_data" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">Nov</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#dec_data" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">Dec</a>
    </li>


    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#purchases_data" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Purchases</a>
    </li>


    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#vat_purchase_data" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">VAT Expense</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#non_vat_purchase_data" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">NONVAT Expense</a>
    </li>


    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#qap_it" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">QAP IT</a>
    </li>


    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#qap_vt" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">QAP VT</a>
    </li>


    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#sawt_it" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">SAWT IT</a>
    </li>


    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#sawt_vt" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">SAWT VT</a>
    </li>


    <li class="nav-item">
      <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#upload_tab" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">Upload</a>
    </li>

</ul>


<div class="tab-content" id="custom-content-below-tabContent">
    <div class="tab-pane fade show active" id="dashboard_data" role="tabpanel" aria-labelledby="custom-content-below-home-tab">


<!-- col-12 open -->
<div class="col-sm-12 col-md-12 col-lg-12">
  <!-- row open -->
  <div class="row">

    <div class="col-sm-12 col-md-8 col-lg-8 mt-4">
      <!-- SALES REVENUE DATA -->
      <span id="load_sales_revenue"></span>
    </div>

    <div class="col-sm-12 col-md-12 col-lg-4 mt-4">
      <!-- SALES REVENUE BY QUARTER VATABLE -->
      <span id="load_sales_revenue_by_quarter"></span>
      <br><br>
      <!-- PURCHASES BY QUARTER VATABLE -->
      <span id="load_purchases_computation"></span>
    </div>


    <!-- PURCHASES DECLARATION -->
    <div class="col-sm-12 col-md-12 col-lg-8 mt-4">
      <span id="load_purchases_all_month"></span>
    </div>

    <div class="col-sm-12 col-md-12 col-lg-4 mt-4">
      <span id="it_vt_computation_by_quarter"></span>
    </div>

    <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
      <span id="general_summary_report"></span>
    </div>

  </div>
  <!-- row close -->
</div>       
<!-- col-12 open -->



  </div>

    <div class="tab-pane fade" id="purchases_data" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
      
      <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_purchase_data"></span>
      </div>

    </div>


    <div class="tab-pane fade" id="tax_return_data" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
      
      <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="tax_return_load_data_q1"></span>
        <span id="tax_return_load_data_q2"></span>
        <span id="tax_return_load_data_q3"></span>
        <span id="tax_return_load_data_q4"></span>

        

      </div>

    </div>


    <div class="tab-pane fade" id="january_data" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
      
      <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_january_data"></span>
      </div>

    </div>


    <div class="tab-pane fade" id="february_data" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">

      <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_february_data"></span>
      </div>

    </div>


    <div class="tab-pane fade" id="march_data" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
       
      <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_march_data"></span>
      </div>

    </div>



    <div class="tab-pane fade" id="april_data" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">

       <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_april_data"></span>
      </div>

    </div>
    <div class="tab-pane fade" id="may_data" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">

       <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_may_data"></span>
      </div>

    </div>

    <div class="tab-pane fade" id="june_data" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">

       <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_june_data"></span>
      </div>

    </div>



    <div class="tab-pane fade" id="july_data" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
       <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_july_data"></span>
      </div>
    </div>


    <div class="tab-pane fade" id="aug_data" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
       <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_august_data"></span>
      </div>
    </div>


    <div class="tab-pane fade" id="sep_data" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
       <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_september_data"></span>
      </div>
    </div>




    <div class="tab-pane fade" id="oct_data" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
       <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_october_data"></span>
      </div>
    </div>

    <div class="tab-pane fade" id="nov_data" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
       <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_november_data"></span>
      </div>
    </div>

    <div class="tab-pane fade" id="dec_data" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
       <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_december_data"></span>
      </div>
    </div>






    <div class="tab-pane fade" id="vat_purchase_data" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
       <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_vat_purchase_data"></span>
      </div>
    </div>


    <div class="tab-pane fade" id="non_vat_purchase_data" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
       <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_non_vat_purchase_data"></span>
      </div>
    </div>

    <div class="tab-pane fade" id="qap_it" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
       <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_qap_it_data"></span>
      </div>
    </div>


    <div class="tab-pane fade" id="qap_vt" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
       <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_qap_vt_data"></span>
      </div>
    </div>


    <div class="tab-pane fade" id="sawt_it" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
       <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_sawt_it_data"></span>
        <!-- Sawt it pending.... -->
      </div>
    </div>


    <div class="tab-pane fade" id="sawt_vt" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
       <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <span id="load_sawt_vt_data"></span>
      </div>
    </div>

    <div class="tab-pane fade" id="upload_tab" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">

       <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
        <div class="row">
          <div class="col-sm-6 col-md-6 col-lg-6">
              <button class="btn btn-primary btn-md float-end" id="uploadsalesmodal">Upload data</button>
          </div>
        </div>
        <!-- <span id="load_upload_data">Upload data</span> -->
      </div>
    </div>


</div>


</div>

                  </div>
                </div>
                <!-- card body open -->


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


var branchid_php = $('#branchid_php').val();
var yearnow_php = $('#yearnow_php').val();

//SALES SUMMARY
// $('#load_sales_revenue').load('tax_load_sales_revenue_data.php?yearnow='+yearnow_php+'&branchid='+branchid_php);
$('#load_sales_revenue').load('tax_load_sales_revenue_data2.php?yearnow='+yearnow_php+'&branchid='+branchid_php);

//SALES SUMMARY BY QUARTER
$('#load_sales_revenue_by_quarter').load('tax_load_sales_revenue_by_quarter.php?yearnow='+yearnow_php+'&branchid='+branchid_php);

//PURCHASES DATA
$('#load_purchases_all_month').load('tax_load_purchases_per_month.php?yearnow='+yearnow_php+'&branchid='+branchid_php);

//PURCHASES COMPUTATION
$('#load_purchases_computation').load('tax_load_purchases_computation.php?yearnow='+yearnow_php+'&branchid='+branchid_php);

//VT AND IT COMPUTATION
// $('#load_computation').load('tax_load_computation.php?yearnow='+yearnow_php+'&branchid='+branchid_php);
$('#it_vt_computation_by_quarter').load('tax_load_benchmark_computation.php?yearnow='+yearnow_php+'&branchid='+branchid_php);


//GENERAL SUMMARY REPORT DATA
// $('#general_summary_report').load('tax_load_general_summary_report.php?monthnow=1&yearnow='+yearnow_php+'&branchid='+branchid_php);
// $('#general_summary_report').load('tax_load_general_summary_report2.php?monthnow=1&yearnow='+yearnow_php+'&branchid='+branchid_php);
$('#general_summary_report').load('tax_load_general_summary_report2.php?monthnow=1&yearnow='+yearnow_php+'&branchid='+branchid_php);


//TAX RETURN DATA
$('#tax_return_load_data_q1').load('tax_return_load_data2_q1.php?yearnow='+yearnow_php+'&branchid='+branchid_php);
$('#tax_return_load_data_q2').load('tax_return_load_data2_q2.php?yearnow='+yearnow_php+'&branchid='+branchid_php);
$('#tax_return_load_data_q3').load('tax_return_load_data2_q3.php?yearnow='+yearnow_php+'&branchid='+branchid_php);
$('#tax_return_load_data_q4').load('tax_return_load_data2_q4.php?yearnow='+yearnow_php+'&branchid='+branchid_php);


// PURCHASE DATA TAB
$('#load_purchase_data').load('tax_load_purchase_monthly_data.php?monthnow=1&yearnow='+yearnow_php+'&branchid='+branchid_php);





$('#load_january_data').load('tax_load_sales_monthly_data.php?monthnow=1&yearnow='+yearnow_php+'&branchid='+branchid_php);
$('#load_february_data').load('tax_load_sales_monthly_data.php?monthnow=2&yearnow='+yearnow_php+'&branchid='+branchid_php);
$('#load_march_data').load('tax_load_sales_monthly_data.php?monthnow=3&yearnow='+yearnow_php+'&branchid='+branchid_php);

$('#load_april_data').load('tax_load_sales_monthly_data.php?monthnow=4&yearnow='+yearnow_php+'&branchid='+branchid_php);
$('#load_may_data').load('tax_load_sales_monthly_data.php?monthnow=5&yearnow='+yearnow_php+'&branchid='+branchid_php);
$('#load_june_data').load('tax_load_sales_monthly_data.php?monthnow=6&yearnow='+yearnow_php+'&branchid='+branchid_php);

$('#load_july_data').load('tax_load_sales_monthly_data.php?monthnow=7&yearnow='+yearnow_php+'&branchid='+branchid_php);
$('#load_august_data').load('tax_load_sales_monthly_data.php?monthnow=8&yearnow='+yearnow_php+'&branchid='+branchid_php);
$('#load_september_data').load('tax_load_sales_monthly_data.php?monthnow=9&yearnow='+yearnow_php+'&branchid='+branchid_php);

$('#load_october_data').load('tax_load_sales_monthly_data.php?monthnow=10&yearnow='+yearnow_php+'&branchid='+branchid_php);
$('#load_november_data').load('tax_load_sales_monthly_data.php?monthnow=11&yearnow='+yearnow_php+'&branchid='+branchid_php);
$('#load_december_data').load('tax_load_sales_monthly_data.php?monthnow=12&yearnow='+yearnow_php+'&branchid='+branchid_php);

//VAT PURCHASE DATA
$('#load_vat_purchase_data').load('tax_load_vat_purchase_data.php?monthnow=1&yearnow='+yearnow_php+'&branchid='+branchid_php);



//NON VAT PURCHASE DATA
$('#load_non_vat_purchase_data').load('tax_load_non_vat_purchase.php?monthnow=1&yearnow='+yearnow_php+'&branchid='+branchid_php);



//LOAD QAP IT
$('#load_qap_it_data').load('tax_load_qap_it.php?monthnow=1&yearnow='+yearnow_php+'&branchid='+branchid_php);

//LOAD QAP VT
$('#load_qap_vt_data').load('tax_load_qap_vt.php?monthnow=1&yearnow='+yearnow_php+'&branchid='+branchid_php);

//LOAD SAWT IT
$('#load_sawt_it_data').load('tax_load_sawt_it.php?monthnow=1&yearnow='+yearnow_php+'&branchid='+branchid_php);

//LOAD SAWT VT
$('#load_sawt_vt_data').load('tax_load_sawt_vt.php?monthnow=1&yearnow='+yearnow_php+'&branchid='+branchid_php);
      
  });


$(document).on('click','#uploadsalesmodal',function()
{
    $('#1_upload_data_modal').modal('show');
})



$(document).on('submit','#SubmitUploadSales',function(event)
{

          event.preventDefault();

          var form_data = $(this).serialize();

          var file_data = $('#SalesUploadFile').prop('files')[0];   

          var form_data = new FormData();
          form_data.append('file', file_data);
          form_data.append('branchid', <?= $branchid ?>);
          form_data.append('clientid', <?= $data['clientid'] ?>);
          form_data.append('businessid', <?= $data['businessid'] ?>);

          $('#confirmupload_button_excel').prop('disabled', true);

           $.ajax({
                // url:'tax_compute/file3.php', 
                url:'tax_compute/file5.php', 
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: form_data, 
                type: 'post',
                 beforeSend: function() 
                  {
                    

                      $('#load_upload_excel_data').html(`
                            <div style="display: flex; align-items: center;">
                              <div class="spinner-border text-primary" role="status" style="margin-right: 10px;">
                                <span class="visually-hidden"></span>
                              </div>
                              <b>Uploading excel, please wait...</b>
                            </div>`);

                  },
                success: function(data)
                {   
                   // alert(data);
                    
                  $('#1_upload_data_modal').modal('hide');
                  $('#load_upload_excel_data').html('');
                  $('#confirmupload_button_excel').prop('disabled', false);

                  Swal.fire({
                      title: 'File uploaded successfully!',
                      text: "Press yes to continue!",
                      icon: 'success',
                      showCancelButton: false,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes'
                    }).then((result) => 
                    {
                      if (result.isConfirmed) 
                      {

                        // location.reload();

                      }

                    })


                }
             });


})


</script>



















