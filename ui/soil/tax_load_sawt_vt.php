<?php 
include_once 'connectdb.php';


$monthnow = $_GET['monthnow'];
$yearnow = $_GET['yearnow'];
$branchid = $_GET['branchid'];

$january_num = $monthnow;


$monthword = date("F", strtotime("$yearnow-$january_num-01"));

$january_num_of_days = date("t", strtotime("$yearnow-12-01"));
$jandaysfrom = $yearnow.'-'.$january_num.'-01';
$jandaysto = $yearnow.'-12-'.$january_num_of_days;


$select1 = $pdo->prepare("SELECT SUM(gross_amount) as gross_amount_total FROM tb_tax_vat_purchase where branch_id = '$branchid' and date between '$jandaysfrom' and '$jandaysto' ");
$select1->execute();
$row1 = $select1->fetch(PDO::FETCH_OBJ);

$gross_amount_total = $row1->gross_amount_total;
$net_amount_total = $gross_amount_total / 1.12;
$vat_amount_total = $gross_amount_total - $net_amount_total;

function fetch_business_data($pdo,$id)
{
  $select = $pdo->prepare("SELECT * FROM tb_tax_business where id = '$id' ");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);

  $array['tin'] = $row->tin;
  $array['name'] = $row->name;

  return $array;
}

$total_withheld_data = fetch_total_withheld($pdo,$branchid,$jandaysfrom,$jandaysto);

function fetch_total_withheld($pdo,$branchid,$jandaysfrom,$jandaysto)
{
  $select1 = $pdo->prepare("SELECT SUM(withholding_total_vwt) as total_vwt_withheld FROM tb_tax_sales where branch_id = '$branchid' and date between '$jandaysfrom' and '$jandaysto' and vwt_percent != 0 ORDER by date ASC ");
  $select1->execute();
  $row1 = $select1->fetch(PDO::FETCH_OBJ);

  // $select2 = $pdo->prepare("SELECT SUM(withholding_total_vwt) as total_vwt_withheld FROM tb_tax_vat_purchase where branch_id = '$branchid' and date between '$jandaysfrom' and '$jandaysto' ORDER by date ASC ");
  // $select2->execute();
  // $row2 = $select2->fetch(PDO::FETCH_OBJ);

  // $select3 = $pdo->prepare("SELECT SUM(withholding_total_vwt) as total_vwt_withheld FROM tb_tax_non_vat_purchase where branch_id = '$branchid' and date between '$jandaysfrom' and '$jandaysto' ORDER by date ASC ");
  // $select3->execute();
  // $row3 = $select3->fetch(PDO::FETCH_OBJ);


  // $array['tax_purchase'] = $row1->total_vwt_withheld;
  // $array['tax_vat_purchase'] = $row2->total_vwt_withheld;
  $array['withhold_total'] = $row1->total_vwt_withheld;

  return $array;

}


?>






<table  border="1" width="100%">
    <tr align="center">
      <th colspan="9" style="background-color:rgba(12,25,60,255);">
        <font class="text-white">WITHHOLD TOTAL&nbsp;:&emsp;<?= number_format($total_withheld_data['withhold_total'],2) ?></font>
      </th>
    </tr>
    
    <tr align="center">
      <td style="font-weight:bold;">SEQ #</td>
      <td style="font-weight:bold;">DATE</td>
      <td style="font-weight:bold;">TIN</td>
      <td style="font-weight:bold;">CUSTOMER</td>
      <td style="font-weight:bold;">ATC</td>
      <td style="font-weight:bold;">PAYMENT</td>
      <td style="font-weight:bold;">TAX BASE</td>
      <td style="font-weight:bold;">TAX RATE</td>
      <td style="font-weight:bold;">TAX WITHHELD</td>
    </tr>


    <?php

      $grossamountff = 0;
      $total_net_amount = 0;
      $total_withhold = 0;

      $seq_num = 1;

      $janselect = $pdo->prepare("SELECT * FROM tb_tax_sales where branch_id = '$branchid' and date between '$jandaysfrom' and '$jandaysto' ORDER by date ASC ");
      $janselect->execute();
      while($rowjanselect = $janselect->fetch(PDO::FETCH_OBJ))
      {
        


        if ($rowjanselect->vwt_percent != 0) 
        {
          
          $total_withhold += $rowjanselect->withholding_total_vwt;
          $business_data = fetch_business_data($pdo,$rowjanselect->business_id);
          $total_net_amount += $rowjanselect->net_amount;
    ?>
    
    <tr align="center">
      <td><font size="2"><?= $seq_num ?></font></td>
      <td><font size="2"><?= $rowjanselect->date ?></font></td>
      <!-- <td><font size="2"><?= $business_data['tin'] ?></font></td> -->
      <td><font size="2"><?= $rowjanselect->tin ?></font></td>
      <!-- <td><font size="2"><?= strtoupper($business_data['name']) ?></font></td> -->
      <td><font size="2"><?= strtoupper($rowjanselect->description) ?></font></td>
      <td><font size="2">WC158</font></td>
      <td><font size="2">Suppliers</font></td>
      <td><font size="2"><?= number_format($rowjanselect->net_amount,2) ?></font></td>
      <td><font size="2"><?= $rowjanselect->vwt_percent.'%' ?></font></td>
      <td><font size="2"><?= number_format($rowjanselect->withholding_total_vwt,2) ?></font></td>
    </tr>

    <?php 

      $seq_num++;

      }

      }
    ?>

    <tr align="center">
      <td colspan="6"></td>
      <td class="text-success"><?= number_format($total_net_amount,2) ?></td>
      <td class="text-black"></td>
      <td class="text-warning"><?= number_format($total_withhold,2) ?></td>
    </tr>

</table>

























































































