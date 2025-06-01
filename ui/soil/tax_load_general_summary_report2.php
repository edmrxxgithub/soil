<?php 
include_once 'connectdb.php';


$monthnow = $_GET['monthnow'];
$yearnow = $_GET['yearnow'];
$branchid = $_GET['branchid'];
$january_num = $monthnow;


$vatable_sales_overall_total = 0;
$vatable_purchase_overall_total = 0;
$vatable_expense_overall_total = 0;
$non_vatable_expense_overall_total = 0;
$net_income_overall_total = 0;


$vatable_government_sales_overall_total = 0;
$zero_rated_sales_overall_total = 0;
$exempt_sales_overall_total = 0;

$sawt_overall_total = 0;
$qap_overall_total = 0;

$qap_it_overall_total = 0;
$qap_vt_overall_total = 0;

$sawt_it_overall_total = 0;
$sawt_vt_overall_total = 0;

// $monthword = date("F", strtotime("$yearnow-$january_num-01"));
// $january_num_of_days = date("t", strtotime("$yearnow-12-01"));
// $jandaysfrom = $yearnow.'-'.$january_num.'-01';
// $jandaysto = $yearnow.'-12-'.$january_num_of_days;





function fetch_month_data($pdo,$yearnow,$monthnum,$branchid)
{
  $days_in_a_month = date("t", strtotime("$yearnow-$monthnum-01"));
  $date_from = $yearnow.'-'.$monthnum.'-01';
  $date_to = $yearnow.'-'.$monthnum.'-'.$days_in_a_month;

// withholding_total_cwt
// withholding_total_vwt

  $select = $pdo->prepare("SELECT 

        SUM(net_amount) as net_amount_total,
        SUM(withholding_total_cwt) as withholding_total_cwt,
        SUM(withholding_total_vwt) as withholding_total_vwt
        
        FROM 

        tb_tax_sales 

        WHERE 

        date BETWEEN '$date_from' AND 

        '$date_to' AND branch_id = '$branchid' ");

  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);


  $select_vat_sales = $pdo->prepare("SELECT 

        SUM(net_amount) as net_amount_total
        
        FROM 

        tb_tax_sales 

        WHERE 

        date BETWEEN '$date_from' AND 

        '$date_to' AND branch_id = '$branchid' AND vat_percent != 0 AND vwt_percent = 0 ");

  $select_vat_sales->execute();
  $row_vat_sales = $select_vat_sales->fetch(PDO::FETCH_OBJ);


  $select_government_sales = $pdo->prepare("SELECT 

        SUM(net_amount) as net_amount_total
        
        FROM 

        tb_tax_sales 

        WHERE 

        date BETWEEN '$date_from' AND 

        '$date_to' AND branch_id = '$branchid' AND vat_percent != 0  AND vwt_percent != 0 ");

  $select_government_sales->execute();
  $row_government_sales = $select_government_sales->fetch(PDO::FETCH_OBJ);





$select_zero_rated_sales = $pdo->prepare("SELECT 

        SUM(net_amount) as net_amount_total
        
        FROM 

        tb_tax_sales 

        WHERE 

        date BETWEEN '$date_from' AND 

        '$date_to' AND branch_id = '$branchid' AND vat_percent = 0 AND vwt_percent != 0 ");

  $select_zero_rated_sales->execute();
  $row_zero_rated_sales = $select_zero_rated_sales->fetch(PDO::FETCH_OBJ);




$select_exempt_sales = $pdo->prepare("SELECT 

        SUM(net_amount) as net_amount_total
        
        FROM 

        tb_tax_sales 

        WHERE 

        date BETWEEN '$date_from' AND 

        '$date_to' AND branch_id = '$branchid' AND vat_percent = 0  AND vwt_percent = 0 ");

  $select_exempt_sales->execute();
  $row_exempt_sales = $select_exempt_sales->fetch(PDO::FETCH_OBJ);


















  $select1 = $pdo->prepare("SELECT 

    SUM(net_amount) as net_amount_total ,
    SUM(withholding_total_cwt) as withholding_total_cwt,
    SUM(withholding_total_vwt) as withholding_total_vwt 

    FROM tb_tax_purchase where date between '$date_from' and '$date_to' and branch_id = '$branchid' ");

    $select1->execute();
    $row1 = $select1->fetch(PDO::FETCH_OBJ);





  $select2 = $pdo->prepare("SELECT 

    SUM(net_amount) as net_amount_total ,
    SUM(withholding_total_cwt) as withholding_total_cwt,
    SUM(withholding_total_vwt) as withholding_total_vwt 

    FROM tb_tax_vat_purchase where date between '$date_from' and '$date_to' and branch_id = '$branchid' ");

    $select2->execute();
    $row2 = $select2->fetch(PDO::FETCH_OBJ);


  $select3 = $pdo->prepare("SELECT 

    SUM(gross_amount) as total_gross_amount ,
    SUM(withholding_total_cwt) as withholding_total_cwt,
    SUM(withholding_total_vwt) as withholding_total_vwt

    FROM tb_tax_non_vat_purchase where branch_id = '$branchid' and date between '$date_from' and '$date_to' ");

  $select3->execute();
  $row3 = $select3->fetch(PDO::FETCH_OBJ);


  $select4 = $pdo->prepare("SELECT SUM(gross_amount) as total_gross_amount FROM tb_tax_sales where date between '$date_from' and '$date_to' and branch_id = '$branchid' and vat_percent = '0' ");
  $select4->execute();
  $row4 = $select4->fetch(PDO::FETCH_OBJ);


  // $select5 = $pdo->prepare("SELECT SUM(withholding_total) as withholding_total FROM tb_tax_sales where date between '$date_from' and '$date_to' and branch_id = '$branchid' and cwt_percent != '0' ");
  // $select5->execute();
  // $row5 = $select5->fetch(PDO::FETCH_OBJ);
  //  $select7 = $pdo->prepare("SELECT SUM(withholding_total) as withholding_total FROM tb_tax_purchase where date between '$date_from' and '$date_to' and branch_id = '$branchid' and cwt_percent != '0' ");
  // $select7->execute();
  // $row7 = $select7->fetch(PDO::FETCH_OBJ);


  $array['vatable_sales'] =$row_vat_sales->net_amount_total;
  $array['government_sales'] = $row_government_sales->net_amount_total;
  $array['zero_rated_sales'] = $row_zero_rated_sales->net_amount_total;
  $array['exempt_sales'] = $row_exempt_sales->net_amount_total;


  $array['vatable_purchase'] =$row1->net_amount_total;

  $array['vatable_expense'] =$row2->net_amount_total;
  $array['non_vatable_expense'] =$row3->total_gross_amount;

  // $array['exempt_sales'] = $row4->total_gross_amount;

  $array['qap_it'] = $row1->withholding_total_cwt + $row2->withholding_total_cwt + $row3->withholding_total_cwt;
  $array['qap_vt'] = $row1->withholding_total_vwt + $row2->withholding_total_vwt + $row3->withholding_total_vwt;

  $array['sawt_it'] = $row->withholding_total_cwt;
  $array['sawt_vt'] = $row->withholding_total_vwt;



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
                <h4><center>SUMMARY REPORT FROM GENERAL PURPOSE STATEMENT YEAR <?= $yearnow ?></center></h4>
                <p></p>
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

<!-- <b>VS</b> = Vatable sales
<br>
<b>GS</b>= Government sales
<br>
<b>ZS</b>= Zero rated sales
<br>
<b>ES</b>= Exempt sales
<br>
 -->





<table  border="1" width="100%">
            <tr align="center">
              <th colspan="12" style="background-color:rgba(12,25,60,255);">
                <!-- <font class="text-white">NON VAT PURCHASE INVOICES <?= $yearnow ?></font> -->
              </th>
            </tr>
            
            <tr align="center">
              <td style="font-weight:bold;background-color:rgb(249,249,247)"><font size="2">PERIOD</font></td>

              <td style="font-weight:bold;background-color:rgb(249,249,247)"><font size="2">VS</font></td>
              <td style="font-weight:bold;background-color:rgb(249,249,247)"><font size="2">GS</font></td>
              <td style="font-weight:bold;background-color:rgb(249,249,247)"><font size="2">ZS</font></td>
              <td style="font-weight:bold;background-color:rgb(249,249,247)"><font size="2">ES</font></td>

              <td style="font-weight:bold;background-color:rgb(249,249,247)"><font size="2">NET INCOME</font></td>

              <td style="font-weight:bold;background-color:rgb(249,249,247)"><font size="2">QAP-IT</font></td>
              <td style="font-weight:bold;background-color:rgb(249,249,247)"><font size="2">QAP-VT</font></td>

              <td style="font-weight:bold;background-color:rgb(249,249,247)"><font size="2">SAWT-IT</font></td>
              <td style="font-weight:bold;background-color:rgb(249,249,247)"><font size="2">SAWT-VT</font></td>

              <td style="font-weight:bold;background-color:rgb(249,249,247)"><font size="2">VAT EXPENSES</font></td>
              <td style="font-weight:bold;background-color:rgb(249,249,247)"><font size="2">NON-VAT EXPENSES</font></td>
            </tr>


            <?php

            

            for ($monthnum = 1; $monthnum <= 12 ; $monthnum++) 
            { 

                $monthnow_word = date("F", strtotime("$yearnow-$monthnum-01"));
              
                $dataf = fetch_month_data($pdo,$yearnow,$monthnum,$branchid);


                $vatable_sales_overall_total += $dataf['vatable_sales'];
                $vatable_government_sales_overall_total += $dataf['government_sales'];
                $zero_rated_sales_overall_total += $dataf['zero_rated_sales'];
                $exempt_sales_overall_total += $dataf['exempt_sales'];


                $vatable_purchase_overall_total += $dataf['vatable_purchase'];
                $vatable_expense_overall_total += $dataf['vatable_expense'];
                $non_vatable_expense_overall_total += $dataf['non_vatable_expense'];
                $net_income = $dataf['vatable_sales'] - $dataf['vatable_expense'] - $dataf['non_vatable_expense'];
                $net_income_overall_total += $net_income;

                // $exempt_sales_overall_total += $dataf['exempt_sales'];
                // $sawt_overall_total += $dataf['sawt'];
                // $qap_overall_total += $dataf['qap'];

                $sawt_it_overall_total += $dataf['sawt_it'];
                $sawt_vt_overall_total += $dataf['sawt_vt'];

                $qap_it_overall_total += $dataf['qap_it'];
                $qap_vt_overall_total += $dataf['qap_vt'];
                

            ?>
            <tr>
              <td align="left" style="background-color:rgb(249,249,247);"><font size="2" ><?= $monthnow_word ?></font></td>

              <td align="center"><font size="2"><?= number_format($dataf['vatable_sales'],2) ?></font></td>
              <td align="center"><font size="2"><?= number_format($dataf['government_sales'],2) ?></font></td>
              <td align="center"><font size="2"><?= number_format($dataf['zero_rated_sales'],2) ?></font></td>
              <td align="center"><font size="2"><?= number_format($dataf['exempt_sales'],2) ?></font></td>
              <!-- <td align="center"><font size="2"><?= number_format($dataf['vatable_purchase'],2) ?></font></td> -->
              <!-- <td align="center"><font size="2"><?= number_format($net_income,2) ?></font></td> -->
              <td align="center"><font size="2"><?= number_format(0,2) ?></font></td>

              <td align="center"><font size="2"><?= number_format($dataf['qap_it'],2) ?></font></td>
              <td align="center"><font size="2"><?= number_format($dataf['qap_vt'],2) ?></font></td>

              <td align="center"><font size="2"><?= number_format($dataf['sawt_it'],2) ?></font></td>
              <td align="center"><font size="2"><?= number_format($dataf['sawt_vt'],2) ?></font></td>

              <td align="center"><font size="2"><?= number_format($dataf['vatable_expense'],2) ?></font></td>
              <td align="center"><font size="2"><?= number_format($dataf['non_vatable_expense'],2) ?></font></td>
            </tr> 

            <?php    
              }
            ?>



        <tr>
              <td align="center"><font size="2" style="font-weight:bold;">TOTAL</font></td>

              <td align="center"><font size="2" style="font-weight:bold;"><?= number_format($vatable_sales_overall_total,2) ?></font></td>
              <td align="center"><font size="2" style="font-weight:bold;"><?= number_format($vatable_government_sales_overall_total,2) ?></font></td>
              <td align="center"><font size="2" style="font-weight:bold;"><?= number_format($zero_rated_sales_overall_total,2) ?></font></td>
              <td align="center"><font size="2" style="font-weight:bold;"><?= number_format($exempt_sales_overall_total,2) ?></font></td>


              <td align="center"><font size="2" style="font-weight:bold;"><?= number_format(0,2) ?></font></td>

              <td align="center"><font size="2" style="font-weight:bold;"><?= number_format($qap_it_overall_total,2) ?></font></td>
              <td align="center"><font size="2" style="font-weight:bold;"><?= number_format($qap_vt_overall_total,2) ?></font></td>

              <td align="center"><font size="2" style="font-weight:bold;"><?= number_format($sawt_it_overall_total,2) ?></font></td>
              <td align="center"><font size="2" style="font-weight:bold;"><?= number_format($sawt_vt_overall_total,2) ?></font></td>

              <td align="center"><font size="2" style="font-weight:bold;"><?= number_format($vatable_expense_overall_total,2) ?></font></td>
              <td align="center"><font size="2" style="font-weight:bold;"><?= number_format($non_vatable_expense_overall_total,2) ?></font></td>
        </tr> 

          </table>

<br>

<table border="0" width="50%">
  <tr>
    <td width="5%" align="center" style="font-weight:bold;">VS&nbsp;:</td>
    <td>Vatable sales</td>
  </tr>
  <tr>
    <td width="5%" align="center" style="font-weight:bold;">GS&nbsp;:</td>
    <td>Government sales</td>
  </tr>
  <tr>
    <td width="5%" align="center" style="font-weight:bold;">ZS&nbsp;:</td>
    <td>Zero rated sales</td>
  </tr>
  <tr>
    <td width="5%" align="center" style="font-weight:bold;">ES&nbsp;:</td>
    <td>Exempt sales</td>
  </tr>
</table>
