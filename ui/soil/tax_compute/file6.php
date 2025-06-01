<?php 
include_once '../connectdb.php';
include_once 'function2.php';

$year_now = $_POST['year_now'];
$branch_id = $_POST['branch_id'];
$date_from = $_POST['date_from'];
$date_to = $_POST['date_to'];
$quarter_num = 1;
$totalnumber_q1 = $_POST['totalnumber_q1'];



$vatable_sales = fetch_vatable_sales($pdo,$date_from,$date_to,$branch_id);
$vatable_purchase = fetch_vatable_purchase($pdo,$date_from,$date_to,$branch_id);
$vatable_expense = fetch_vatable_expense($pdo,$date_from,$date_to,$branch_id);
$calculated_risk = fetch_calculated_risk($pdo,$branch_id,$year_now,$quarter_num);


$domestic_purchase = $vatable_purchase + $vatable_expense;
$total_as_is_payment = $vatable_sales - $domestic_purchase;
$total_as_is_payment_percent = $total_as_is_payment * 0.12;

// $difference_total_as_is_payment_percent = $totalnumber_q1 - $total_as_is_payment_percent;
$difference_total_as_is_payment_percent = $total_as_is_payment_percent - $totalnumber_q1;

$difference_total_as_is_payment_no_percent = $difference_total_as_is_payment_percent / 0.12;

$benchmark = ($totalnumber_q1 / $vatable_sales) * 100;

$array['calculated_risk_percent'] = number_format($difference_total_as_is_payment_percent,2);
$array['calculated_risk_no_percent'] = number_format($difference_total_as_is_payment_no_percent,2);
$array['benchmark'] = number_format($benchmark,2).'%';
echo json_encode($array);


?>