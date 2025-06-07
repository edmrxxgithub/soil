<?php 
include_once 'connectdb.php';


$monthnow = $_GET['monthnow'];
$yearnow = $_GET['yearnow'];
$branchid = $_GET['branchid'];

$january_num = $monthnow;

$january_num_of_days = date("t", strtotime("$yearnow-12-01"));
$jandaysfrom = $yearnow.'-'.$january_num.'-01';
$jandaysto = $yearnow.'-12-'.$january_num_of_days;

$select1 = $pdo->prepare("SELECT SUM(gross_amount) as gross_amount_total FROM tb_tax_purchase where branch_id = '$branchid' and date between '$jandaysfrom' and '$jandaysto' ");
$select1->execute();
$row1 = $select1->fetch(PDO::FETCH_OBJ);


$gross_amount_total = $row1->gross_amount_total;
// $net_amount_total = $gross_amount_total / 1.12;
$net_amount_total = $gross_amount_total / 1.12;
$vat_amount_total = $gross_amount_total - $net_amount_total;

$monthword = date("F", strtotime("$yearnow-$january_num-01"));

?>

<div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">

        <div class="row">

          <div class="col-lg-4 col-sm-12">
            <div class="small-box" style="background-color:rgba(12,25,60,255);">
              <div class="inner  text-white">
                <h3><?= number_format($gross_amount_total,2) ?></h3>
                <p>GROSS AMOUNT</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-sm-12">
            <div class="small-box" style="background-color:rgb(142, 8, 11, 1);">
              <div class="inner  text-white">
                <h3><?= number_format($vat_amount_total,2) ?></h3>
                <p>INPUT TAX</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>


          <div class="col-lg-4 col-sm-12">
            <div class="small-box" style="background-color:rgb(55, 142, 55, 1);">
              <div class="inner  text-white">
                <h3><?= number_format($net_amount_total,2) ?></h3>
                <p>NET AMOUNT</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>

        </div>

        </div>
      </div>
</div>


<table  border="1" width="100%">
            <tr align="center">
              <th colspan="9" style="background-color:rgba(12,25,60,255);">
                <font class="text-white">PURCHASE DECLARATION <?= $yearnow ?></font>
              </th>
            </tr>
            
            <tr align="center">
              <td style="font-weight:bold;">DATE</td>

              <td style="font-weight:bold;">TAX IDENTIFICATION #</td>
              <td style="font-weight:bold;">DESCRIPTION</td>
              <td style="font-weight:bold;">INVOICE NO.</td>

              <td style="font-weight:bold;">NET AMOUNT</td>
              <td style="font-weight:bold;">12% VAT</td>
              <td style="font-weight:bold;">GROSS AMOUNT</td>
            </tr>


            <?php

              $grossamountff = 0;
              $netamountff = 0;
              $vatff = 0;

              // $january_num = '02';
              // $monthnow_word = date("F", strtotime("$yearnow-$monthnum-01"));
              // $january_select = $pdo->prepare("SELECT * FROM ")
              // $january_num_of_days = date("t", strtotime("$yearnow-12-01"));

              // $jandaysfrom = $yearnow.'-'.$january_num.'-01';
              // $jandaysto = $yearnow.'-12-'.$january_num_of_days;

              // echo $jandaysfrom.' '.$jandaysto;

              $janselect = $pdo->prepare("SELECT * FROM tb_tax_purchase where branch_id = '$branchid' and date between '$jandaysfrom' and '$jandaysto' ORDER by date ASC ");
              $janselect->execute();
              while($rowjanselect = $janselect->fetch(PDO::FETCH_OBJ))
              {

                $net_amount = $rowjanselect->gross_amount / 1.12;
                $vat = $rowjanselect->gross_amount - $net_amount;

                $grossamountff += $rowjanselect->gross_amount;
                $netamountff += $net_amount;
                $vatff += $vat;

            ?>
            
            <tr align="center">
              <td><?= $rowjanselect->date ?></td>

              <td><?= $rowjanselect->tin ?></td>
              <td><?= $rowjanselect->description ?></td>
              <td><?= $rowjanselect->invoice_no ?></td>

              <td><?= number_format($net_amount,2) ?></td>
              <td><?= number_format($vat,2) ?></td>
              <td><?= number_format($rowjanselect->gross_amount,2) ?></td>
            </tr>

            <?php    
              }
            ?>

<!--             <tr align="center">
              <td colspan="4"></td>
              <td class="text-primary"><?= number_format($netamountff,2) ?></td>
              <td class="text-danger"><?= number_format($vatff,2) ?></td>
              <td class="text-success"><?= number_format($grossamountff,2) ?></td>
            </tr> -->

            <tr align="center">
              <td colspan="4"></td>
              <td style="color:rgb(55, 142, 55, 1);" ><?= number_format($netamountff,2) ?></td>
              <td style="color:rgb(142, 8, 11, 1);" ><?= number_format($vatff,2) ?></td>
              <td style="color:rgb(6, 61, 119, 1);" ><?= number_format($grossamountff,2) ?></td>
            </tr>

          </table>




<!-- <tr align="center">
              <td colspan="6"></td>
              <td style="color:rgb(55, 142, 55, 1);" ><?= number_format($netamountff,2) ?></td>
              <td style="color:rgb(142, 8, 11, 1);" ><?= number_format($vatff,2) ?></td>
              <td style="color:rgb(6, 61, 119, 1);" ><?= number_format($grossamountff,2) ?></td>
            </tr> -->
