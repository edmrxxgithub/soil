<?php 
include_once 'connectdb.php';


$yearnow = $_GET['yearnow'];
$branchid = $_GET['branchid'];

$monthfrom = 10;
$monthto = 12;
$quarter_num = 4;

$date_from = $yearnow.'-'.$monthfrom.'-1';

$number_of_days = date("t", strtotime("$yearnow-$monthto-1"));

$date_to = $yearnow.'-'.$monthto.'-'.$number_of_days;



$data_rr = fetch_data($pdo,$date_from,$date_to,$branchid);


function fetch_data($pdo,$date_from,$date_to,$branchid)
{

  $select1 = $pdo->prepare("SELECT SUM(net_amount) as total_sales_net_amount FROM tb_tax_sales WHERE date between '$date_from' and '$date_to' and branch_id = '$branchid' ");
  $select1->execute();
  $row1 = $select1->fetch(PDO::FETCH_OBJ);

  $select2 = $pdo->prepare("SELECT SUM(net_amount) as total_purchase_net_amount FROM tb_tax_purchase WHERE date between '$date_from' and '$date_to' and branch_id = '$branchid' ");
  $select2->execute();
  $row2 = $select2->fetch(PDO::FETCH_OBJ);

  $select3 = $pdo->prepare("SELECT SUM(net_amount) as total_vat_purchase_net_amount FROM tb_tax_vat_purchase WHERE date between '$date_from' and '$date_to' and branch_id = '$branchid' ");
  $select3->execute();
  $row3 = $select3->fetch(PDO::FETCH_OBJ);

  $select4 = $pdo->prepare("SELECT SUM(gross_amount) as total_non_vat_purchase_net_amount FROM tb_tax_non_vat_purchase WHERE date between '$date_from' and '$date_to' and branch_id = '$branchid' ");
  $select4->execute();
  $row4 = $select4->fetch(PDO::FETCH_OBJ);

   $select5 = $pdo->prepare("SELECT SUM(withholding_total_vwt) as withholding_total_vwt FROM tb_tax_sales WHERE date between '$date_from' and '$date_to' and branch_id = '$branchid' ");
  $select5->execute();
  $row5 = $select5->fetch(PDO::FETCH_OBJ);

  $select6 = $pdo->prepare("SELECT SUM(withholding_total_cwt) as withholding_total_cwt FROM tb_tax_sales WHERE date between '$date_from' and '$date_to' and branch_id = '$branchid' ");
  $select6->execute();
  $row6 = $select6->fetch(PDO::FETCH_OBJ);

  $array['total_sales'] = $row1->total_sales_net_amount;
  $array['total_purchase'] = $row2->total_purchase_net_amount;
  $array['total_vat_purchase'] = $row3->total_vat_purchase_net_amount;
  $array['total_non_vat_purchase'] = $row4->total_non_vat_purchase_net_amount;
  $array['total_swt_vt'] = $row5->withholding_total_vwt;
  $array['total_swt_it'] = $row6->withholding_total_cwt;

  return $array;

}




$non_vat_expenses = $data_rr['total_vat_purchase'] + $data_rr['total_non_vat_purchase'];
$less_deductions = $data_rr['total_vat_purchase'] + $data_rr['total_non_vat_purchase'];


?>


<input type="hidden" id="sample_fetch_data" name="">
<input type="hidden" id="quarter_num" value="<?= $quarter_num ?>">
<input type="hidden" id="branch_id"   value="<?= $branchid ?>">
<input type="hidden" id="year_now"   value="<?= $yearnow ?>">



<!-- ///////////// QUARTER 1 TAX RETURN  /////////// -->
<!-- <div class="card card-default "> -->
<div class="card card-default collapsed-card">
  <!-- <div class="card-header" style="background-color:rgba(12,25,60,255);"> -->
    <div class="card-header" style="background-color:rgb(237,233,207,255);">
    <h3 class="card-title text-black" >QUARTER 4</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-plus"></i> <!-- Will show plus icon since it's collapsed -->
      </button>
    </div>
  </div>
  <!-- /.card-header -->
  <div class="card-body">

    <center>
      <h4>TAX RETURNS INFORMATION</h4>
    </center>
    
<div class="col-sm-12 col-md-12 col-lg-12">
  <div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6">

      <table border="1" width="100%">

            <tr align="center"><th><font class="text-black" size="2">SCHEDULE #</font></th>
              <th><font class="text-black" size="2">VALUE-ADDED TAX INFORMATION</font></th>
              <th><font class="text-black" size="2"></font></th>
              <th><font class="text-black" size="2"></font></th>
            </tr>

            <?php include_once 'tax_return_q4/tax_fetch_data1.php'?>

            <tr>
              <td colspan="4"><br></td>
            </tr>

            <?php include_once 'tax_return_q4/tax_fetch_data2.php'?>

            <tr>
              <td colspan="4"><br></td>
            </tr>

            <?php include_once 'tax_return_q4/tax_fetch_data3.php'?>

            <tr>
              <td colspan="4"><br></td>
            </tr>
            
            <?php include_once 'tax_return_q4/tax_fetch_data4.php'?>

            <tr>
              <td colspan="4"><br></td>
            </tr>

            <?php include_once 'tax_return_q4/tax_fetch_data5.php'?>
      
      </table>

    <!-- <center>
      <button class="btn btn-sm btn-primary mt-3" id="q4_compute_value_add_tax_info">Compute</button>
      <button class="btn btn-sm btn-success mt-3">Save data</button>
    </center> -->

  </div>  




<div class="col-sm-12 col-md-6 col-lg-6">

      <table border="1" width="100%">

            <tr align="center"><th><font class="text-black" size="2">SCHEDULE #</font></th>
              <th><font class="text-black" size="2">INCOME TAX INFORMATION</font></th>
              <th><font class="text-black" size="2"></font></th>
              <th><font class="text-black" size="2"></font></th>
            </tr>

            <?php include_once 'tax_return_q4/tax_fetch_data6.php'?>

            <tr>
              <td colspan="4"><br></td>
            </tr>

            <?php include_once 'tax_return_q4/tax_fetch_data7.php'?>

            <tr>
              <td colspan="4"><br></td>
            </tr>

            <?php include_once 'tax_return_q4/tax_fetch_data8.php'?>

            <tr>
              <td colspan="4"><br></td>
            </tr>

            <?php include_once 'tax_return_q4/tax_fetch_data9.php'?>

            <tr>
              <td colspan="4"><br></td>
            </tr>

            <?php include_once 'tax_return_q4/tax_fetch_data10.php'?>
      
      </table>

  </div>



      <div class="col-sm-12 col-md-12 col-lg-12">
        <center>
            <button class="btn btn-sm btn-primary mt-3" style="display: none;" id="q4_compute_value_add_tax_info">Compute</button>
            <button class="btn btn-md btn-success mt-3" id="q4_save_data">Save data</button>
        </center>
      </div>



  </div>
</div>
















  </div>
  
</div>
<!-- ///////////// QUARTER 1 TAX RETURN  /////////// -->






<script type="text/javascript">
  $(document).ready(function()
  {

    var quarter_num = $('#quarter_num').val();
    var branch_id = $('#branch_id').val();
    var year_now = $('#year_now').val();

          var form_data1 = 
          { 

            quarter_num : quarter_num,
            branch_id : branch_id,
            year_now : year_now

          };

          $.ajax({
            url:'tax_initiate_data4.php',
            method:"POST",
            data:form_data1,
            dataType:'json',
            success:function(data)
            {    
                $('#q4_government_sales_principal').val(data.government_sales);
                $('#q4_zero_rated_sales_principal').val(data.zero_rated_sales);
                $('#q4_exempt_sales_principal').val(data.exempt_sales);
                $('#q4_other_expense_principal').val(data.other_expenses);
                $('#q4_vat_payment_previous_principal').val(data.vat_payment_previous);
                $('#q4_tax_actual_paid_accessory').val(data.tax_actually_paid_success);

                $('#q4_less_cost_of_sales_accessory').val(data.cost_of_sales);

                $('#q4_other_expenses_value_principal_2').val(data.other_expenses_2);
                $('#q4_net_taxable_income_previous_quarter_accessory').val(data.tax_income_previous);
                $('#q4_tax_rate_principal').val(data.tax_rate);
                $('#q4_mcit_percent_principal').val(data.mcit);
                $('#q4_it_payment_previous_principal').val(data.it_payment_previous);
                $('#q4_income_tax_actually_paid_accessory').val(data.income_tax_actually_paid_success);

                
                $('#q4_compute_value_add_tax_info').click();
                
            }
          });


    $(document).on('click','#q4_compute_value_add_tax_info',function()
    {

      // alert('God is good, life is good 111');

      var q4_government_sales_principal = $('#q4_government_sales_principal').val();
      var q4_zero_rated_sales_principal = $('#q4_zero_rated_sales_principal').val();
      var q4_exempt_sales_principal = $('#q4_exempt_sales_principal').val();

      var q4_total_vat_purchase_accessory = $('#q4_total_vat_purchase_accessory').val();
      var q4_less_cost_of_sales_accessory = $('#q4_less_cost_of_sales_accessory').val();
      var q4_net_taxable_income_previous_quarter_accessory = $('#q4_net_taxable_income_previous_quarter_accessory').val();

      var q4_tax_rate_principal = $('#q4_tax_rate_principal').val();
      var q4_mcit_percent_principal = $('#q4_mcit_percent_principal').val();
      var q4_vat_payment_previous_principal = $('#q4_vat_payment_previous_principal').val();

      var q4_it_payment_previous_principal = $('#q4_it_payment_previous_principal').val();
      var q4_income_tax_actually_paid_accessory = $('#q4_income_tax_actually_paid_accessory').val();

      var q4_tax_actual_paid_accessory = $('#q4_vat_expense_principal').val();
      var q4_vat_expense_principal = $('#q4_vat_expense_principal').val();
      var q4_other_expenses_value_principal_2 = $('#q4_other_expenses_value_principal_2').val();


// q4_government_sales_principal
// q4_zero_rated_sales_principal
// q4_exempt_sales_principal
// q4_vat_payment_previous_principal
// q4_tax_actual_paid_accessory
// q4_vat_expense_principal


// q4_less_cost_of_sales_accessory
// q4_net_taxable_income_previous_quarter_accessory
// q4_tax_rate_principal
// q4_mcit_percent_principal
// q4_it_payment_previous_principal
// q4_income_tax_actually_paid_accessory
      
      

            $.ajax({
            // url:'tax_compute_data3.php',
            url:'tax_compute_data4.php',
            method:"POST",
            data:'q4_vatable_sales='+<?= $data_rr['total_sales'] ?>+
                  '&isset=data4'+
                  '&q4_government_sales_principal='+q4_government_sales_principal+'&q4_zero_rated_sales_principal='+q4_zero_rated_sales_principal+'&q4_exempt_sales_principal='+q4_exempt_sales_principal+'&q4_total_vat_purchase_accessory='+q4_total_vat_purchase_accessory+'&sawt_vt='+<?= $data_rr['total_swt_vt'] ?>+'&q4_less_cost_of_sales_accessory='+q4_less_cost_of_sales_accessory+'&non_vat_expenses='+<?= $non_vat_expenses ?>+'&q4_net_taxable_income_previous_quarter_accessory='+q4_net_taxable_income_previous_quarter_accessory+'&q4_tax_rate_principal='+q4_tax_rate_principal+'&q4_mcit_percent_principal='+q4_mcit_percent_principal+'&q4_vat_payment_previous_principal='+q4_vat_payment_previous_principal+'&sawt_it='+<?= $data_rr['total_swt_it'] ?>+'&q4_it_payment_previous_principal='+q4_it_payment_previous_principal+'&q4_tax_actual_paid_accessory='+q4_tax_actual_paid_accessory+'&q4_vat_expense_principal='+q4_vat_expense_principal+'&q4_other_expenses_value_principal_2='+q4_other_expenses_value_principal_2+'&less_deductions='+<?= $less_deductions ?>,
            dataType:'json',
            success:function(data)
            {
                $('#q4_vatable_sales_principal').val(data.total);
                $('#q4_vatable_sales_accessory').val(data.total2);
                $('#q4_government_sales_principal').val(data.total3);
                $('#q4_government_sales_accessory').val(data.total4);
                $('#q4_total_sales_principal').val(data.total5);
                $('#q4_total_sales_accessory').val(data.total6);
                $('#q4_value_added_tax_due_accessory').val(data.total8);
                $('#q4_value_added_tax_payable_accessory').val(data.total9);
                $('#q4_total_sales_revenue_accessory').val(data.total5);
                $('#q4_gross_sales_accessory').val(data.total10);
                $('#q4_net_taxable_income_accessory').val(data.total11);
                $('#q4_taxable_income_to_date').val(data.total12);
                $('#q4_tax_rate_accessory').val(data.total13);
                // $('#q4_mcit_percent_accessory').val(data.total14);
                $('#q4_mcit_percent_accessory').val(data.total19);
                $("#q4_income_tax_due_accessory").val(data.total15);
                $('#q4_vat_withheld_government_accessory').val(data.total16);
                $('#q4_it_withheld_cwt_accessory').val(data.total17);
                $('#q4_income_tax_still_payable_accessory').val(data.total17);
                $('#q4_other_expenses_value_acessory_2').val(data.total18);
                // $('#sample_fetch_data').val(data.total19);
            }
          });

    })



$(document).on('keyup', 
  '#q4_government_sales_principal, \
   #q4_zero_rated_sales_principal, \
   #q4_exempt_sales_principal, \
   #q4_total_vat_purchase_accessory, \
   #q4_less_cost_of_sales_accessory, \
   #q4_net_taxable_income_previous_quarter_accessory, \
   #q4_tax_rate_principal, \
   #q4_mcit_percent_principal, \ #q4_vat_payment_previous_principal, \ #q4_it_payment_previous_principal ,\ #q4_other_expenses_value_principal_2', 
   function() 
   {
     $('#q4_compute_value_add_tax_info').click();
   }

);



$(document).on('click','#q4_save_data',function()
{

var q4_government_sales_principal = $('#q4_government_sales_principal').val();
var q4_zero_rated_sales_principal = $('#q4_zero_rated_sales_principal').val();
var q4_exempt_sales_principal = $('#q4_exempt_sales_principal').val();

var q4_other_expense_principal = $('#q4_other_expense_principal').val();
var q4_vat_payment_previous_principal = $('#q4_vat_payment_previous_principal').val();
var q4_tax_actual_paid_accessory = $('#q4_tax_actual_paid_accessory').val();


var q4_less_cost_of_sales_accessory = $('#q4_less_cost_of_sales_accessory').val();
var q4_net_taxable_income_previous_quarter_accessory = $('#q4_net_taxable_income_previous_quarter_accessory').val();
var q4_tax_rate_principal = $('#q4_tax_rate_principal').val();


var q4_mcit_percent_principal = $('#q4_mcit_percent_principal').val();
var q4_it_payment_previous_principal = $('#q4_it_payment_previous_principal').val();
var q4_income_tax_actually_paid_accessory = $('#q4_income_tax_actually_paid_accessory').val();

var q4_other_expenses_value_principal_2 = $('#q4_other_expenses_value_principal_2').val();






var form_data = 
{
    q4_government_sales_principal: q4_government_sales_principal,
    q4_zero_rated_sales_principal: q4_zero_rated_sales_principal,
    q4_exempt_sales_principal: q4_exempt_sales_principal,

    q4_other_expense_principal: q4_other_expense_principal,
    q4_vat_payment_previous_principal: q4_vat_payment_previous_principal,
    q4_tax_actual_paid_accessory: q4_tax_actual_paid_accessory,

    q4_less_cost_of_sales_accessory: q4_less_cost_of_sales_accessory,
    q4_net_taxable_income_previous_quarter_accessory: q4_net_taxable_income_previous_quarter_accessory,
    q4_tax_rate_principal: q4_tax_rate_principal,

    q4_mcit_percent_principal: q4_mcit_percent_principal,
    q4_it_payment_previous_principal: q4_it_payment_previous_principal,
    q4_income_tax_actually_paid_accessory: q4_income_tax_actually_paid_accessory,

    quarter_num: quarter_num,
    branch_id: branch_id,
    year_now: year_now,

    q4_other_expenses_value_principal_2: q4_other_expenses_value_principal_2
};



    $.ajax({
      // url:'tax_compute_data5.php',
      url:'tax_compute_data8.php',
      method:"POST",
      data:form_data,
      success:function(data)
      {
          Swal.fire({icon: 'success',title: 'Tax return data updated!' });
      }
    });


})



  })
</script>






























































