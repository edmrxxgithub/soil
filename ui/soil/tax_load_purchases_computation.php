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


function fetch_non_vat_expense($pdo,$monthfrom,$monthto,$yearnow,$branchid)
{


$number_of_days_in_a_month = date("t", strtotime("$yearnow-$monthto-01"));
  $datefrom = $yearnow.'-'.$monthfrom.'-01';
  $dateto = $yearnow.'-'.$monthto.'-'.$number_of_days_in_a_month;

$select1 = $pdo->prepare("SELECT SUM(gross_amount) as gross_amount_total FROM tb_tax_non_vat_purchase where branch_id = '$branchid' and date between '$datefrom' and '$dateto' ");
$select1->execute();
$row1 = $select1->fetch(PDO::FETCH_OBJ);

return $row1->gross_amount_total;

}




$purchase_net_total = fetch_vat_purchase($pdo,1,12,$yearnow,$branchid);
$vat_expense_total = fetch_vat_expense($pdo,1,12,$yearnow,$branchid);
$non_vat_expense_total = fetch_non_vat_expense($pdo,1,12,$yearnow,$branchid);

$total = $purchase_net_total + $vat_expense_total + $non_vat_expense_total;

?>

<table  border="1" width="100%">
      <tr align="center">
        <th colspan="6" style="background-color:rgb(75,28,20);">
          <font class="text-white">PURCHASES <?= $yearnow ?></font>
        </th>
      </tr>
      
      <tr align="center">
        <td style="font-weight:bold;">DESCRIPTION</td>
        <td style="font-weight:bold;">AMOUNT</td>
      </tr>

        <tr align="center">
          <td>Purchases</td>
          <td ><?= number_format($purchase_net_total,2) ?></td>
        </tr>

      <tr align="center">
        <td>Vat expenses</td>
        <td><?= number_format($vat_expense_total,2) ?></td>
      </tr>

      <tr align="center">
        <td>NONVat Expenses</td>
        <td><?= number_format($non_vat_expense_total,2) ?></td>
      </tr>

  
      <tr align="center">
        <td style="font-weight:bold;">TOTAL</td>
        <td style="color:rgb(6, 61, 119, 1); font-weight: bold;"><?= number_format($total,2) ?></td>
      </tr>

</table>





