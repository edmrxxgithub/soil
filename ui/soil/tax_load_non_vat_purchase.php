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


$select1 = $pdo->prepare("SELECT SUM(gross_amount) as gross_amount_total FROM tb_tax_non_vat_purchase where branch_id = '$branchid' and date between '$jandaysfrom' and '$jandaysto' ");
$select1->execute();
$row1 = $select1->fetch(PDO::FETCH_OBJ);

$gross_amount_total = $row1->gross_amount_total;


function fetch_business_data($pdo,$id)
{
  $select = $pdo->prepare("SELECT * FROM tb_tax_business where id = '$id' ");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);

  $array['tin'] = $row->tin;
  $array['name'] = $row->name;

  return $array;
}


function fetch_supplier_name($pdo,$id)
{
  $select = $pdo->prepare("SELECT * FROM tb_tax_supplier where id = '$id' ");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);

  $array['name'] = $row->name;
  $array['address'] = $row->address;

  return $array;
}


?>

<div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">

        <div class="row">

          <div class="col-lg-12 col-sm-12">
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



        </div>

        </div>
      </div>
</div>

<table  border="1" width="100%">
            <tr align="center">
              <th colspan="8" style="background-color:rgba(12,25,60,255);">
                <font class="text-white">NON VAT PURCHASE INVOICES <?= $yearnow ?></font>
              </th>
            </tr>
            
            <tr align="center">
              <td style="font-weight:bold;"><font size="2">DATE</font></td>
              <td style="font-weight:bold;"><font size="2">TIN</font></td>
              <td style="font-weight:bold;"><font size="2">CLASSIFICATION</font></td>
              <td style="font-weight:bold;"><font size="2">TYPE</font></td>
              <td style="font-weight:bold;"><font size="2">REF NO.</font></td>
              <td style="font-weight:bold;"><font size="2">GROSS</font></td>
              <td style="font-weight:bold;"><font size="2">SUPPLIER</font></td>
              <td style="font-weight:bold;"><font size="2">ADDRESS</font></td>
            </tr>


            <?php

              $grossamountff = 0;
              $netamountff = 0;
              $vatff = 0;

              $janselect = $pdo->prepare("SELECT * FROM tb_tax_non_vat_purchase where branch_id = '$branchid' and date between '$jandaysfrom' and '$jandaysto' ORDER by date ASC ");
              $janselect->execute();
              while($rowjanselect = $janselect->fetch(PDO::FETCH_OBJ))
              {
                // $net_amount = $rowjanselect->gross_amount / 1.12;
                // $vat = $rowjanselect->gross_amount - $net_amount;
                $business_data = fetch_business_data($pdo,$rowjanselect->business_id);
                $grossamountff += $rowjanselect->gross_amount;  
                $supplier_data = fetch_supplier_name($pdo,$rowjanselect->supplier_id);

            ?>
            
           <tr align="center">
              <td><font size="2"><?= $rowjanselect->date ?></font></td>
              <td><font size="2"><?= $business_data['tin'] ?></font></td>
              <td><font size="2"><?= $rowjanselect->exp_class ?></font></td>
              <td><font size="2"><?= $rowjanselect->exp_type ?></font></td>
              <td><font size="2"><?= $rowjanselect->reference_num ?></font></td>
              <td><font size="2"><?= number_format($rowjanselect->gross_amount,2) ?></font></td>
              <td><font size="2"><?= $supplier_data['name'] ?></font></td>
              <td><font size="2"><?= $supplier_data['address'] ?></font></td>
            </tr> 

            <?php    
              }
            ?>

            <tr align="center">
              <td colspan="5"></td>
              <td style="color:rgb(6, 61, 119, 1)"><?= number_format($grossamountff,2) ?></td>
              <td></td>
            </tr>

          </table>