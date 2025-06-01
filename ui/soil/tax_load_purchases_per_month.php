<?php
include_once 'connectdb.php';
include_once 'function.php';

$yearnow = $_GET['yearnow'];
$branchid = $_GET['branchid'];


function fetch_month_data($pdo,$yearnow,$monthnum,$branchid)
{
  $days_in_a_month = date("t", strtotime("$yearnow-$monthnum-01"));
  $date_from = $yearnow.'-'.$monthnum.'-01';
  $date_to = $yearnow.'-'.$monthnum.'-'.$days_in_a_month;

  $select = $pdo->prepare("SELECT SUM(gross_amount) as total_gross_amount, SUM(net_amount) as total_net_amount, SUM(vat) as total_vat_amount FROM tb_tax_purchase where date between '$date_from' and '$date_to' and branch_id = '$branchid' ");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);

  // return $row->total_gross_amount;

  $array['gross'] = $row->total_gross_amount;
  $array['net'] = $row->total_net_amount;
  $array['vat'] = $row->total_vat_amount;

  return $array;

  
}

?>

<table  border="1" width="100%">
      <tr align="center">
        <!-- <th colspan="6" style="background-color:rgba(12,25,60,255);"> -->
          <th colspan="6" style="background-color:rgb(75,28,20);">
          <font class="text-white">PURCHASE DECLARATION <?= $yearnow ?></font>
        </th>
      </tr>
      
 
      <tr align="center">
        <td style="font-weight:bold;">PERIOD</td>
        <td style="font-weight:bold;">NET AMOUNT</td>
        <td style="font-weight:bold;">VAT</td>
        <td style="font-weight:bold;">GROSS AMOUNT</td>
        <td style="font-weight:bold;">DECLARED</td>
      </tr>


      <?php

      $gross_amountf = 0;
      $net_amountf = 0;
      $vatf = 0;

        for ($monthnum = 1; $monthnum <= 12 ; $monthnum++) 
        { 

            $monthnow_word = date("F", strtotime("$yearnow-$monthnum-01"));

            $total_dataf = fetch_month_data($pdo,$yearnow,$monthnum,$branchid);
            // $net_amount = $gross_amount / 1.12;
            // $vat = $gross_amount - $net_amount;

            $gross_amountf += $total_dataf['gross'];
            $net_amountf += $total_dataf['net'];
            $vatf += $total_dataf['vat'];
      ?>

      <tr>
        <td><?= $monthnow_word ?></td>
        <td align="center"><?= number_format($total_dataf['net'],2) ?></td>
        <td align="center"><?= number_format($total_dataf['vat'],2) ?></td>
        <td align="center"><?= number_format($total_dataf['gross'],2) ?></td>
        <td align="center"><?= number_format($total_dataf['net'],2) ?></td>
      </tr>


      <?php
        }
      ?>

      <!-- <tr align="center">
        <td colspan="2" style="font-weight:bold;" >TOTAL</td>
        <td style="font-weight:bold;" class="text-primary"><?= number_format($gross_amountf,2) ?></td>
      </tr> -->
<!-- 
      <tr align="center">
        <td style="font-weight:bold; " >TOTAL</td>
        <td style="font-weight:bold; " class="text-primary"><?= number_format($net_amountf,2) ?></td>
        <td style="font-weight:bold; " class="text-danger"><?= number_format($vatf,2) ?></td>
        <td style="font-weight:bold; " class="text-success"><?= number_format($gross_amountf,2) ?></td>
        <td style="font-weight:bold; " class="text-primary"><?= number_format($net_amountf,2) ?></td>
      </tr> -->

       <tr align="center">
        <td style="font-weight:bold; " >TOTAL</td>
        <td  style="color:rgb(55, 142, 55, 1); font-weight: bold;"><?= number_format($net_amountf,2) ?></td>
        <td  style="color:rgb(142, 8, 11, 1);  font-weight: bold;"><?= number_format($vatf,2) ?></td>
        <td  style="color:rgb(6, 61, 119, 1); font-weight: bold;"><?= number_format($gross_amountf,2) ?></td>
        <td  style="color:rgb(55, 142, 55, 1); font-weight: bold;"><?= number_format($net_amountf,2) ?></td>
      </tr>

    </table>










