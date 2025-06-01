<?php 
include_once 'connectdb.php';
include_once 'function.php';


$monthnow = $_GET['monthnow'];
$yearnow = $_GET['yearnow'];
$branchid = $_GET['branchid'];

$january_num = $monthnow;


$monthword = date("F", strtotime("$yearnow-$january_num-01"));

$selectbranch = $pdo->prepare("SELECT * FROM tb_tax_branch WHERE id = '$branchid' ");
$selectbranch->execute();
$rowbranchdata = $selectbranch->fetch(PDO::FETCH_OBJ);


?>



<table  border="1" width="100%">
            <tr align="center">
              <th colspan="9" style="background-color:rgba(12,25,60,255);">
                <font class="text-white"><?= strtoupper($monthword).' '.$yearnow ?></font>
              </th>
            </tr>
            
            <tr align="center">
              <td style="font-weight:bold;">DATE</td>
              <td style="font-weight:bold;">TIN</td>
              <td style="font-weight:bold;">ORDER STATUS</td>

              <td style="font-weight:bold;">PAYMENT METHOD</td>
              <td style="font-weight:bold;">DESCRIPTION</td>
              <td style="font-weight:bold;">INVOICE NO.</td>

              <td style="font-weight:bold;">NET AMOUNT</td>
              <td style="font-weight:bold;">VAT %</td>
              <td style="font-weight:bold;">GROSS AMOUNT</td>
            </tr>


            <?php

              $grossamountff = 0;
              $netamountff = 0;
              $vatff = 0;

              // $january_num = '02';
              // $monthnow_word = date("F", strtotime("$yearnow-$monthnum-01"));
              // $january_select = $pdo->prepare("SELECT * FROM ")
              $january_num_of_days = date("t", strtotime("$yearnow-$january_num-01"));

              $jandaysfrom = $yearnow.'-'.$january_num.'-01';
              $jandaysto = $yearnow.'-'.$january_num.'-'.$january_num_of_days;

              $janselect = $pdo->prepare("SELECT * FROM tb_tax_sales where branch_id = '$branchid' and date between '$jandaysfrom' and '$jandaysto' ORDER by date ASC ");
              $janselect->execute();
              while($rowjanselect = $janselect->fetch(PDO::FETCH_OBJ))
              {

                $gross_amount = $rowjanselect->gross_amount;
                $net_of_vat = $rowjanselect->net_amount;
                $vat_total = $rowjanselect->vat;
                // $vat_percent = $rowjanselect->vat_percent;
                // $cwt_percent = $rowjanselect->cwt_percent;

                // $vat_percent_new = $vat_percent / 100;
                // $cwt_percent_new = $cwt_percent / 100;

                // $vat_total = $vat_percent_new * $gross_amount;
                // $net_of_vat = $gross_amount - $vat_total;
                // $withholding_total = $cwt_percent_new * $net_of_vat;

                
                $grossamountff += $gross_amount;
                $netamountff += $net_of_vat;
                $vatff += $vat_total;

            ?>
            
            <tr align="center">
              <td><?= $rowjanselect->date ?></td>
              <!-- <td><?= $rowjanselect->tin ?></td> -->
              <td><?= $rowbranchdata->tin ?></td>
              <td><?= $rowjanselect->order_status ?></td>

              <td><?= $rowjanselect->payment_method ?></td>
              <td><?= $rowjanselect->description ?></td>
              <td><?= $rowjanselect->invoice_no ?></td>

              <td><?= number_format($net_of_vat,2) ?></td>
              <td><?= number_format($vat_total,2) ?></td>
              <td><?= number_format($rowjanselect->gross_amount,2) ?></td>
            </tr>

            <?php    
              }
            ?>

            <tr align="center">
              <td colspan="6"></td>
              <td style="color:rgb(55, 142, 55, 1);" ><?= number_format($netamountff,2) ?></td>
              <td style="color:rgb(142, 8, 11, 1);" ><?= number_format($vatff,2) ?></td>
              <td style="color:rgb(6, 61, 119, 1);" ><?= number_format($grossamountff,2) ?></td>
            </tr>

          </table>





      <!-- <tr align="center">
        <td  style="font-weight:bold; " >TOTAL</td>
        <td  style="color:rgb(55, 142, 55, 1); font-weight: bold;"><?= number_format($net_amountf,2) ?></td>
        <td  style="color:rgb(142, 8, 11, 1);  font-weight: bold;"><?= number_format($vatf,2) ?></td>
        <td  style="color:rgb(6, 61, 119, 1); font-weight: bold;"><?= number_format($gross_amountf,2) ?></td>
        <td  style="color:rgb(55, 142, 55, 1); font-weight: bold;"><?= number_format($net_amountf,2) ?></td>
      </tr> -->




