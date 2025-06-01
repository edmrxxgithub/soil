<?php 
include_once 'connectdb.php';

$q1_vatable_sales = $_POST['q1_vatable_sales'];
$q1_government_sales_principal = $_POST['q1_government_sales_principal'];
$q1_zero_rated_sales_principal = $_POST['q1_zero_rated_sales_principal'];
$q1_exempt_sales_principal = $_POST['q1_exempt_sales_principal'];


// echo $q1_vatable_sales.' '.$q1_government_sales_principal.' '.$q1_zero_rated_sales_principal.' '.$q1_exempt_sales_principal;

$total1 = $q1_vatable_sales - $q1_government_sales_principal - $q1_zero_rated_sales_principal;
$total1_new = $q1_vatable_sales - $q1_government_sales_principal;
$total1_percent = $total1_new * 0.12;
$total2_percent = $q1_government_sales_principal * 0.12;
$total3_percent = $total1_percent + $total2_percent;
$total_sales_principal = $q1_vatable_sales + $q1_exempt_sales_principal;



$output['q1_vatable_sales_principal'] = number_format($total1,2);
$output['q1_total_sales_principal'] = number_format($total_sales_principal,2);
$output['q1_vatable_sales_accessory'] = number_format($total1_percent,2);
$output['q1_government_sales_accessory'] = number_format($total2_percent,2);
$output['q1_total_sales_accessory'] = number_format($total3_percent,2);

echo json_encode($output);

?>