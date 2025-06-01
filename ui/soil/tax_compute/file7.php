<?php 
include_once '../connectdb.php';
include_once 'function2.php';


$year_now = $_POST['year_now'];
$branch_id = $_POST['branch_id'];
$date_from = $_POST['date_from'];
$date_to = $_POST['date_to'];
$quarter_num = 1;

$vatable_sales = fetch_vatable_sales($pdo,$date_from,$date_to,$branch_id);
$vatable_purchase = fetch_vatable_purchase($pdo,$date_from,$date_to,$branch_id);
$vatable_expense = fetch_vatable_expense($pdo,$date_from,$date_to,$branch_id);
$calculated_risk = fetch_calculated_risk($pdo,$branch_id,$year_now,$quarter_num);


$select = $pdo->prepare("SELECT * FROM tb_tax_return_by_quarter WHERE quarter_num = '$quarter_num' AND branch_id = '$branch_id' AND year_num = '$year_now' ");
$select->execute();
$rowselect = $select->fetch(PDO::FETCH_OBJ);

$payment_risk = $rowselect->payment_risk;

$domestic_purchase = $vatable_purchase + $vatable_expense;
$total_as_is_payment = $vatable_sales - $domestic_purchase ;
$total_as_is_payment_percent = $total_as_is_payment * 0.12;

$calculated_risk_percent = $total_as_is_payment_percent - $payment_risk;
$calculated_risk_no_percent = $calculated_risk_percent / 0.12;

$benchmark = (($payment_risk) / $vatable_sales) * 100;

// $difference_total_as_is_payment_percent = $total_as_is_payment_percent ;

$array['sales'] = number_format($vatable_sales,2);
$array['sales_percent'] = number_format($vatable_sales * 0.12,2);

$array['domestic_purchase']= number_format($domestic_purchase,2);
$array['domestic_purchase_percent']= number_format($domestic_purchase * 0.12,2);

$array['calculated_risk']= number_format($calculated_risk_no_percent,2);
$array['calculated_risk_percent']= number_format($calculated_risk_percent,2);

$array['total_as_is_payment_percent']= $payment_risk;
$array['benchmark'] = number_format($benchmark,2).'%';

echo json_encode($array);


?>