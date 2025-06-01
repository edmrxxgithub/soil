<?php
include_once 'connectdb.php';
include_once 'function.php';

$yearnow = $_GET['yearnow'];
$branchid = $_GET['branchid'];

function fetch_vat_purchase($pdo,$monthfrom,$monthto,$yearnow,$branchid)
{
    $number_of_days_in_a_month = date("t", strtotime("$yearnow-$monthto-01"));

    $datefrom = $yearnow.'-'.$monthfrom.'-01';

    $dateto = $yearnow.'-'.$monthto.'-'.$number_of_days_in_a_month;

    $select = $pdo->prepare("SELECT SUM(gross_amount) as gross_amount FROM tb_tax_purchase WHERE branch_id = '$branchid' and date between '$datefrom' and '$dateto' ");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);

    $netamount = $row->gross_amount / 1.12;

    return $netamount;

    // return $datefrom.' '.$dateto;
    
}


function fetch_by_quarter_total($pdo,$monthfrom,$monthto,$yearnow,$branchid)
{
    $number_of_days_in_a_month = date("t", strtotime("$yearnow-$monthto-01"));

    $datefrom = $yearnow.'-'.$monthfrom.'-01';

    $dateto = $yearnow.'-'.$monthto.'-'.$number_of_days_in_a_month;

    $select = $pdo->prepare("SELECT SUM(gross_amount) as gross_amount FROM tb_tax_sales WHERE branch_id = '$branchid' and date between '$datefrom' and '$dateto' ");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);

    $netamount = $row->gross_amount / 1.12;

    return $netamount;
    
}


function fetch_vat_expense($pdo,$monthfrom,$monthto,$yearnow,$branchid)
{

  $number_of_days_in_a_month = date("t", strtotime("$yearnow-$monthto-01"));
  $datefrom = $yearnow.'-'.$monthfrom.'-01';
  $dateto = $yearnow.'-'.$monthto.'-'.$number_of_days_in_a_month;

  $select1 = $pdo->prepare("SELECT SUM(gross_amount) as gross_amount_total FROM tb_tax_vat_purchase where branch_id = '$branchid' and date between '$datefrom' and '$dateto' ");
$select1->execute();
$row1 = $select1->fetch(PDO::FETCH_OBJ);

$netamount = $row1->gross_amount_total / 1.12;

return $netamount;

}

$purchase_net_total = fetch_vat_purchase($pdo,1,12,$yearnow,$branchid);
$vat_expense_total = fetch_vat_expense($pdo,1,12,$yearnow,$branchid);

$vatable_sales_total = fetch_by_quarter_total($pdo,1,12,$yearnow,$branchid);

$domestic_purchase_total = $purchase_net_total + $vat_expense_total;


$vatable_sales_total_percent = $vatable_sales_total * 0.12;
$domestic_purchase_total_percent = $domestic_purchase_total * 0.12;

$risktotal = $vatable_sales_total_percent - $domestic_purchase_total_percent;



$benchmark = $risktotal / $vatable_sales_total;

$benchmark_percent = $benchmark * 100;

?>

<table  border="1" width="100%">
      <tr align="center">
        <th colspan="3" style="background-color:rgba(12,25,60,255);"">
          <font class="text-white">COMPUTATION <?= $yearnow ?></font>
        </th>
      </tr>
      
      <tr align="center">
        <td style="font-weight:bold;">DESCRIPTION</td>
        <td style="font-weight:bold;">AMOUNT</td>
        <td style="font-weight:bold;">12%</td>
      </tr>

        <tr align="center">
          <td>Vatables Sales</td>
          <td ><?= number_format($vatable_sales_total,2) ?></td>
          <td ><?= number_format($vatable_sales_total_percent,2) ?></td>
        </tr>

      <tr align="center">
        <td>Domestic Purchase</td>
        <td><?= number_format($domestic_purchase_total,2) ?></td>
        <td><?= number_format($domestic_purchase_total_percent,2) ?></td>
      </tr>

      <tr align="center">
        <td>Calculated Risk</td>
        <td align="center" id="calculated_risk"></td>
        <td align="center" id="simulation_total_output"></td>
      </tr>


<input type="hidden" id="simulation_total_hidden" value="<?= number_format($risktotal, 2, '.', ''); ?>">
<input type="hidden" id="vatable_sales_total_hidden" value="<?= number_format($vatable_sales_total, 2, '.', ''); ?>">

  
      <tr align="center">
        <td style="font-weight:bold;">TOTAL</td>
        <td></td>
        <td style="font-weight: bold;" class="text-black">
          <input type="text" id="simulation_total" value="<?= number_format($risktotal, 2, '.', ''); ?>">
        </td>
      </tr>
      <!-- <tr align="center">
        <td style="font-weight:bold;">TOTAL HIDDEN</td>
        <td></td>
        <td style="font-weight: bold;" class="text-black"></td>
      </tr> -->
     <!--  <tr align="center">
        <td style="font-weight:bold;">SIMULATION TOTAL</td>
        <td></td>
        <td style="font-weight: bold;" class="text-black"></td>
      </tr> -->
</table>


<br><br><br><br>

<table border="0" width="100%">
  <thead>
    <td align="center" style="font-weight:bold;"><font size="5">Benchmark</font></td>
    <td align="left" style="font-size: 30px;" id="benchmark_percent"><?= number_format($benchmark_percent,2).'%' ?></td>
  </thead>
</table>






<script type="text/javascript">
  $(document).ready(function()
  {


    // alert('God is good, life is good!');


    $(document).on('keyup','#simulation_total',function()
    {

      var simulation_total = $('#simulation_total').val();
      var simulation_total_hidden = $('#simulation_total_hidden').val();
      var vatable_sales_total_hidden = $('#vatable_sales_total_hidden').val();

      $.ajax({
            url:'tax_compute_benchmark.php',
            method:"POST",
            dataType:'json',
            data:'simulation_total='+simulation_total+'&simulation_total_hidden='+simulation_total_hidden+'&vatable_sales_total_hidden='+vatable_sales_total_hidden,
            success:function(data)
            {
                $('#simulation_total_output').html(data.total);
                $('#calculated_risk').html(data.calculated_risk);
                $('#benchmark_percent').html(data.benchmark_percent);
            }
          });

      

      

    })

  })


</script>














