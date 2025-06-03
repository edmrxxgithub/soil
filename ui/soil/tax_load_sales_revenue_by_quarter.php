<?php
include_once 'connectdb.php';
include_once 'function.php';

$yearnow = $_GET['yearnow'];
$branchid = $_GET['branchid'];

function fetch_by_quarter_total($pdo,$monthfrom,$monthto,$yearnow,$branchid)
{
    $number_of_days_in_a_month = date("t", strtotime("$yearnow-$monthto-01"));
    $datefrom = $yearnow.'-'.$monthfrom.'-01';
    $dateto = $yearnow.'-'.$monthto.'-'.$number_of_days_in_a_month;

    $select = $pdo->prepare("SELECT SUM(net_amount) as gross_amount FROM tb_tax_sales WHERE branch_id = '$branchid' and date between '$datefrom' and '$dateto' ");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);

    // $netamount = $row->gross_amount / 1.12;
    $netamount = $row->gross_amount;

    return number_format($netamount,2);
    
}

?>

<table  border="1" width="100%">
      <tr align="center">
        <th colspan="6" style="background-color:rgba(12,25,60,255);">
          <font class="text-white">SALES REVENUE BY QUARTER <?= $yearnow ?></font>
        </th>
      </tr>
      
      <tr align="center">
        <td style="font-weight:bold;">PERIOD</td>
        <td style="font-weight:bold;">AMOUNT</td>
      </tr>

      <tr align="center">
        <td>Quarter 1</td>
        <td><?php  echo fetch_by_quarter_total($pdo,1,3,$yearnow,$branchid); ?></td>
      </tr>

      <tr align="center">
        <td>Quarter 2</td>
        <td><?php  echo fetch_by_quarter_total($pdo,4,6,$yearnow,$branchid); ?></td>
      </tr>

      <tr align="center">
        <td>Quarter 3</td>
        <td><?php  echo fetch_by_quarter_total($pdo,7,9,$yearnow,$branchid); ?></td>
      </tr>

      <tr align="center">
        <td>Quarter 4</td>
        <td><?php  echo fetch_by_quarter_total($pdo,10,12,$yearnow,$branchid); ?></td>
      </tr>

      <tr align="center">
        <td style="font-weight:bold;">TOTAL</td>
        <td style="color:rgb(6, 61, 119, 1); font-weight: bold;"><?php  echo fetch_by_quarter_total($pdo,1,12,$yearnow,$branchid); ?></td>
      </tr>

</table>





