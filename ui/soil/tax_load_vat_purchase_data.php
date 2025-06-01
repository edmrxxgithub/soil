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


$select1 = $pdo->prepare("SELECT SUM(gross_amount) as gross_amount_total ,SUM(net_amount) as net_amount_total FROM tb_tax_vat_purchase where branch_id = '$branchid' and date between '$jandaysfrom' and '$jandaysto' ");
$select1->execute();
$row1 = $select1->fetch(PDO::FETCH_OBJ);

// $net_amount_total = $gross_amount_total / 1.12;
// $net_amount_total = $gross_amount_total ;

$gross_amount_total = $row1->gross_amount_total;
$net_amount_total = $row1->net_amount_total;
$vat_amount_total = $gross_amount_total - $net_amount_total;

function fetch_supplier_data($pdo,$id)
{
  $select = $pdo->prepare("SELECT * FROM tb_tax_supplier where id = '$id' ");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);

  $array['tin'] = $row->tin;
  $array['name'] = $row->name;

  return $array;
}


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
              <th colspan="9" style="background-color:rgb(237,233,207,255);">
                <font class="text-black">VAT EXPENSE INVOICES <?= $yearnow ?></font>
              </th>
            </tr>
            
            <tr align="center">
              <td style="font-weight:bold;">DATE</td>
              <td style="font-weight:bold;">TIN</td>
              <td style="font-weight:bold;">EXPENDITURE CLASSIFICATION</td>
              <td style="font-weight:bold;">EXPENSE TYPE</td>
              <td style="font-weight:bold;">REFERENCE NO.</td>
              <td style="font-weight:bold;">GROSS AMOUNT</td>
              <td style="font-weight:bold;">INPUT TAX</td>
              <td style="font-weight:bold;">NET AMOUNT</td>
              <td style="font-weight:bold;">SUPPLIER</td>
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

              $janselect = $pdo->prepare("SELECT * FROM tb_tax_vat_purchase where branch_id = '$branchid' and date between '$jandaysfrom' and '$jandaysto' ORDER by date ASC ");
              $janselect->execute();
              while($rowjanselect = $janselect->fetch(PDO::FETCH_OBJ))
              {

                // $net_amount = $rowjanselect->gross_amount / 1.12;
                $net_amount = $rowjanselect->net_amount;
                $vat = $rowjanselect->vat;
                $supplierdata = fetch_supplier_data($pdo,$rowjanselect->supplier_id);
                
                $grossamountff += $rowjanselect->gross_amount;  
                $netamountff += $net_amount;
                $vatff += $vat;

            ?>
            
            <tr align="center">
              <td><font size="2"><?= $rowjanselect->date ?></font></td>
              <td><font size="2"><?= $supplierdata['tin'] ?></font></td>
              <td><font size="2"><?= $rowjanselect->exp_class ?></font></td>
              <td><font size="2"><?= $rowjanselect->exp_type ?></font></td>
              <td><font size="2"><?= $rowjanselect->reference_num ?></font></td>
              <td><font size="2"><?= number_format($rowjanselect->gross_amount,2) ?></font></td>
              <td><font size="2"><?= number_format($vat,2) ?></font></td>
              <td><font size="2"><?= number_format($net_amount,2) ?></font></td>
              <td><font size="2"><?= $supplierdata['name'] ?></font></td>
            </tr>

            <?php    
              }
            ?>

            <tr align="center">
              <td colspan="5"></td>
              <td style="color:rgb(6, 61, 119, 1)"><?= number_format($grossamountff,2) ?></td>
              <td style="color:rgb(142, 8, 11, 1)"><?= number_format($vatff,2) ?></td>
              <td style="color:rgb(55, 142, 55, 1)"><?= number_format($netamountff,2) ?></td>
            </tr>

          </table>



      <!-- <tr align="center">
        <td style="font-weight:bold; " >TOTAL</td>
        <td  style="color:rgb(55, 142, 55, 1); font-weight: bold;"><?= number_format($net_amountf,2) ?></td>
        <td  style="color:rgb(142, 8, 11, 1);  font-weight: bold;"><?= number_format($vatf,2) ?></td>
        <td  style="color:rgb(6, 61, 119, 1); font-weight: bold;"><?= number_format($gross_amountf,2) ?></td>
        <td  style="color:rgb(55, 142, 55, 1); font-weight: bold;"><?= number_format($net_amountf,2) ?></td>
      </tr> -->