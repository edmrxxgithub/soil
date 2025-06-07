<?php

function fetch_vatable_sales($pdo,$date_from,$date_to,$branchid)
{
  $total = 0;

  $select = $pdo->prepare("SELECT SUM(net_amount) as total_net_amount FROM tb_tax_sales WHERE date BETWEEN '$date_from' AND '$date_to' AND branch_id = '$branchid' AND vat_percent != 0 ");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);

  if ($row) 
  {
    $total = $row->total_net_amount;
  }
  else
  {
    $total = 0;
  }

  return $total;

}


function fetch_vatable_purchase($pdo,$date_from,$date_to,$branchid)
{

  $select = $pdo->prepare("SELECT SUM(net_amount) as total_net_amount FROM tb_tax_purchase WHERE date BETWEEN '$date_from' AND '$date_to' AND branch_id = '$branchid'  ");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);

  if ($row) 
  {
    $total = $row->total_net_amount;
  }
  else
  {
    $total = 0;
  }

  return $total;
}


function fetch_vatable_expense($pdo,$date_from,$date_to,$branchid)
{
  $select = $pdo->prepare("SELECT SUM(net_amount) as total_net_amount FROM tb_tax_vat_purchase WHERE date BETWEEN '$date_from' AND '$date_to' AND branch_id = '$branchid'  ");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);


  if ($row) 
  {
    $total = $row->total_net_amount;
  }
  else
  {
    $total = 0;
  }

  return $total;
}

function fetch_per_quarter_data($pdo,$yearnow,$branchid,$monthfrom,$monthto,$quarter_num)
{


// Define date range
$date_from = "$yearnow-$monthfrom-1";
$last_day = date("t", strtotime("$yearnow-$monthto-1"));
$date_to = "$yearnow-$monthto-$last_day";

// Check if data for the quarter exists
$stmt = $pdo->prepare("SELECT * FROM tb_tax_return_by_quarter WHERE quarter_num = ? AND branch_id = ? AND year_num = ?");
$stmt->execute([$quarter_num, $branchid, $yearnow]);
$quarter_data = $stmt->fetch(PDO::FETCH_OBJ);

$payment_risk = $quarter_data ? $quarter_data->payment_risk : 0;

// Get financial data
$vatable_sales = fetch_vatable_sales($pdo, $date_from, $date_to, $branchid);
$vatable_purchase = fetch_vatable_purchase($pdo, $date_from, $date_to, $branchid);
$vatable_expense = fetch_vatable_expense($pdo, $date_from, $date_to, $branchid);

$domestic_purchase = $vatable_purchase + $vatable_expense;

$totalpaidrisk_no_percent = $vatable_sales - $domestic_purchase;
$totalpaidrisk_percent = $totalpaidrisk_no_percent * 0.12;

// Initialize result variables
$calculated_risk_no_percent = 0;
$calculated_risk_percent = 0;
$benchmark = 0;

// Perform risk and benchmark calculations
  if ($quarter_data && $vatable_sales != 0) 
  {
      $calculated_risk_percent = $totalpaidrisk_percent - $payment_risk;
      $calculated_risk_no_percent = $calculated_risk_percent / 0.12;
      $benchmark = ($payment_risk / $vatable_sales) * 100;
  } 
  elseif ($vatable_sales != 0) 
  {
      $benchmark = ($totalpaidrisk_percent / $vatable_sales) * 100;
  }

  // Build result array
  return 
  [
      'vatable_sales' => $vatable_sales,
      'domestic_purchase' => $domestic_purchase,
      'datefrom' => $date_from,
      'dateto' => $date_to,
      'calculated_risk_no_percent' => $calculated_risk_no_percent,
      'calculated_risk_percent' => $calculated_risk_percent,
      'totalpaidrisk_no_percent' => $totalpaidrisk_no_percent - $calculated_risk_no_percent,
      'totalpaidrisk_percent' => $totalpaidrisk_percent - $calculated_risk_percent,
      'benchmark' => $benchmark,
      'payment_risk' => $payment_risk,
      'dateinfo' => $date_from.' '.$date_to
  ];


  // return $date_from.''.$date_to;

}


?>